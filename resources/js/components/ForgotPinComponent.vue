<template>
    <div class="card">
        <div class="card-header bg-primary text-white">Forgot Pin
            <a href="#" class="text-white float-right" id="LoginLink">Sign In</a>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="UserNamePin">User Name</label>
                <input class="form-control" name="UserNameLogin" v-model="UserNamePin" type="text" id="UserNamePin">
            </div>
            <div class="form-group">
                <button type="submit" id="SubmitButton" class="btn btn-primary" v-on:click="forgotPin()">Send Pin Reset Link</button>
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
                    alert(response.data.ErrorMessage.ErrorDetails);
                });
            }
        }
    }
</script>

<style scoped>

</style>
