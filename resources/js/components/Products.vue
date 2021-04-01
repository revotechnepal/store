<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body" style="min-height: 500px;">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="all-products-tab" data-toggle="tab" href="#all-products" role="tab" aria-controls="all-products" aria-selected="true">All Products</a>
                        </li>
                        <li>
                            <a class="nav-link" id="food-tab" data-toggle="tab" href="#food" role="tab" aria-controls="food" aria-selected="false">Food Items</a>
                        </li>
                        <li>
                            <a class="nav-link" id="beauty-tab" data-toggle="tab" href="#beauty" role="tab" aria-controls="beauty" aria-selected="false">Beauty Items</a>
                        </li>
                        <li>
                            <a class="nav-link" id="grocery-tab" data-toggle="tab" href="#grocery" role="tab" aria-controls="grocery" aria-selected="false">Grocery Items</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade active show" id="all-products" role="tabpanel" aria-labelledby="all-products-tab">
                            <div class="row">
                                <div :key="product.id" v-for="product in products" class="col-md-3">
                                    <!-- <button type="submit" @click="addToData(product.id)"></button> -->
                                    <form @submit.prevent="addToData(product.id)">
                                        <button type="submit">
                                            <div class="card">
                                                <div class="card-body">
                                                    <img :src="url+'uploads/'+product.image" :alt="product.name" style="max-height: 100px;"/>
                                                    <p class="text-center mt-2">
                                                        <b>{{product.name}}</b> ({{product.info}})<br>
                                                        <span class="text-center">Rs. {{product.unit_price}}</span><br>
                                                        <span class="text-center">In stock: {{product.stock}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="food" role="tabpanel" aria-labelledby="food-tab">
                            <!-- <div class="row">
                                <div :key="foodproduct.id" v-for="foodproduct in foodproducts" class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">

                                            <img :src="url+'uploads/'+foodproduct.image" :alt="foodproduct.name" style="max-height: 100px;"/>

                                            <p class="text-center mt-2">
                                                <b>{{foodproduct.name}}</b> ({{foodproduct.info}})<br>
                                                <span class="text-center">Rs. {{foodproduct.unit_price}}</span><br>
                                                <span class="text-center">In stock: {{foodproduct.stock}}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="tab-pane fade" id="beauty" role="tabpanel" aria-labelledby="beauty-tab">
                            Beverages
                        </div>
                        <div class="tab-pane fade" id="grocery" role="tabpanel" aria-labelledby="grocery-tab">
                            Grocery
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: [],
            url: 'http://127.0.0.1:8000/',
        }
    },
    mounted() {
        this.axios
            .get(this.url+'api/products/')
            .then(response => {
                this.products = response.data['data'];
        });
    },
    methods: {
            async addToData(id) {
                const cartproduct = {
                    pos_sales_id: 1,
                    product_id: id,
                    quantity: 1,
                }
                const res = await fetch(this.url+'api/productsold', {
                        method: 'POST',
                        headers: {
                        'Content-type' : 'application/json',
                    },
                    body: JSON.stringify(cartproduct),
                })
            }
        }
}
</script>
