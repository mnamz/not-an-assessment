<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm, Head } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    user_status: Array,
})

const form = useForm({
    status: props.user.status,
});

const submitForm = () => {
    form.put(route("users.update", props.user.id));
};

</script>

<template>
    <AppLayout title="View User">
        <template #header>
            <h2 class="font-semibold text-xl text-neutral-50 leading-tight">
                Viewing {{ user.name }} (ID: {{ user.id }})
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-gray overflow-hidden shadow-xl sm:rounded-lg p-2">
                    <div class="mx-auto max-w-2xl">
                        <form @submit.prevent="submitForm">

                            <div class=" space-y-6 border-b border-gray-900/10 pb-5">
                                <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <p class="mb-2 ml-1 text-sm font-medium text-neutral-50">Name</p>
                                        <p class=" p-2 text-sm text-gray-500">{{ user.name }}</p>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <p class="mb-2 ml-1 text-sm font-medium text-neutral-50">Restaurant</p>
                                        <p class=" p-2 text-sm text-gray-500">{{ user.restaurant?.name }}</p>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="email"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Email Address</label>
                                        <div class="mt-2">
                                            <p class=" p-2 text-sm text-gray-500">{{ user.email }}</p>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="phone"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Phone Number</label>
                                        <div class="mt-2">
                                            <p class=" p-2 text-sm text-gray-500">{{ user.phone }}</p>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="start_date"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Registered
                                            At</label>
                                        <div class="mt-2">
                                            <p class=" p-2 text-sm text-gray-500">{{ user.created }}</p>
                                        </div>
                                    </div>
                                    {{ console.log(user_status) }}
                                    <div class="sm:col-span-3">
                                        <label for="type" class="block text-sm font-medium leading-6 text-neutral-50">
                                            Status</label>
                                        <select id="status" v-model="form.status"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                            <option v-for="(value, key) in user_status" :key="key" :value="value">{{
                                                value }}
                                            </option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <!-- button cancel -->
                                <Link :href="route('users.index')">
                                <button type="button"
                                    class="text-sm font-semibold leading-6 text-neutral-50">Back</button>
                                </Link>
                                <PrimaryButton type="submit">
                                    Update
                                </PrimaryButton>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
