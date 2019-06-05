<template>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div id="store-coupons">
                    <a href="#" id="MyCouponsLink" v-if="auth">My Coupons</a>
                    <coupons-component></coupons-component>
                </div>
                <div id="my-coupons" style="display: none;">
                    <a href="#" id="AllCouponsLink">All Coupons</a>
                    <my-coupons-component></my-coupons-component>
                </div>
            </div>
            <div class="col-md-4" id="RegisterForm">
                <register-component></register-component>
                <a href="#" class="float-right" id="ForgotPinLink">Forgot Pin</a>
            </div>
            <div class="col-md-4" id="LoginForm" style="display: none;">
                <login-component></login-component>
                <a href="#" class="float-right" id="ForgotPinLink2">Forgot Pin</a>
            </div>
            <div class="col-md-4" id="ForgotPin" style="display: none;">
                <forgot-pin-component></forgot-pin-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                coupons: [],
                auth: false
            }
        },
        mounted() {
            axios.get('/ava_coupons').then((response) => {
                this.coupons = response.data;
            });
        },
        methods: {

        }
    }
</script>
