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
    <div class="min-h-screen bg-[linear-gradient(180deg,_#f8fafc_0%,_#eaf2ff_45%,_#f8fafc_100%)] px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto grid min-h-[calc(100vh-4rem)] max-w-6xl overflow-hidden rounded-[32px] border border-slate-200/70 bg-white/55 shadow-[0_30px_80px_rgba(15,23,42,0.14)] backdrop-blur xl:grid-cols-[1.1fr_0.9fr]">
            <section class="relative hidden overflow-hidden bg-slate-950 p-10 text-white xl:flex xl:flex-col xl:justify-between">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.28),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.22),_transparent_30%)]"></div>

                <div class="relative">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/10 ring-1 ring-white/10">
                        <img
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                            alt="My App"
                            class="h-8 w-auto"
                        />
                    </div>
                    <p class="mt-8 text-xs font-semibold uppercase tracking-[0.26em] text-sky-300">
                        New Account
                    </p>
                    <h1 class="mt-4 max-w-md text-4xl font-semibold leading-tight">
                        Create your account and start using the workspace.
                    </h1>
                    <p class="mt-5 max-w-lg text-sm leading-7 text-slate-300">
                        Register with your basic details, upload a profile image if you want, and
                        get access to the dashboard and protected application pages.
                    </p>
                </div>

                <div class="relative grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm text-slate-300">Simple onboarding</p>
                        <p class="mt-2 text-2xl font-semibold text-white">Quick account setup</p>
                        <p class="mt-3 text-sm leading-6 text-slate-400">
                            Create an account with your name, email, password, and optional profile picture.
                        </p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm text-slate-300">Ready for use</p>
                        <p class="mt-2 text-2xl font-semibold text-white">Access after registration</p>
                        <p class="mt-3 text-sm leading-6 text-slate-400">
                            New accounts can move directly into the application flow after successful registration.
                        </p>
                    </div>
                </div>
            </section>

            <section class="flex items-center justify-center p-6 sm:p-10">
                <div class="w-full max-w-md">
                    <div class="mb-8 xl:hidden">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-950 ring-1 ring-slate-900/10">
                            <img
                                src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                alt="My App"
                                class="h-8 w-auto"
                            />
                        </div>
                    </div>

                    <div class="mb-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-700">
                            Account Registration
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">
                            Create your account
                        </h2>
                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Fill in your details below to register a new account.
                        </p>
                    </div>

                    <form @submit.prevent="handelSubmit" class="space-y-6">
                        <div class="space-y-5 rounded-[28px] border border-slate-200 bg-white/80 p-6 shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
                            <div class="flex flex-col items-center gap-4">
                                <div class="flex h-32 w-32 items-center justify-center overflow-hidden rounded-[28px] border border-slate-200 bg-slate-50">
                                    <img v-if="preview" :src="preview" id="preview" class="h-full w-full object-cover" />
                                    <div v-else id="placeholder" class="flex h-full w-full items-center justify-center text-sm text-slate-400">
                                        Profile Image
                                    </div>
                                </div>

                                <label class="cursor-pointer rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-900">
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
                            <TextInput name="Email" :message="form.errors.email" type="email" v-model="form.email" />
                            <TextInput name="Password" :message="form.errors.password" type="password" v-model="form.password" />
                            <TextInput name="Confirm Password" :message="form.errors.password_confirmation" type="password" v-model="form.password_confirmation" />
                        </div>

                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="w-full cursor-pointer rounded-2xl bg-slate-950 px-4 py-3.5 text-sm font-semibold tracking-wide text-white transition hover:bg-slate-900 disabled:cursor-not-allowed disabled:opacity-70"
                        >
                            {{ form.processing ? 'Creating account...' : 'Create an account' }}
                        </button>

                        <p class="text-center text-sm text-slate-600">
                            Already have an account?
                            <Link :href="route('login')" class="font-semibold text-blue-600 transition hover:text-blue-700 hover:underline">
                                Login here
                            </Link>
                        </p>
                    </form>
                </div>
            </section>
        </div>
    </div>
</template>

<style scoped>

</style>
