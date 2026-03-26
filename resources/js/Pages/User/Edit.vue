<script setup>
import {Head, Link, router} from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import {useForm} from "@inertiajs/vue3";
import {computed, reactive, ref, watch} from "vue";
import  {usePage} from "@inertiajs/vue3";

const  toast = useToast();
const page =usePage();

const props = defineProps({
    user: Object ,
    permissions: Object

});


const form = useForm({
    id: props.user.id,
    name:props.user.name,
    email: props.user.email,
    email_verified_at: props.user.email_verified_at ?? null,
    avatar: null,
    status:props.user.status,
    role:props.user.role,
    created_at:props.user.created_at,
    updated_at:props.user.updated_at,
    bio: props.user.bio ?? '',
    permissions: {
        edit: props.permissions.includes('edit'),
        delete: props.permissions.includes('delete'),
        export: props.permissions.includes('export'),
    },
});


const resetPremit = ()=>{
    form.permissions.edit = false;
    form.permissions.delete = false;
    form.permissions.export = false;
}

const fileInput = ref(null)

function openFilePicker() {
    fileInput.value.click()
}

const ImagePreview = ref(props.user.avatar)
function handleFileChange(event) {
    const file = event.target.files[0]
    ImagePreview.value = URL.createObjectURL(file);
    form.avatar = file;
}

const accountState = ref(props.user.status)
watch(accountState,(val)=>{
   if(val === 'active'){
       form.email_verified_at = new Date();
       form.status= 'active';
   }else{
       form.email_verified_at = null;
       form.status= 'inactive';
   }
});
const deleteAccount = ()=>{
    let id = props.user.id;
    router.delete(route('users.destroy', {id:id}) ,{
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onError : (error) =>{
            setTimeout(()=>{
                toast.error(error.delete);
            }, 500)
        }
    })
}

watch(
    () => page.props.flash.message,
    (message) => {
        if (message) toast.success(message)
    }
)


const HandleUpdate = function (){
    form.put(route('users.update', props.user.id), {
         preserveScroll:true,
        replace: true
    });
}

</script>

