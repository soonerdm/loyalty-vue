<template>
    <div class="card">
        <div class="card-header bg-primary text-white">Sign In
            <a href="#" class="btn btn-sm btn-outline-light float-right" id="RegisterLink">Register</a>
        </div>
        <div class="card-body">
            <form v-on:submit.prevent="login()">
                <label for="UserNameLogin">User Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle"></i></span>
                    </div>
                    <input class="form-control" name="UserNameLogin" v-model="UserNameLogin" type="text" id="UserNameLogin" required>
                </div>
                <label for="PasswordLogin">Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                    </div>
                    <input type="password" name="PasswordLogin" maxlength="4" v-model="PasswordLogin" id="PasswordLogin" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" id="SubmitButton" class="btn btn-primary">Login</button>
                </div>
            </form>
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
                logged: false,
                loading: false,
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
                        self.$parent.loadingClipped = true;
                        if (response.data.ErrorMessage.ErrorCode === 1){
                            self.logged= true;
                            self.UserNameLogin= '';
                            self.PasswordLogin ='';
                            self.$parent.auth = true;
                            localStorage.auth = true;
                            self.$parent.user = response.data;
                            localStorage.user = JSON.stringify(response.data);
                            var cur = new Date();
                            localStorage.timestamp = cur.getTime();
                            axios.get('/my_coupons').then((coupons) => {
                                self.$parent.loadingClipped = false;
                                if(coupons.data.ErrorMessage.ErrorCode !== -1) {
                                    self.$parent.clipped = coupons.data;
                                    localStorage.clipped = JSON.stringify(coupons.data);
                                }
                            });
                        } else {
                            Notify('An error occurred, please try again!', null, null, 'danger');
                        }
                    })
                } else {
                    Notify('All field are required!', null, null, 'danger');
                }
            }
        }
    }
</script>

<style scoped>

</style>
