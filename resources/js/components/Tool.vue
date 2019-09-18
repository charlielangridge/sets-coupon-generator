<template>
    <div class="mb-8">
        <div>
            <div class="flex items-center mb-3">
                <h1 class="flex-no-shrink text-90 font-normal text-2xl">Generate Coupons</h1>
            </div>
            <div class="relative">
                <div class="card mb-6">
                    <div class="flex border-b border-40">
                        <div class="w-1/5 px-8 py-6"><label for="price" class="inline-block text-80 pt-2 leading-tight">
                            Code
                        </label></div>
                        <div class="py-6 px-8 w-1/2">
                            <input id="code" type="text" name="code" v-model="code"
                                   class="w-full form-control form-input form-input-bordered">
                            <div class="help-text help-text mt-2"></div>
                        </div>
                    </div>

                    <div class="flex border-b border-40">
                        <div class="w-1/5 px-8 py-6"><label for="qty" class="inline-block text-80 pt-2 leading-tight">
                            Number of Coupons
                        </label></div>
                        <div class="py-6 px-8 w-1/2"><input id="qty" type="number" name="qty" placeholder="10"
                                                            v-model="qty"
                                                            class="w-full form-control form-input form-input-bordered"
                                                            step="1" min="1">
                            <div class="help-text help-text mt-2"></div>
                        </div>
                    </div>
                    <div class="flex border-b border-40">
                        <div class="w-1/5 px-8 py-6"><label for="price" class="inline-block text-80 pt-2 leading-tight">
                            Price
                        </label></div>
                        <div class="py-6 px-8 w-1/2">
                            <input id="price" type="number" name="price" placeholder="100" v-model="price"
                                   class="w-full form-control form-input form-input-bordered" step="1" min="1">
                            <div class="help-text help-text mt-2"></div>
                        </div>
                    </div>
                    <div class="flex border-b border-40">
                        <div class="w-1/5 px-8 py-6"><label for="price" class="inline-block text-80 pt-2 leading-tight">
                            Price is Override
                        </label></div>
                        <div class="py-6 px-8 w-1/2">
                            <input class="mr-2 leading-tight" type="checkbox" name="override" v-model="override">
                            <div class="help-text help-text mt-2"></div>
                        </div>

                    </div>

                </div>
                <div class="flex items-center"><a tabindex="0"
                                                  class="btn btn-link dim cursor-pointer text-80 ml-auto mr-6"
                                                  @click.prevent="reset">
                    Cancel
                </a>

                    <button type="submit" class="btn btn-default btn-primary inline-flex items-center relative"
                            @click.prevent="generateCoupons">
                        <span class="">
                            Generate Coupons
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['resourceName', 'resourceId', 'field'],
        data() {
            return {
                code: '',
                qty: null,
                price: null,
                override: false,
            }
        },
        mounted() {
        },
        methods: {
            reset() {
                this.qty = null;
                this.code = '';
                this.price = null;
                this.override = false;
            },
            generateCoupons() {
                if (this.qty !== null && this.qty > 0) {
                    if (this.price !== null && this.price > 0) {
                        if (this.code !== null && this.code !== '') {
                            this.runCouponGeneration();
                        } else {
                            alert('Code needed');
                        }
                    } else {
                        alert('Price needed');
                    }
                } else {
                    alert('Qty needed');
                }
            },
            runCouponGeneration() {
                Nova.request().post('/nova-vendor/sets-coupon-generator/generate', {
                    code: this.code,
                    eventId: this.resourceId,
                    qty: this.qty,
                    price: this.price,
                    override: this.override
                })
                    .then((response) => {
                        if (response.data['generated'] > 0) {
                            this.$toasted.show(response.data['generated'] + " Coupons Generated", {type: "success"});
                        }
                        if (response.data['failed'] > 0) {
                            self.$toasted.show(response.data['failed'] + " Coupons Failed", {type: "error"});
                        }
                        window.location.reload();
                    })
                    .catch(function (error) {
                        self.$toasted.show(error.response, {type: "error"});
                    });
            }
        }
    }
</script>
