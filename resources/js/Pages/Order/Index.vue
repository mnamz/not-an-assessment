<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";

</script>

<template>
    <AppLayout title="Orders">
        <template #header>
            <h2 class="font-semibold text-xl text-neutral-50 leading-tight">
                Manage Orders
            </h2>

        </template>

        <div class="py-3 px-6">
            <div class="flex flex-col">
                <!-- <div class="py-4 flex justify-start ">
                    <Link :href="route('orders.create')">
                    <PrimaryButton class="mb-3 dark:bg-blue-500 text-white hover:bg-blue-600 "> Create Order
                    </PrimaryButton>
                    </Link>
                </div> -->
                <div v-if="$page.props.active.roles?.includes('manager')" class="flex flex-wrap gap-1 justify-between">
                    <div class="flex-grow p-2 min-w-full sm:min-w-0 sm:flex-auto md:flex-1">
                        <div
                            class="dark:bg-gray-800 text-neutral-50 p-4 rounded-lg shadow-md flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-sm font-semibold text-lightGray">Total Orders</p>
                                <p class="text-3xl font-bold text-blue-500">{{ total_orders }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow p-2 min-w-full sm:min-w-0 sm:flex-auto md:flex-1">
                        <div
                            class="dark:bg-gray-800 text-neutral-50 p-4 rounded-lg shadow-md flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-sm font-semibold text-lightGray">Products</p>
                                <p class="text-3xl font-bold text-green-500">{{ products }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow p-2 min-w-full sm:min-w-0 sm:flex-auto md:flex-1">
                        <div
                            class="dark:bg-gray-800 text-neutral-50 p-4 rounded-lg shadow-md flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-sm font-semibold text-lightGray">Today Sales</p>
                                <p class="text-3xl font-bold text-red-500">RM {{ revenue }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center shadow border-b border-gray-200 sm:rounded-lg mt-6">
                    <table class="w-full">
                        <!-- Table Header -->
                        <thead class="dark:bg-gray-800">
                            <tr>
                                <!-- v-if="$page.props.user.permissions.includes('read admin')" -->
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Customer Name</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Restaurant</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Payment</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Delivery</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Details</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Status</th>
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:px-3">
                                    Created</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody class="dark:bg-gray-700 divide-y text-white divide-gray-200 ">
                            <tr v-for="order in orders" :key="order.id">
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ order.customer_name }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ order.restaurant.name }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ order.payment_method }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ order.delivery_method }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ order.details }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ order.status }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ order.created }}</td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <Link :href="route('orders.show', { id: order.id, })">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        </Link>
                                        <button @click="deleteLeave(order.id)" v-if="order.deleted_at == null"
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
        orders: {
            type: Array,
            required: true,
        },
        total_orders: {
            type: Array,
            required: true,
        },
        revenue: {
            type: Array,
            required: true,
        },
        products: {
            type: Array,
            required: true,
        },
    },
};

</script>
