<template>
    <div class="card">
        <div class="card-header bg-primary text-white">Login Here
            <a href="#" class="text-white float-right" id="RegisterLink">Register</a>
        </div>
        <div class="card-body">
                <div class="form-group">
                    <label for="UserNameLogin">User Name</label>
                    <input class="form-control" name="UserNameLogin" v-model="UserNameLogin" type="text" id="UserNameLogin">
                </div>
                <div class="form-group">
                    <label for="PasswordLogin">Password</label>
                    <input type="password" name="PasswordLogin" maxlength="4" v-model="PasswordLogin" id="PasswordLogin" class="form-control">
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
                logged: false
            };
        },
        methods:{
            login(){
                let self = this;
                if (this.UserNameLogin !== '' || this.PasswordLogin !== ''){
                    axios.post('/validate', {
                        UserName: this.UserNameLogin,
                        Password: this.PasswordLogin
                    }).then(function(response){
                        console.log(response.data);
                        if (response.data.ErrorMessage.ErrorCode === 1){
                            self.logged= true;
                            self.UserNameLogin= '';
                            self.PasswordLogin ='';
                            self.$parent.auth = true;
                            self.$parent.user = response.data;
                            axios.get('/my_coupons').then((coupons) => {
                                self.$parent.clipped = coupons.data;
                            });
                            alert('Logged In');
                        } else {
                            alert(response.data);
                        }
                    })
                } else {
                    alert('All fields required');
                }
            }
        }
    }
</script>

<style scoped>

</style>
