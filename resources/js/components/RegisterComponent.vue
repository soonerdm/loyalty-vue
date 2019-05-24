<template>
    <div class="card">
        <div class="card-header bg-primary text-white">Register Here
            <a href="#" id="SignInLink" class="text-white float-right">Sign In</a>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="FirstName">First Name</label>
                <input class="form-control" name="FirstName" v-model="FirstName" id="FirstName" type="text">
            </div>
            <div class="form-group">
                <label for="LastName">Last Name</label>
                <input name="LastName" class="form-control" v-model="LastName" id="LastName" type="text">
            </div>
            <div class="form-group">
                <label for="UserName">Email</label>
                <input class="form-control" name="UserName" v-model="UserName" id="UserName" type="text">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" id="password" name="Password" v-model="Password" type="password">
            </div>
            <div class="form-group">
                <label for="zipcode">Zip Code</label>
                <input class="form-control" id="zipcode" name="ZipCode" v-model="ZipCode" type="text">
            </div>
            <button type="submit" class="btn btn-primary" v-on:click="Register()"> Register</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RegisterComponent.vue",
        data: function () {
            return {FirstName: '', LastName: '', UserName: '', Password: '', ZipCode: '', auth: false};
        },
        methods: {
            Register() {
                axios.post('/register', {
                    ZipCode: this.ZipCode,
                    FirstName: this.FirstName,
                    LastName: this.LastName,
                    UserName: this.UserName,
                    Password: this.Password,
                    store_code_login: this.store_code_login
                }).then(function(response){
                    console.log(response);
                })
            }
        }
    }
</script>

<style scoped>

</style>
