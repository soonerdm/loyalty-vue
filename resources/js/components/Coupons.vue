<template>
    <div class="row row-eq-height">
        <div v-for="o in coupons.Offers" class="col-lg-4 col-md-6 col-sm-6 mb-3" :key="o.RSAOfferId">
            <div class="card h-100">
                <div class="mt-3 text-center">
                    <img :src="o.ImagePath" class="card-img-top rounded" style="max-height: 150px; max-width: 150px;"/>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ o.ProductName }}</h5>
                    <p class="card-text">
                        {{ o.Title }}<br />
                        <!--<small><b>Valid: {{ O.ValidFrom }} to {{ O.ExpiresOn }}</b></small>-->
                    </p>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="#" class="btn btn-block btn-primary" @click="add( o.RSAOfferId, o.CategoryId )" v-if="clipButton">Clip Coupon</a>
                </div>
            </div>
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
                    console.log(response);
                    if (response.data.ErrorMessage === "No MemberNumber"){
                        alert('You must be logged in');
                    }
                    else {
                        alert('Coupon Clipped');
                        this.clipButton = false;
                    }
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
