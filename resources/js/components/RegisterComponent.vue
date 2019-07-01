<template>
    <div class="card">
        <div class="card-header bg-primary text-white">Register
            <a href="#" id="SignInLink" class="text-white float-right">Sign In</a>
        </div>
        <div class="card-body">
            <form v-on:submit.prevent="register()">
                <div class="form-group">
                    <label for="FirstName">First Name</label>
                    <input class="form-control" name="FirstName" v-model="FirstName" id="FirstName" type="text" required>
                </div>
                <div class="form-group">
                    <label for="LastName">Last Name</label>
                    <input name="LastName" class="form-control" v-model="LastName" id="LastName" type="text" required>
                </div>
                <div class="form-group">
                    <label for="UserName">Email</label>
                    <input class="form-control" name="UserName" v-model="UserName" id="UserName" type="text" required>
                </div>
                <div class="form-group">
                    <label for="password">Pin</label>
                    <input class="form-control" id="password" name="Password" maxlength="4" v-model="Password" ref="Password" type="password" required>
                </div>
                <div class="form-group">
                    <label for="Password2">Confirm Pin</label>
                    <input class="form-control" id="Password2" name="Password2" maxlength="4" v-model="Password2" type="password" v-on:blur="checkpass()" required>
                </div>
                <div class="form-group">
                    <label for="ClientStore">Preferred Store</label>
                    <select name="ClientStore" id="ClientStore" class="form-control" required>
                        <option v-for="store in stores" v-bind:value="store.ClientStoreId">{{store.ClientStoreName}}</option>
                    </select>

                </div>
                <div class="form-group">
                    <label for="zipcode">Zip Code</label>
                    <input class="form-control" id="zipcode" name="ZipCode" v-model="ZipCode" type="text" required>
                </div>
                <button type="submit" class="btn btn-primary"> Register</button>
            </form>
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
                this.stores = filterOut(response.data.GetClientStores);
                function filterOut(storeArray){
                    let mstore = [];
                    storeArray.forEach(function(store){
                        let full = document.domain;
                        let parts = full.split('.');
                        let d   = parts[1];
                        if(d === 'uptowngroceryco' && (store.ClientStoreName.substring(0,3) === 'Upt')){
                            mstore.push(store);
                        }
                        if(d === 'smartsaverok' && (store.ClientStoreName.substring(0,3) === 'Sma')){
                            mstore.push(store);
                        }
                        if(d === 'buyforlessok'  && ((store.ClientStoreName.substring(0,3) === 'Buy') || (store.ClientStoreName.substring(0,3) === 'Sup'))){
                            mstore.push(store);
                        }

                    });
                    return mstore;
                }
            });
        },
        methods: {
            register() {
                let self = this;
                if(this.Password.length !== 4){
                    Notify('Your Pin must be 4 digits!', null, null, 'danger');
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
                        if(response.data.ErrorMessage.ErrorCode ===1) {
                            Notify('Your account has been registered successfully!', null, null, 'success');
                            self.$parent.user = response.data;
                            self.$parent.auth = true;
                        }
                        if(response.data.ErrorMessage.ErrorCode === -1){
                            Notify(response.data.ErrorMessage.ErrorDetails, null, null, 'danger');
                        }
                    })
                }
            },
            checkpass(){
                if(this.Password !== this.Password2){
                    Notify('Pins Do Not Match', null, null, 'danger');
                    this.$refs.Password.focus();
                    return false;
                }
            }
        }
    }
</script>

<style scoped>

</style>
