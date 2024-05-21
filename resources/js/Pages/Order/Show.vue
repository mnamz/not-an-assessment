<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm, Head } from '@inertiajs/vue3';


const props = defineProps({
    order: Object,
    order_details: Object,
    order_status: Array,
})

const form = useForm({
    status: props.order.status,
});

const submitForm = () => {
    form.put(route("orders.update", props.order.id));
};

</script>

<template>
    <AppLayout title="View Order">
        <template #header>
            <h2 class="font-semibold text-xl text-neutral-50 leading-tight">
                Order (ID: {{ order.id }})
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
                                        <p class="mb-2 ml-1 text-sm font-medium text-neutral-50">First Name</p>
                                        <p class=" p-2 text-sm text-gray-500">{{ order.customer_name }}</p>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <p class="mb-2 ml-1 text-sm font-medium text-neutral-50">Restaurant</p>
                                        <p class=" p-2 text-sm text-gray-500">{{ order.restaurant.name }}</p>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="created"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Order
                                            Time</label>
                                        <div class="mt-2">
                                            <p class=" p-2 text-sm text-gray-500">{{ order.created }}</p>
                                        </div>
                                    </div>
                                    <div class="col-span-full">
                                        <label for="address"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Address</label>
                                        <div class="mt-2">
                                            <p class=" p-2 text-sm text-gray-500">{{ order.address }}</p>
                                        </div>
                                    </div>
                                    {{ console.log(order_status) }}
                                    <div class="sm:col-span-3">
                                        <label for="type" class="block text-sm font-medium leading-6 text-neutral-50">
                                            Status</label>
                                        <select id="status" v-model="form.status"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                            <option v-for="(value, key) in order_status" :key="key" :value="value">{{
                                                value }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mx-auto">
                                    <table class="min-w-56 divide-y divide-gray-200 border">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th colspan="4" class="px-6 py-3 text-center">
                                                    <h3 class="font-medium text-neutral-50">Item(s) Ordered</h3>
                                                </th>
                                            </tr>
                                            <tr class="text-center">
                                                <th
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider border">
                                                    Item
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider border">
                                                    Price
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="detail in order_details" :key="order_details.id">
                                                <td class="px-6 py-4 text-neutral-50 whitespace-nowrap border">{{
                                                    detail.item.name }}</td>
                                                <td class="px-6 py-4 text-neutral-50 whitespace-nowrap border">RM {{
                                                    detail.item.price }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <!-- button cancel -->
                                <Link :href="route('orders.index')">
                                <button type="button"
                                    class="text-sm font-semibold leading-6 text-neutral-50">Back</button>
                                </Link>
                                <PrimaryButton type="submit">
                                    Submit
                                </PrimaryButton>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
