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
                    <div class="text-right w-100">
                        <a href="/contact">Contact Us</a> |
                        <a href="#" id="ForgotPinLink">Forgot Pin</a> &nbsp;
                    </div>
                </div>
                <div id="ForgotPin" v-if="!auth" style="display: none;">
                    <forgot-pin-component></forgot-pin-component>
                </div>
                <div v-show="auth">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-user-circle"></i> Welcome, {{ user.FirstName }}!
                            <a href="#" id="SignOut" class="text-white float-right" v-on:click="signOut">Sign Out</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <dt>Member #</dt>
                                    <dd>{{ user.MemberNumber }}</dd>
                                </div>
                                <div class="col-6">
                                    <dt>Total Savings</dt>
                                    <dd>${{ user.TotalSavingsAmount }}</dd>
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
                                    <tr>
                                        <td class="text-muted" v-if="clipped.UserClips === undefined || clipped.UserClips.length == 0">You have no clipped coupons.</td>
                                    </tr>
                                    <tr v-for="c in clipped.UserClips" :key="c.RSAOfferId">
                                        <td>{{ c.Title }}<br /><small>{{ c.Details }}</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right w-100">
                        <a href="/contact">Contact Us</a> &nbsp;
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7 order-2 order-md-1">
                <div class="w-100 mb-3 text-right">
                    <input class="form-control" type="text" name="search" id="search" v-model="search" placeholder="Filter By Keyword" style="width: 200px">
                </div>
                <div id="store-coupons">
                    <coupons-component></coupons-component>
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
                search: ''
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
                    alert('You have been logged out due to inactivity. Please log in again.');
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
