<script setup>
defineOptions({
    layout: null,
})

const model = defineModel({
    type:String,
    required: true
})
defineProps({
    name:{
        type:String,
        required: true
    },
    type:{
        type:String,
        default:"text"
    },
    message: String
});
</script>

<template>

    <div>
        <label class="text-slate-900 text-sm font-medium mb-2 block">{{ name }}</label>
        <input   v-model="model"  :type="type" :class="['text-slate-900 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500', {'!ring-red-500' : message}]" :placeholder="`Enter ${name}`" />
        <small class="text-red-700">{{message}}</small>
    </div>

</template>

<style scoped>

</style>