<template>

    <Head title="Edit User" />
    <div class="min-h-screen bg-[linear-gradient(180deg,_#f8fafc_0%,_#eef6ff_40%,_#f8fafc_100%)] px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <section class="relative overflow-hidden rounded-[32px] bg-slate-950 px-6 py-8 text-white shadow-[0_24px_70px_rgba(15,23,42,0.24)] sm:px-8 lg:px-10">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.2),_transparent_26%),radial-gradient(circle_at_bottom_right,_rgba(56,189,248,0.22),_transparent_30%)]"></div>

                <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.26em] text-emerald-300">
                            User Editor
                        </p>
                        <h1 class="mt-4 text-3xl font-semibold leading-tight sm:text-4xl">
                            Update account details, permissions, and profile settings in one place.
                        </h1>
                        <p class="mt-4 max-w-xl text-sm leading-7 text-slate-300">
                            Review the current account information, adjust access controls, and prepare the profile for the next update cycle.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <Link :href="route('dashboard')" class="rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-50">
                                Back to dashboard
                            </Link>

                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3 lg:min-w-[420px]">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                            <p class="text-sm text-slate-300">Current role</p>
                            <p class="mt-2 text-2xl font-semibold">{{ $page.props.user.role }} </p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                            <p class="text-sm text-slate-300">Account state</p>
                            <p class="mt-2 text-2xl font-semibold">{{$page.props.user.status}}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                            <p class="text-sm text-slate-300">Last update</p>
                            <p class="mt-2 text-1xl font-semibold">{{ new Date($page.props.user.updated_at).toLocaleDateString()}}</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-8 grid gap-8 xl:grid-cols-[1.5fr_0.8fr]">
                <section class="rounded-[30px] border border-slate-200/70 bg-white/90 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur sm:p-8">
                    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-700">Profile Details</p>
                            <h2 class="mt-3 text-2xl font-semibold text-slate-950">Edit user information</h2>

                        </div>

                        <span
                            :class="[
                                        'inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold',
                                        Object.keys(form.errors).length
                                          ? 'text-rose-700 border-rose-200 bg-rose-50'
                                          : 'text-emerald-700 border-emerald-200 bg-emerald-50'
                                      ]"
                               >
                            <span :class="['h-2.5 w-2.5 rounded-full',  !Object.keys(form.errors).length ? 'bg-emerald-500' : 'bg-rose-500']"></span>

                            {{ Object.keys(form.errors).length ? 'can not save' : 'Ready to save'}}
                        </span>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-slate-700">Full Name</span>
                            <input type="text" v-model="form.name" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none" />
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-slate-700">Email Address</span>
                            <input type="email" v-model="form.email" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none" />
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-slate-700">Role</span>
                            <select v-model="form.role" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none">
                                <option>admin</option>
                                <option>user</option>
                            </select>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-slate-700">Status</span>
                            <select v-model="accountState" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none">
                                <option>active</option>
                                <option>inactive</option>

                            </select>
                        </label>

                        <label class="block md:col-span-2">
                            <span class="mb-2 block text-sm font-semibold text-slate-700">Bio</span>
                            <textarea v-model="form.bio" rows="5" class="w-full rounded-[24px] border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-800 outline-none"></textarea>
                        </label>
                    </div>

                    <div class="mt-8 rounded-[28px] border border-slate-200 bg-slate-50/80 p-5">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Permissions</p>
                                <p class="mt-1 text-sm text-slate-500">Choose which management capabilities are available for this user.</p>
                            </div>
                            <button type="button" @click="resetPremit" class="cursor-pointer rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-emerald-300 hover:text-emerald-700">
                                Reset permissions
                            </button>
                        </div>

                        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4">
                                <input type="checkbox" v-model="form.permissions.edit" class="mt-1 h-4 w-4 rounded border-slate-300 text-emerald-600" />
                                <span>
                                    <span class="block text-sm font-semibold text-slate-900">Edit users</span>
                                    <span class="mt-1 block text-xs leading-5 text-slate-500">Allow profile updates and role changes.</span>
                                </span>
                            </label>

                            <label  v-if="permissions.includes('delete')" class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4">
                                <input type="checkbox"  v-model="form.permissions.delete" class="mt-1 h-4 w-4 rounded border-slate-300 text-emerald-600" />
                                <span>
                                    <span class="block text-sm font-semibold text-slate-900">Delete users</span>
                                    <span class="mt-1 block text-xs leading-5 text-slate-500">Permit account removal from the dashboard.</span>
                                </span>
                            </label>

                            <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4">
                                <input type="checkbox" v-model="form.permissions.export" class="mt-1 h-4 w-4 rounded border-slate-300 text-emerald-600" />
                                <span>
                                    <span class="block text-sm font-semibold text-slate-900">Export data</span>
                                    <span class="mt-1 block text-xs leading-5 text-slate-500">Grant access to reports and CSV exports.</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button type="button" class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400">
                            Cancel
                        </button>
                        <button type="button" @click="HandleUpdate" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-900">
                            Save changes
                        </button>
                    </div>
                </section>

                <aside class="space-y-6">
                    <section class="rounded-[30px] border border-slate-200/70 bg-white/90 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-700">Profile Card</p>
                        <div class="mt-5 flex flex-col items-center text-center">
                            <img
                                :src="ImagePreview"
                                alt="User avatar"
                                class="h-28 w-28 rounded-[28px] object-cover ring-4 ring-slate-100"
                            />
                            <h3 class="mt-4 text-xl font-semibold text-slate-950">{{ $page.props.user.name }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $page.props.user.email }}</p>
                            <span class="mt-4 inline-flex rounded-full border border-sky-200 bg-sky-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">
                             {{ $page.props.user.role == 'admin' ? 'Admin account'  : 'User account' }}
                            </span>
                        </div>

                        <div class="mt-6 space-y-3">
                            <button type="button"  @click="openFilePicker" class="cursor-pointer  w-full rounded-2xl bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-900">
                                Change avatar
                            </button>
                            <input
                                type="file"
                                ref="fileInput"
                                class="hidden"
                                @change="handleFileChange"
                            />
                            <button type="button" v-if="permissions.includes('delete')" @click="deleteAccount" class="cursor-pointer w-full rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                                Delete account
                            </button>
                        </div>
                    </section>

                </aside>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
