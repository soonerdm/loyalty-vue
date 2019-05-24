<template>
    <div class="row">
        <div v-for="O in coupons.Offers" class="col-4" :key="O.RSAOfferId">

            <div class="card mb-3">
                <div class="mt-3 text-center">
                    <img :src="O.ImagePath" class="card-img-top rounded" style="max-height: 150px; max-width: 150px;"/>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ O.ProductName }}</h5>
                    <p class="card-text">
                        {{ O.Title }}<br />
                        <!--<small><b>Valid: {{ O.ValidFrom }} to {{ O.ExpiresOn }}</b></small>-->
                    </p>
                    <a href="#" class="btn btn-primary" @click="add( O.RSAOfferId, O.CategoryId )" v-if="clipButton"><i class="fa fa-cut"></i>Clip Coupon</a>
                </div>
            </div>

            <!--<pre>{{ O | json }}</pre>-->

        </div>
    </div>
</template>

<script>

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
                }).then(function (response){
                    console.log(response.data);
                    alert('Coupon Clipped');
                    this.clipButton = false;
                })
                .catch(function (error){
                    console.log(error.data);
                });
            }
        }
     }

</script>

<style scoped>

</style>
