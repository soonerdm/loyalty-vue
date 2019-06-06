<template>
    <div class="container mt-4">
        <!--<p>coupons: <pre>{{ coupons }}</pre></p>-->
        <div class="row">
            <div class="col-md-8">
                <div id="store-coupons">
                    <coupons-component></coupons-component>
                </div>
            </div>
            <div class="col-md-4" id="RegisterForm" v-if="!auth">
                <register-component></register-component>
                <a href="#" class="float-right" id="ForgotPinLink">Forgot Pin</a>
            </div>
            <div class="col-md-4" id="LoginForm" v-if="!auth" style="display: none;">
                <login-component></login-component>
                <a href="#" class="float-right" id="ForgotPinLink2">Forgot Pin</a>
            </div>
            <div class="col-md-4" id="ForgotPin" v-if="!auth" style="display: none;">
                <forgot-pin-component></forgot-pin-component>
            </div>
            <div class="col-md-4" v-show="auth">
                <div class="card">
                    <div class="card-header bg-primary text-white"><i class="fa fa-user-circle"></i> Welcome, {{ user.FirstName }}!</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <dt>Member Number</dt>
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
                            <tr><th colspan="2" class="text-center"><i class="fa fa-cut"></i> My Clipped Coupons</th></tr>
                            </thead>
                            <tbody>
                            <tr v-for="c in clipped.UserClips" :key="c.RSAOfferId">
                                <td>{{ c.Title }}<br /><small>{{ c.Details }}</small></td>
                                <td><button class="btn btn-sm btn-danger"><b>&times;</b></button></td>
                            </tr>
                            </tbody>
                        </table>
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
                clipped: []
            }
        },
        mounted() {
            axios.get('/ava_coupons').then((response) => {
                this.coupons = response.data.Offers;
            });
        },
        methods: {

        }
    }
</script>
