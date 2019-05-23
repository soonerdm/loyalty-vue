<template>
    <div class="row">
        <div v-for="UC in myCoupons.UserClips" class="col" :key="UC.RSAOfferId">
            <div>{{UC.Title}}</div><br />
        </div>
    </div>
</template>

<script>
    export default {
        name: "MyCouponsComponent.vue",
        data() {
            return {
                myCoupons: []
            }
        },
        mounted() {
            axios.get('/my_coupons').then((response) => {
                this.myCoupons = response.data;
                console.log(this.myCoupons);
            });
        },
    }
</script>

<style scoped>

</style>
