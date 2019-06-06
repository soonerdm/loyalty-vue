<template>
    <div class="row row-eq-height">
        <div v-for="o in $parent.coupons.Offers" class="col-lg-4 col-md-6 col-sm-6 mb-3" :key="o.RSAOfferId">
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
                    <a href="#" class="btn btn-block btn-primary" @click="add( o.RSAOfferId, o.CategoryId )" v-if="clipButton"><i class="fa fa-cut"></i> Clip Coupon</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                clipButton: true
            }
        },
        mounted() {

        },
        methods: {
            add: function (coupon_id, CategoryId){
                let self = this;
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
                        axios.get('/my_coupons').then((coupons) => {
                            self.$parent.clipped = coupons.data;
                        });
                    }
                }).catch(function (error){
                    console.log(error.data);
                  });
            }
        }
     }

</script>

<style scoped>

</style>
