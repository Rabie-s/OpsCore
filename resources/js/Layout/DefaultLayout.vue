<template>
    <NavBar/>
    <div class="">
        <slot />
    </div>
    
</template>
<script setup>
import NavBar from '@/Components/Admin/Layout/NavBar.vue'
</script>