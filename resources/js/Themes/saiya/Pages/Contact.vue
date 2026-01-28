<template>
    <AppLayout>
        <div>
            <Contact :offices="offices" />
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue';
import Contact from '../Components/Contact.vue';

const $props = defineProps({ jdata: Object });
const offices = $props.jdata.offices;
</script>