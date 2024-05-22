<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({});

function deleteEntry(id) {
    if (confirm("Are you sure you want to delete")) {
        form.delete(route('users.destroy', id));
    }
}
</script>

<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-neutral-50 leading-tight">
                Manage Users
            </h2>
            
        </template>
        <div class="py-3 px-6">
            <div class="flex flex-col">
                <!-- Use /register please. Then change user status here -->
                <!-- <div class="py-4 flex justify-start ">
                    <Link :href="route('users.create')">
                    <PrimaryButton class="mb-3 dark:bg-blue-500 text-white hover:bg-blue-600 "> Add User
                    </PrimaryButton>
                    </Link>
                </div> -->
                <div class="flex justify-center items-center shadow border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full">
                        <!-- Table Header -->
                        <thead class="dark:bg-gray-800">
                            <tr>
                                <!-- v-if="$page.props.user.permissions.includes('read admin')" -->
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Name</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Email</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Restaurant</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Status</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Registered</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody class="dark:bg-gray-700 divide-y text-white divide-gray-200 ">
                            <tr v-for="user in users" :key="user.id">
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ user.name }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ user.email }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ user.restaurant?.name }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ user.status }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ user.created }}</td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <Link :href="route('users.show', { id: user.id, })">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        </Link>
                                        <button @click="deleteEntry(user.id)" v-if="user.deleted_at == null"
                                            class="inline-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6 text-red-500 hover:text-red-900">
                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    props: {
        users: {
            type: Array,
            required: true,
        },
    },
};

</script>
