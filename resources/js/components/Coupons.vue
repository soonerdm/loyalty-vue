<template>
    <div class="row">
<!--   <pre>{{coupons.Offers | json}}</pre>-->
        <div v-for="O in coupons.Offers" class="col" :key="O.RSAOfferId">
            <div>{{O.Title}}</div>
                <img :src="O.ImagePath" width="150"><br>

            <button class="btn btn-success" @click="add( O.RSAOfferId, O.CategoryId )" v-if="clipButton">Clip Coupon</button>
        </div>
    </div>
</template>

<script>
    /*export default {
        name: "Coupons"
    }
    */

    export default {

        data() {
            return {
                coupons: [],
                clipButton: true
            }
        },

        mounted() {
            axios.get('/ava_coupons').then((response) => {
                this.coupons = response.data;
            });
        },

        methods: {
            add: function (coupon_id, CategoryId){

                axios.post('/clip_offer', {
                    RSAOfferId: coupon_id,
                    CategoryId: CategoryId
                })
                    .then(function (response){
                        console.log(response.data);
                        alert('Coupon Clipped');
                        this.clipButton = false;

                    })
                    .catch(function (error){
                        console.log(error.data);
                    });
                //alert(coupon_id);
            }
        }

     }

</script>

<style scoped>

</style>
