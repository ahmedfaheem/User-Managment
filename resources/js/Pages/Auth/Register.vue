<script setup>


import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import { ref } from 'vue'
defineOptions({
    layout: null,
})
let form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    avatar: null
})

const preview = ref('');
const upload = (e)=>{
   const image = e.target.files[0];
   form.avatar = image;
    preview.value = URL.createObjectURL(image);  // create temporary url for image
    console.log(preview.value);
}
const handelSubmit = ()=>{

  form.post(route('register'), {
      onError : ()=> form.reset('password', 'password_confirmation'),
      preserveScroll: true,
      replace: true
  });
}
</script>

<template>

    <Head title="Registration" />
    <div class="flex flex-col justify-center sm:h-screen p-4">
        <div class="max-w-md w-full mx-auto border border-gray-300 rounded-2xl p-8">
            <div class="text-center mb-12">
                <a ><img
                    src="https://readymadeui.com/readymadeui.svg" alt="logo" class="w-40 inline-block" />
                </a>
            </div>

            <form @submit.prevent="handelSubmit">
                <div class="space-y-6">


                    <div class="flex flex-col items-center gap-4">

                        <!-- Avatar Preview -->
                        <div class="w-32 h-32 rounded-full overflow-hidden border border-gray-300">
                            <img  v-if="preview" :src="preview" id="preview" class="w-full h-full object-cover " />
                            <div id="placeholder" class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                No Image
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <label class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
                            Upload Avatar
                            <input
                                type="file"
                                class="hidden"
                                accept="image/*"
                                @change="upload"
                            />
                        </label>
 </div>


                        <TextInput name="Name" :message="form.errors.name" v-model="form.name" />
                    <TextInput name="Email" :message="form.errors.email"  type="email" v-model="form.email" />

                    <TextInput name="Password" :message="form.errors.password"  type="password" v-model="form.password" />
                    <TextInput name="Confirm Password" :message="form.errors.password_confirmation"  type="password" v-model="form.password_confirmation" />


                </div>

                <div class="mt-12">
                    <button :disabled="form.processing" type="submit" class="w-full py-3 px-4 text-sm tracking-wider font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer">
                        Create an account
                    </button>
                </div>
                <p class="text-slate-600 text-sm mt-6 text-center">Already have an account? <Link :href="route('login')" class="text-blue-600 font-medium hover:underline ml-1">Login here</Link></p>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
