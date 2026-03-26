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
                        Account Access
                    </p>
                    <h1 class="mt-4 max-w-md text-4xl font-semibold leading-tight">
                        Sign in to access your workspace securely.
                    </h1>
                    <p class="mt-5 max-w-lg text-sm leading-7 text-slate-300">
                        Access your dashboard, manage your profile, and continue working with your
                        account data from one secure entry point.
                    </p>
                </div>

                <div class="relative grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm text-slate-300">Trusted login</p>
                        <p class="mt-2 text-2xl font-semibold text-white">Protected account area</p>
                        <p class="mt-3 text-sm leading-6 text-slate-400">
                            Only authenticated users can access dashboards, account settings, and
                            protected application pages.
                        </p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm text-slate-300">Session continuity</p>
                        <p class="mt-2 text-2xl font-semibold text-white">Stay signed in when needed</p>
                        <p class="mt-3 text-sm leading-6 text-slate-400">
                            Use the remember option on private devices to reduce repeated logins and
                            keep your workflow uninterrupted.
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
                            Member Login
                        </p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">
                            Sign in to continue
                        </h2>
                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Enter the email address and password associated with your account.
                        </p>
                    </div>

                    <form @submit.prevent="handelSubmit" class="space-y-6">
                        <div class="space-y-5 rounded-[28px] border border-slate-200 bg-white/80 p-6 shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
                            <TextInput name="Email" :message="form.errors.email" type="email" v-model="form.email" />
                            <TextInput name="Password" :message="form.errors.password" type="password" v-model="form.password" />

                            <div class="flex items-center justify-between gap-4 text-sm">
                                <label for="remember" class="flex items-center gap-3 text-slate-600">
                                    <input
                                        id="remember"
                                        v-model="form.remember"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                    >
                                    <span>Remember me</span>
                                </label>

                                <span class="text-slate-400">Encrypted sign-in</span>
                            </div>
                        </div>

                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="w-full cursor-pointer rounded-2xl bg-slate-950 px-4 py-3.5 text-sm font-semibold tracking-wide text-white transition hover:bg-slate-900 disabled:cursor-not-allowed disabled:opacity-70"
                        >
                            {{ form.processing ? 'Signing in...' : 'Login' }}
                        </button>

                        <p class="text-center text-sm text-slate-600">
                            Don't have an account?
                            <Link :href="route('register')" class="font-semibold text-blue-600 transition hover:text-blue-700 hover:underline">
                                Register Now
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
