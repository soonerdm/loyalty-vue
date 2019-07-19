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
                <div class="rounded-bottom bg-success text-white text-center p-1 ml-2 w-50 featured" v-if="o.IsFeatured"><i class="fa fa-flag"></i> Featured!</div>
                <div class="product-img" :style="{ backgroundImage: `url('${o.ImagePath}')` }">
                    <img src="/img/transparent.png" class="card-img-top rounded">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ pName(o.ProductName) }}</h5>
                    <p class="card-text">
                        <span class="text-danger font-weight-bold">{{ o.Title }}</span><br /><br />
                        <small>{{ o.Details }}</small><br /><br />
                        <span style="font-size: 8px;">Exp. {{ expDate(o.ExpiresOn) }}</span>
                    </p>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <button class="btn btn-block btn-primary text-white" @click="add( o.RSAOfferId, o.CategoryId )" :disabled="checkClipped(o.RSAOfferId)">
                        <span v-if="!checkClipped(o.RSAOfferId)"><i class="fa fa-cut"></i> Clip Coupon</span>
                        <span v-if="checkClipped(o.RSAOfferId)"><i class="fa fa-check"></i> Clipped!</span>
                    </button>
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
                couponsToShow: 15
            }
        },
        methods: {
            add: function (coupon_id, CategoryId){
                let self = this;
                if (self.$parent.auth) {
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
            },
            pName(nm){
                if (nm === 'Group'){
                    return '';
                }
                else{
                    return nm;
                }
            },
            expDate(date){
                let ms = date.substring(
                    date.lastIndexOf("(") + 1,
                    date.lastIndexOf("+")
                );
                ms = parseInt(ms);
                let formatted = new Date(ms);
                let day = formatted.getDate();
                let mon = formatted.getMonth() + 1;
                let year = formatted.getFullYear();
                return mon + '/' + day + '/' + year;
            },
            checkClipped(id){
                if (this.$parent.clipped !== undefined) {
                    let clipped = this.$parent.clipped.UserClips;
                    let found = false;
                    for (var i in clipped) {
                        if (parseInt(clipped[i].RSAOfferId) === parseInt(id)) {
                            found = true;
                            break;
                        }
                    }
                    return found;
                }
            }
        }
     }

</script>

<style scoped>

</style>
