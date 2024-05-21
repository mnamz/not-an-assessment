<script setup>
import { ref, computed, onMounted, reactive } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import ItemModal from '@/Components/ItemModal.vue';
import Swal from 'sweetalert2';

const restaurants = ref([]);
const selectedItem = ref(null);
const isModalOpen = ref(false);
const searchQuery = ref('');
const selectedCategory = ref('');
const categories = ref([]);

const openModal = (item) => {
    selectedItem.value = item;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const fetchRestaurants = async () => {
    try {
        const response = await axios.get('/api/restaurants');
        restaurants.value = response.data.data;
        categories.value = [...new Set(response.data.data.flatMap(restaurant => restaurant.categories))];
    } catch (error) {
        console.error('Failed to fetch restaurants:', error);
    }
};

const filteredRestaurants = computed(() => {
    let filtered = restaurants.value;
    if (searchQuery.value) {
        filtered = filtered.filter(restaurant =>
            restaurant.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            restaurant.items.some(item => item.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
        );
    }
    if (selectedCategory.value) {
        filtered = filtered.filter(restaurant =>
            restaurant.categories.includes(selectedCategory.value)
        );
    }
    return filtered;
});

const cartItems = ref(JSON.parse(sessionStorage.getItem('cartItems')) || []);
const showSuccessAlert = ref(false);

const addToCart = (item) => {
    cartItems.value.push(item);
    sessionStorage.setItem('cartItems', JSON.stringify(cartItems.value));
    Swal.fire({
        title: 'Success',
        icon: 'success',
        text: 'Added item to cart',
        confirmButtonText: 'Go to Cart',
        cancelButtonText: 'Continue Shopping',
        showConfirmButton: true,
        showCancelButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/cart';
        }
    });
};

onMounted(() => {
    fetchRestaurants();
});

</script>

<template>

    <Head title="Welcome" />
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">NotGrabFood</h1>
        <!-- Filter Section -->
        <div class="mb-4">
            <input v-model="searchQuery" type="text" placeholder="Search for food or restaurants"
                class="border rounded p-2 mr-2 w-80" />
            <select v-model="selectedCategory" class="border rounded p-2 w-80">
                <option value="">All Categories</option>
                <option v-for="category in categories" :key="category" :value="category">
                    {{ category }}
                </option>
            </select>
        </div>
        <!-- End Filter Section -->

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="restaurant in filteredRestaurants" :key="restaurant.id"
                class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-xl font-semibold">{{ restaurant.name }}</h2>
                <p class="text-gray-600">{{ restaurant.location }}</p>
                <div v-if="restaurant.categories && restaurant.categories.length" class="mt-2">
                    <span class="text-sm font-medium text-gray-500">Categories: </span>
                    <span v-for="(category, index) in restaurant.categories" :key="index" class="text-sm text-gray-700">
                        {{ category }}<span v-if="index < restaurant.categories.length - 1">, </span>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-medium">Menu</h3>
                    <ul class="list-disc list-inside">
                        <li v-for="item in restaurant.items" :key="item.id" @click="openModal(item)"
                            class="list-none cursor-pointer text-blue-500 no-underline">
                            <span class="font-semibold">{{ item.name }}</span> - RM {{ item.price }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-4">
        <h3>Cart</h3>
        <div v-for="(items, restaurantId) in segmentedCart" :key="restaurantId">
            <h4>{{ restaurantId }}</h4>
            <ul>
                <li v-for="item in items" :key="item.id">{{ item.name }} - RM {{ item.price }}</li>
            </ul>
        </div>
    </div>
    <ItemModal :is-open="isModalOpen" :item="selectedItem" :addToCart="addToCart" @close="closeModal" />
</template>


<style scoped>
/* Styling for the sticky cart banner */
/* You can customize this according to your design */
.fixed {
    position: fixed;
    z-index: 1000;
    /* Ensure the banner appears above other content */
}

.bg-gray-800 {
    background-color: #2c3e50;
}
</style>