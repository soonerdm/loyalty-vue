<template>
    <div class="card">
        <div class="card-header bg-primary">Login Here
            <span class="float-right" title="No Login? Register here"><a href="#" style="color: #FFF" id="RegisterLink">Register</a></span>
        </div>
        <div class="card-body">
            <div v-if="auth" class="bg-success">Logged In Succesfully</div>
                <div class="form-group">
                    <label for="UserNameLogin">User Name</label>
                    <input class="form-control" name="UserNameLogin" v-model="UserNameLogin" type="text" id="UserNameLogin">
                </div>
                <div class="form-group">
                    <label for="PasswordLogin">Password</label>
                    <input type="password" name="PasswordLogin" v-model="PasswordLogin" id="PasswordLogin" class="form-control">
                    <input type="hidden" name="store_code_login" v-model="store_code_login" value="3501">
                </div>
                <div class="form-group">
                    <button type="submit" id="SubmitButton" class="btn btn-primary" v-on:click="login()">Login</button>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LoginComponent.vue",
        data: function () {
            return {
                UserNameLogin: '',
                PasswordLogin: '',
                store_code_login: '',
                auth: false
            };
        },
        methods:{
            login(){
                let self = this;
                if (this.UserNameLogin !== '' || this.PasswordLogin !== ''){
                    axios.post('/validate', {
                        UserName: this.UserNameLogin,
                        Password: this.PasswordLogin,
                        store_code_login: this.store_code_login
                    }).then(function(response){
                        console.log(response.data);
                        if (response.data.ErrorMessage.ErrorCode === 1){
                            self.auth = true;
                            self.UserNameLogin= '';
                            //alert('Logged In')
                        } else {
                            alert(response.data);
                        }
                    })
                } else {
                    alert('You gotta fill in the fields')
                }
            }
        }
    }
</script>

<style scoped>

</style>
