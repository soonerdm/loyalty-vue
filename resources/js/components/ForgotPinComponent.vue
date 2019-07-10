<template>
    <div class="card">
        <div class="card-header bg-primary text-white">Forgot Password
            <a href="#" class="btn btn-sm btn-outline-light float-right" id="LoginLink">Sign In</a>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="UserNamePin">User Name</label>
                <input class="form-control" name="UserNamePin" v-model="UserNamePin" type="text" id="UserNamePin">
            </div>
            <div class="form-group">
                <button type="submit" id="SubmitButton" class="btn btn-primary" v-on:click="forgotPin()">Email Reset Link</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ForgotPinComponent.vue",
        data: function () {
            return {
                UserNamePin: ''
            }
        },
        methods: {
            forgotPin() {
                axios.post('/forgot_pin', {
                    UserName: this.UserNamePin

                }).then(function (response) {
                    console.log(response.data);
                    if(response.data.ErrorMessage.ErrorCode ===1){
                       Notify('An email has been sent to that email address to reset your pin', null, null, 'success');
                    }
                    else{
                        Notify('An error occurred, please try again!', null, null, 'danger');
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
