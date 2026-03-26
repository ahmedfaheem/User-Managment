<script setup>

import {reactive, watch, ref} from "vue";
import {router} from "@inertiajs/vue3";
import debounce from 'lodash/debounce'
const props = defineProps({
    'users':{
        type:Object,
        required: true
    },
    count: Number,
    search: String,
})


const display = reactive({
    count: props.count ?? 10,
})


watch(display, function (value){
   router.get(route('home'),
       {
        'count': value.count,

       },
       {
           replace: true,
           preserveScroll: true,
           preserveState: true
       }
   )
});


const search = ref(props.search);


watch(
    search,
    debounce((value) => {
        router.get(
            route('home'),
            { search: value, count: display.count },
            {
                replace: true,
                preserveScroll: true,
                preserveState: true,
            }
        )    }, 500)
)
</script>

<template>

    <Head title="Home">
        <meta name="description" content="Description Of Home" head-key="description" />
    </Head>

    <div class="p-3 bg-green-400 my-3" v-if="$page.flash.message" >
        {{$page.flash.message}}
    </div>
    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[28px] bg-slate-950 px-6 py-8 text-white shadow-[0_24px_70px_rgba(15,23,42,0.24)] sm:px-8 lg:px-10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.26),_transparent_26%),radial-gradient(circle_at_bottom_left,_rgba(45,212,191,0.18),_transparent_28%)]"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                      <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-sky-200">
                          Team Management
                      </span>
                    <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl">
                        Team directory with cleaner structure and faster scanning
                    </h1>
                    <p class="mt-4 text-sm leading-6 text-slate-300 sm:text-base">
                        Review member activity, roles, and actions from a more polished dashboard experience.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:min-w-[420px]">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-sm text-slate-300">Total members</p>
                        <p class="mt-2 text-3xl font-semibold">48</p>
                        <p class="mt-1 text-xs text-emerald-300">+6 this month</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-sm text-slate-300">Active now</p>
                        <p class="mt-2 text-3xl font-semibold">36</p>
                        <p class="mt-1 text-xs text-emerald-300">75% engagement</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-sm text-slate-300">Pending review</p>
                        <p class="mt-2 text-3xl font-semibold">09</p>
                        <p class="mt-1 text-xs text-amber-300">Needs attention</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white/80 p-5 shadow-sm backdrop-blur">
                <p class="text-sm text-slate-500">Departments</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">8 active teams</p>
                <p class="mt-1 text-sm text-slate-600">Balanced across design, product, QA, and engineering.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white/80 p-5 shadow-sm backdrop-blur">
                <p class="text-sm text-slate-500">Response rate</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">92%</p>
                <p class="mt-1 text-sm text-slate-600">Most updates were reviewed within the past day.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white/80 p-5 shadow-sm backdrop-blur">
                <p class="text-sm text-slate-500">Open hiring</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">3 roles</p>
                <p class="mt-1 text-sm text-slate-600">Frontend, QA, and product operations remain top priority.</p>
            </div>
        </section>

        <section class="overflow-hidden rounded-[30px] border border-slate-200/70 bg-white/85 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur">
            <div class="flex flex-col gap-5 border-b border-slate-200/70 px-6 py-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-600">Directory</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-900">People overview</h2>
                    <p class="mt-1 text-sm text-slate-500">Browse, manage, and review your current team members.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-slate-400" viewBox="0 0 24 24">
                            <path d="M10 18a8 8 0 1 1 5.293-14.001A8 8 0 0 1 10 18zm11.707 2.293-4.825-4.825a10 10 0 1 0-1.414 1.414l4.825 4.825a1 1 0 0 0 1.414-1.414z"/>
                        </svg>
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search member"
                            class="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                        />
                    </div>

                    <select class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                        <option>All roles</option>
                        <option>Product</option>
                        <option>Design</option>
                        <option>Engineering</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-slate-50 whitespace-nowrap">
                    <tr>
                        <th class="pl-6 w-10">
                            <input id="checkbox" type="checkbox" class="hidden peer" />
                            <label
                                for="checkbox"
                                class="relative flex h-5 w-5 cursor-pointer items-center justify-center overflow-hidden rounded-md border border-slate-300 bg-sky-500 p-0.5 before:absolute before:block before:h-full
  before:w-full before:bg-white peer-checked:before:hidden"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full fill-white" viewBox="0 0 520 520">
                                    <path d="M79.423 240.755a47.529 47.529 0 0 0-36.737 77.522l120.73 147.894a43.136 43.136 0 0 0 36.066 16.009c14.654-.787 27.884-8.626 36.319-21.515L486.588 56.773a6.13 6.13 0 0
  1 .128-.2c2.353-3.613 1.59-10.773-3.267-15.271a13.321 13.321 0 0 0-19.362 1.343q-.135.166-.278.327L210.887 328.736a10.961 10.961 0 0 1-15.585.843l-83.94-76.386a47.319 47.319 0 0 0-31.939-12.438z" />
                                </svg>
                            </label>
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Member</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Email</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Role</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Status</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Joined date</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Action</th>
                    </tr>
                    </thead>

                    <tbody class="whitespace-nowrap divide-y divide-slate-200">
                    <tr
                        class="transition hover:bg-sky-50/60"
                        v-for="user in users.data"
                        :key="user.id"
                    >

                        <td class="pl-6 w-10">
                            <input id="checkbox9" type="checkbox" class="hidden peer" />
                            <label for="checkbox9" class="relative flex h-5 w-5 cursor-pointer items-center justify-center overflow-hidden rounded-md border border-slate-300 bg-sky-500 p-0.5 before:absolute before:block
  before:h-full before:w-full before:bg-white peer-checked:before:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full fill-white" viewBox="0 0 520 520">
                                    <path d="M79.423 240.755a47.529 47.529 0 0 0-36.737 77.522l120.73 147.894a43.136 43.136 0 0 0 36.066 16.009c14.654-.787 27.884-8.626 36.319-21.515L486.588 56.773a6.13 6.13 0 0
  1 .128-.2c2.353-3.613 1.59-10.773-3.267-15.271a13.321 13.321 0 0 0-19.362 1.343q-.135.166-.278.327L210.887 328.736a10.961 10.961 0 0 1-15.585.843l-83.94-76.386a47.319 47.319 0 0 0-31.939-12.438z" />
                                </svg>
                            </label>
                        </td>


                        <td class="px-4 py-4 text-sm font-medium text-slate-900">
                            <div class="flex w-max items-center gap-3">
                                <img :src="user.avatar" alt="team-1" class="h-11 w-11 rounded-2xl object-cover ring-2 ring-slate-100" />
                                <p>{{user.name}}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm font-medium text-slate-600"><a :href="`mailto:${user.email}`" class="hover:text-sky-600">timj1456@gmail.com</a></td>
                        <td class="px-4 py-4 text-sm font-medium text-slate-600">{{ user.role }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-slate-600">
                                  <span class="inline-flex items-center gap-2 rounded-full  px-3 py-1 text-xs font-semibold  ring-1 ring-gray-300">
                                      <span :class="['h-2 w-2 rounded-full',  { 'bg-emerald-500' : user.status==='active' ,'bg-red-600' : user.status!=='active' } ]"></span>{{ user.status }}
                                  </span>
                        </td>
                        <td class="px-4 py-4 text-sm font-medium text-slate-500">{{ new Date(user.created_at).toDateString()}}</td>
                        <td class="px-4 py-4 text-sm font-medium">
                            <div class="flex gap-2">

                                <button  v-if="user.can.edit" type="button" class="rounded-xl border border-sky-200 bg-sky-50 px-4 py-2 text-sky-700 transition hover:bg-sky-100">Edit</button>
                                <button v-if="user.can.delete" type="button" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-rose-700 transition hover:bg-rose-100">Delete</button>
                                <span v-else class="text-sm font-medium text-slate-900">No Premissions</span>
                            </div>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-4 border-t border-slate-200 px-6 py-5 md:flex-row md:items-center md:justify-between">
                <p class="flex-1 text-sm text-slate-500">Showing {{ users.from }} to {{users.to}} of {{users.total}} entries</p>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="flex items-center gap-3">
                        <p class="text-sm text-slate-500">Display</p>
                        <select v-model="display.count" class="h-10 rounded-xl border border-slate-300 bg-white px-3 text-sm text-slate-800 outline-none">
                            <option>10</option>
                            <option>20</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>

                    <ul class="flex flex-wrap items-center gap-2">
                        <li v-for="(link, index) in users.links" :key="link.label">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                v-html="link.label"
                                :class="[
                  'flex min-h-10 min-w-10 items-center justify-center rounded-xl border px-3 text-sm font-medium transition',
                  link.active
                      ? 'border-sky-500 bg-sky-500 text-white'
                      : 'border-slate-300 bg-white text-slate-700 hover:border-sky-400 hover:text-sky-600'
              ]"
                            />

                            <span
                                v-else
                                v-html="link.label"
                                class="flex min-h-10 min-w-10 cursor-not-allowed items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm font-medium text-slate-400"
                            />
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>

</style>
