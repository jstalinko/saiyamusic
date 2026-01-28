<template>
    <AppLayout>
        <div class="container mx-auto">
            <h1>Products</h1>
            <Products :categories="jdata.categories" :products="jdata.products" />
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '../AppLayout.vue';
import Products from '../Components/Products.vue';
const $props = defineProps({ jdata: Object });
const products = $props.jdata.products;
</script>