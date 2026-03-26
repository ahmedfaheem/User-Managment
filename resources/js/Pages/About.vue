<script setup>

defineProps({
    test: String,
})
</script>

<template>
    <Head title="About">
        <meta name="description" content=" Description Of About" head-key="description">
    </Head>

    {{ test }}
</template>

<style scoped>

</style>
