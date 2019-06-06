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
                <label for="password">Pin</label>
                <input class="form-control" id="password" name="Password" maxlength="4" v-model="Password" ref="Password" type="password">
            </div>
            <div class="form-group">
                <label for="Password2">Confirm Pin</label>
                <input class="form-control" id="Password2" name="Password2" maxlength="4" v-model="Password2" type="password" v-on:blur="checkpass()">
            </div>
            <div class="form-group">
                <label for="ClientStore">Preferred Store</label>
                <select name="ClientStore" id="ClientStore" class="form-control" >
                    <option v-for="store in stores" v-bind:value="store.ClientStoreId">{{store.ClientStoreName}}</option>
                </select>

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
            return {FirstName: '', LastName: '', UserName: '', ClientStore: '', Password: '', ZipCode: '', Password2: '', stores: []};
        },
        mounted() {
            axios.post('/get_stores').then((response) => {
                this.stores = response.data.GetClientStores;
              //  console.log(response.data.GetClientStores);
            });
        },
        methods: {
            Register() {
                if(this.Password.length !== 4){
                    alert('Pin Must be 4 digits');
                    return false;
                }
                else {
                    axios.post('/register_app', {
                        ZipCode: this.ZipCode,
                        FirstName: this.FirstName,
                        LastName: this.LastName,
                        UserName: this.UserName,
                        Password: this.Password,
                        ClientStore: this.ClientStore
                    }).then(function (response) {
                        console.log(response.data.ErrorMessage);
                        if (response.data.ErrorMessage.ErrorCode === 1) {
                            alert('Successfully Registered. Please Login');
                            $("#RegisterForm").hide();
                            $("#LoginForm").show();
                            $("#ForgotPin").hide();

                        }
                        else {
                            alert(response.data.ErrorMessage.ErrorDetails);
                        }
                    })
                }
            },
            checkpass(){
                if(this.Password !== this.Password2){
                    alert('Pins Do Not Match');
                    this.$refs.Password.focus();
                    return false;
                }
            }
        }
    }
</script>

<style scoped>

</style>
