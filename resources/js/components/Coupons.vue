<template>
    <div class="row row-eq-height">
        <div class="w-100 text-center" v-show="$parent.loading">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="w-100 text-muted text-center" v-show="!$parent.filteredCoupons.length && $parent.search">No coupons found.</div>
        <div  v-for="o in $parent.filteredCoupons.slice(0, couponsToShow)" class="col-12 col-sm-12 col-md-6 col-lg-4 mb-3" :key="o.RSAOfferId">
            <div class="card h-100">
                <div class="product-img" :style="{ backgroundImage: `url('${o.ImagePath}')` }">
                    <img src="/img/transparent.png" class="card-img-top rounded">
                </div>
                <!--<div class="mt-3 text-center">-->
                    <!--<img :src="o.ImagePath" class="card-img-top rounded" style="max-height: 150px; max-width: 150px;"/>-->
                <!--</div>-->
                <div class="card-body">
                    <h5 class="card-title">{{ o.ProductName }}</h5>
                    <p class="card-text">
                        <span class="text-danger font-weight-bold">{{ o.Title }}</span><br />
                        <small>{{ o.Details }}</small>
                        <!--<small><b>Valid: {{ O.ValidFrom }} to {{ O.ExpiresOn }}</b></small>-->
                    </p>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a class="btn btn-block btn-primary text-white" @click="add( o.RSAOfferId, o.CategoryId )" v-if="clipButton" style="cursor: pointer">
                        <i class="fa fa-cut"></i> Clip Coupon
                    </a>
                </div>
            </div>

        </div>
        <div class="text-center w-100 mb-3">
            <button class="btn btn-success text-center" v-if="$parent.filteredCoupons.length > 15 && couponsToShow < $parent.filteredCoupons.length" @click="loadMore">
                Show more coupons
            </button>
        </div>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                clipButton: true,
                couponsToShow: 15
            }
        },
        mounted() {

        },
        methods: {
            add: function (coupon_id, CategoryId){
                let self = this;
                if (self.$parent.auth === true) {
                    axios.post('/clip_offer', {
                        RSAOfferId: coupon_id,
                        CategoryId: CategoryId
                    }).then(function (response){
                        if (response.data.ErrorMessage === "No MemberNumber"){
                            Notify('You must be logged in!', null, null, 'danger');
                        }
                        else {
                            Notify('Coupon clipped!', null, null, 'success');
                            axios.get('/my_coupons').then((coupons) => {
                                self.$parent.clipped = coupons.data;
                                localStorage.clipped = JSON.stringify(coupons.data);
                            });
                        }
                    }).catch(function (error){
                        Notify('There was an error. Please try again.', null, null, 'danger');
                    });
                } else {
                    Notify('You must be logged in to do that.', null, null, 'danger');
                }
            },

            loadMore(){

                this.couponsToShow += 15;
            }

        }
     }

</script>

<style scoped>

</style>
