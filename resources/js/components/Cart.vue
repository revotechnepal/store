<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 500px;">
                <div class="card-header text-center">
                    Cart Details
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price (in Rs.)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr :key="cartproduct.id" v-for="cartproduct in cartproducts">
                                    <td>{{cartproduct.product}}</td>
                                    <td>{{cartproduct.quantity}}</td>
                                    <td>{{cartproduct.price}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table table-responsive">
                        <table class="table table-bordered text-center">
                            <tr>
                                <td>
                                    Sub Total
                                </td>
                                <td>
                                    Rs. 0
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Discount
                                </td>
                                <td>
                                    Rs. 0
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Grand Total
                                </td>
                                <td>
                                    Rs. 0
                                </td>
                            </tr>
                        </table>
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
                cartproducts: [],
                url: 'http://127.0.0.1:8000/',
            }
        },
        mounted() {
            this.axios
                .get(this.url+'api/productsold/')
                .then(response => {
                    this.cartproducts = response.data['data'];
                });
        },
    }
</script>
