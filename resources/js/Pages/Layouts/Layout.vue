<script setup>

</script>
<template>
    <Head title="My App">
        <meta name="description" content="Default Description For Website" head-key="description" />
    </Head>

    <div class="min-h-screen bg-[linear-gradient(180deg,_#f8fafc_0%,_#eef4ff_45%,_#f8fafc_100%)]">
        <nav class="sticky top-0 z-40 border-b border-white/60 bg-slate-950/90 shadow-[0_12px_40px_rgba(15,23,42,0.22)] backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex min-h-[76px] flex-col justify-center gap-4 py-4 lg:flex-row lg:items-center lg:justify-between lg:py-0">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15">
                                <img
                                    src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                    alt="Your Company"
                                    class="h-7 w-auto"
                                />
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-300">
                                    Control panel
                                </p>
                                <h1 class="text-lg font-semibold text-white">
                                    My App Workspace
                                </h1>
                            </div>
                        </div>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="inline-flex cursor-pointer items-center rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-gray-200 transition hover:bg-white/10 hover:text-white lg:hidden"
                        >
                            Logout
                        </Link>
                    </div>

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-6">
                        <div class="flex flex-wrap items-center gap-2 rounded-2xl border border-white/10 bg-white/5 p-2">
                            <Link
                                :href="route('home')"
                                aria-current="page"
                                :class="[
                                      'rounded-xl px-4 py-2 text-sm font-medium transition',
                                      $page.component == 'Home'
                                          ? 'bg-white text-slate-950 shadow-sm'
                                          : 'text-slate-300 hover:bg-white/10 hover:text-white'
                                  ]"
                            >
                                Home
                            </Link>

                            <Link
                                :href="route('about')"
                                :class="[
                                      'rounded-xl px-4 py-2 text-sm font-medium transition',
                                      $page.component == 'About'
                                          ? 'bg-white text-slate-950 shadow-sm'
                                          : 'text-slate-300 hover:bg-white/10 hover:text-white'
                                  ]"
                            >
                                About
                            </Link>

                            <Link
                                :href="route('dashboard')"
                                :class="[
                                      'rounded-xl px-4 py-2 text-sm font-medium transition',
                                      $page.component == 'Dashboard'
                                          ? 'bg-sky-400 text-slate-950 shadow-sm'
                                          : 'text-slate-300 hover:bg-white/10 hover:text-white'
                                  ]"
                            >
                                Dashboard
                            </Link>


                        </div>

                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img
                                    :src="$page.props.auth.user.avatar ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&w=256&h=256&q=80'"
                                    class="h-11 w-11 rounded-2xl object-cover ring-2 ring-white/10"
                                />
                                <div class="min-w-0">
                                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">
                                        Signed in as
                                    </p>
                                    <p class="truncate text-sm font-semibold text-white">
                                        {{ $page.props.auth.user.name }}
                                    </p>
                                </div>
                            </div>

                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="hidden cursor-pointer rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-gray-200 transition hover:bg-white/10 hover:text-white lg:inline-flex"
                            >
                                Logout
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <slot />
        </main>

        <footer class="mt-10 border-t border-white/10 bg-slate-950/90 shadow-[0_-12px_40px_rgba(15,23,42,0.18)] backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-8 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-300">
                        My App
                    </p>
                    <p class="mt-2 text-sm text-slate-300">
                        Practical web experiences built with Laravel, Inertia, and Vue.
                    </p>
                </div>

                <div class="flex flex-col gap-3 text-sm text-slate-400 sm:flex-row sm:items-center sm:gap-6">
                    <a href="#" class="transition hover:text-white">
                        Privacy
                    </a>
                    <a href="#" class="transition hover:text-white">
                        Terms
                    </a>
                    <a href="#" class="transition hover:text-white">
                        Support
                    </a>
                    <p class="text-slate-500">
                        © 2026 My App. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
