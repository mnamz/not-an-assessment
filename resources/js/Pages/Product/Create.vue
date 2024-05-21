<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm, Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';


const form = useForm({
    name: '',
    price: '',
    details: '',
    image: null,
});

const handleFileChange = (event) => {
    form.image = event.target.files[0];
};

const submitForm = () => {
    form.post(route("products.store"));
};

</script>

<template>
    <AppLayout title="Product">
        <template #header>
            <h2 class="font-semibold text-xl text-neutral-50 leading-tight">
                New Product
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
                                        <label for="name"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Name</label>
                                        <input id="name" type="text" v-model="form.name"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                            required>
                                        <InputError class="mt-2" :message="form.errors.name" />
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="price"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Price</label>
                                        <input id="price" type="number" v-model="form.price"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                            required>
                                        <InputError class="mt-2" :message="form.errors.price" />
                                    </div>
                                    <div class="col-span-fuebll">
                                        <label for="details"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Details</label>
                                        <textarea id="details" name="details" rows="3" v-model="form.details"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required></textarea>
                                        <InputError class="mt-2" :message="form.errors.details" />
                                    </div>
                                    <div class="col-span-full">
                                        <label for="image"
                                            class="block text-sm font-medium leading-6 text-neutral-50">Attachment</label>
                                        <input
                                            class="block w-full px-3 rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                            id="small_size" name="image" type="file" @change="handleFileChange" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <!-- button cancel -->
                                <Link :href="route('products.index')">
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
