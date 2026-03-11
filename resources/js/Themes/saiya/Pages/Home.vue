<template>
    <AppLayout>
        <div>
            <Hero :banners="jdata.banners" />
            <About :images="jdata.about_us_images" :description="jdata.about_us_description" />
            <Products :categories="jdata.categories" :subCategories="jdata.subCategories"
                :selectedCategory="jdata.selectedCategory" />
            <FeaturedProducts :products="jdata.featuredProducts" />
            <News :posts="jdata.posts" />
            <Contact :offices="jdata.offices" />

        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue';
import Hero from '../Components/Hero.vue';
import About from '../Components/About.vue';
import Products from '../Components/Products.vue';
import FeaturedProducts from '../Components/FeaturedProducts.vue'
import News from '../Components/News.vue';
import Footer from '../Components/Footer.vue';
import Contact from '../Components/Contact.vue';

const $prop = defineProps({ jdata: Object });
console.log($prop.jdata);

</script>

<style scoped></style>