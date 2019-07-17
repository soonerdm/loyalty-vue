<template>
    <div class="container mt-4">
        <div id="notifications"></div>
        <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-12 order-1 order-md-12 mb-3">
                <div id="RegisterForm" v-if="!auth" style="display: none;">
                    <register-component></register-component>
                </div>
                <div id="LoginForm" v-if="!auth">
                    <login-component></login-component>
                    <div class="text-right w-100 mt-1">
                        <a href="/contact">Contact Us</a> |
                        <a href="#" id="ForgotPinLink">Forgot Password</a> &nbsp;
                    </div>
                </div>
                <div id="ForgotPin" v-if="!auth" style="display: none;">
                    <forgot-pin-component></forgot-pin-component>
                </div>
                <div v-show="auth">
                    <div class="card" id="print-card">
                        <div class="card-header bg-primary text-white">
                            <span class="user-info"><i class="fa fa-user-circle"></i> {{ user.FirstName }} {{ user.LastName }}</span>
                            <a href="#" id="SignOut" class="btn btn-sm btn-outline-light float-right" v-on:click="signOut">Sign Out</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <dt>Member #</dt>
                                    <dd><small>{{ user.MemberNumber }}</small></dd>
                                </div>
                                <div class="col-6">
                                    <dt>Total Savings</dt>
                                    <dd><small>${{ user.TotalSavingsAmount }}</small></dd>
                                </div>
                                <div class="col-12">
                                    <dt>Store <!-- - <small><a href="#" data-toggle="modal" data-target="#changeStoreModal">Change</a></small> --></dt>
                                    <dd><small>{{ user.ClientStoreName }}</small></dd>
                                </div>
                                <div class="col-12 mb-3">
                                    <dt>Bar Code</dt>
                                    <img :src="user.MyCardBarCodeImagePath" class="img-fluid" />
                                </div>
                            </div>
                            <table class="table table-condensed">
                                <thead>
                                    <tr><th class="text-center"><i class="fa fa-cut"></i> My Clipped Coupons</th></tr>
                                </thead>
                                <tbody>
                                    <tr v-if="loadingClipped">
                                        <td class="text-center">
                                            <div class="spinner-border spinner-border-sm text-secondary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!loadingClipped">
                                        <td class="text-muted" v-if="clipped.UserClips === undefined || clipped.UserClips.length == 0">You have no clipped coupons.</td>
                                    </tr>
                                    <tr v-for="c in clipped.UserClips" :key="c.RSAOfferId">
                                        <td>{{ c.Title }}<br /><small>{{ c.Details }}</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right mt-1 w-100">
                        <a href="#" onclick="window.print()">Print Card</a> |
                        <a href="/contact">Contact Us</a> &nbsp;
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7 order-2 order-md-1">
                <div class="input-group mb-3" style="width: 250px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                    </div>
                    <input class="form-control" type="text" name="search" id="search" v-model="search" placeholder="Filter By Keyword">
                </div>
                <div id="store-coupons">
                    <coupons-component></coupons-component>
                </div>
            </div>
        </div>
        <!-- Change Store Modal -->
        <div class="modal fade" id="changeStoreModal" tabindex="-1" role="dialog" aria-labelledby="changeStoreModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeStoreModalTitle">Change Store</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="storeChange">Preferred Store</label>
                            <select name="storeChange" id="storeChange" v-model="storeChange" class="form-control" required>
                                <option v-for="store in stores" v-bind:value="store.ClientStoreId">{{store.ClientStoreName}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="changeStore()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

    data() {
            return {
                coupons: [],
                auth: false,
                user: {},
                clipped: [],
                loading: false,
                loadingClipped: false,
                search: '',
                stores: [],
                storeChange: ''
            }
        },
        mounted: function() {
            this.loading = true;
            axios.get('/ava_coupons').then((response) => {
                this.loading = false;
                this.coupons = response.data.Offers;
            });
            if (localStorage.auth) {
                this.auth = localStorage.auth;
            }
            if (localStorage.user) {
                this.user = JSON.parse(localStorage.user);
            }
            if (localStorage.clipped) {
                this.clipped = JSON.parse(localStorage.clipped);
            }
            if (localStorage.timestamp) {
                var timeout = (parseInt(localStorage.timestamp) + 3600000);
                var cur = new Date();
                if (parseInt(cur.getTime()) > timeout) {
                    this.auth = false;
                    this.user = {};
                    this.clipped = [];
                    localStorage.clear();
                    Notify('You have been logged out due to inactivity. Please log in again.', null, null, 'danger');
                } else {
                    localStorage.timestamp = cur.getTime();
                }
            }
        },
        methods: {
            signOut: function() {
                this.auth = false;
                this.user = {};
                this.clipped = [];
                localStorage.clear();
                Notify('You have been logged out.', null, null, 'success');
            },
            changeStore: function() {
                console.log('UserToken: ' + this.user.UserToken);
                console.log('ClientStore: ' + this.storeChange);
                axios.post('/update_store', {
                    UserToken: this.user.UserToken,
                    ClientStore: this.storeChange
                }).then(function (response) {
                    console.log(response);
//                    if(response.data.ErrorMessage.ErrorCode === 1) {
//                        Notify('Your preferred store has been updated!', null, null, 'success');
//                    } else if(response.data.ErrorMessage.ErrorCode === -1) {
//                        Notify(response.data.ErrorMessage.ErrorDetails, null, null, 'danger');
//                    }
                })
            }
        },
        computed: {
            filteredCoupons() {
                if (!this.search) { return this.coupons }
                var find = function(object, search) {
                    for (var property in object) {
                        if (object.hasOwnProperty(property)) {
                            if (typeof object[property] === "object"){
                                find(object[property]);
                            } else if (object[property].includes !== undefined){
                                if (object[property].toLowerCase().includes(search.toLowerCase())) return true;
                            }
                        }
                    }
                    return false;
                };
                return this.coupons.filter(coupon => {
                    return find(coupon, this.search)
                });
            }
        }
    }
</script>
