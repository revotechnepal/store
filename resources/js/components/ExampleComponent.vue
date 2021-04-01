<template>
    <div class="row">
        <div class="col-md-8">
            <Products />
        </div>
        <div class="col-md-4">
            <Cart />
        </div>
    </div>
</template>

<script>
import Products from './Products'
import Cart from './Cart'
    export default {
        components: {
            Products,
            Cart
        },

    }
</script>
