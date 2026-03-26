<script setup>


import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";

defineOptions({
    layout: null,
})
let form = useForm({
    email: '',
    password: '',
    remember: false,
})
const handelSubmit = ()=>{

    form.post(route('login'), {
        onError : ()=> form.reset('password'),
        preserveScroll: true,
        replace: true
    });
}
</script>

<template>

    <Head title="Login" />
    <div class="flex flex-col justify-center sm:h-screen p-4">
        <div class="max-w-md w-full mx-auto border border-gray-300 rounded-2xl p-8">
            <div class="text-center mb-12">
                <a ><img
                    src="https://readymadeui.com/readymadeui.svg" alt="logo" class="w-40 inline-block" />
                </a>
            </div>

            <form @submit.prevent="handelSubmit">
                <div class="space-y-6">
                    <TextInput name="Email" :message="form.errors.email"  type="email" v-model="form.email" />
                    <TextInput name="Password" :message="form.errors.password"  type="password" v-model="form.password" />

                    <div class="flex align-items-center gap-2">
                        <input type="checkbox" v-model="form.remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>

                </div>

                <div class="mt-12">
                    <button :disabled="form.processing" type="submit" class="w-full py-3 px-4 text-sm tracking-wider font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer">
                       Login
                    </button>
                </div>
                <p class="text-slate-600 text-sm mt-6 text-center">Don't have an account? <Link :href="route('register')" class="text-blue-600 font-medium hover:underline ml-1">Register Now</Link></p>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
