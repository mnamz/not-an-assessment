<script>
import { ref, computed, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import axios from 'axios';

export default {
    setup() {
        const form = useForm({
            amount: '',
            pmethod: '',
        });

        const submitForm = () => {
            form.post(route('paypal'));
        };

        return {
            form,
            submitForm,
        };
    },
    data() {
        return {
            cartItems: JSON.parse(sessionStorage.getItem('cartItems')) || [],
            restaurants: [],
            deliveryOption: 'pickup',
            paymentMethod: 'cash',
            deliveryCharge: 0,
            customerName: '',
            customerAddress: '',
            restaurantNamesCache: {},
        };
    },
    computed: {
        segmentedCart() {
            const segmented = {};
            this.cartItems.forEach(item => {
                const restaurantId = item.restaurant_id;
                if (!segmented[restaurantId]) {
                    segmented[restaurantId] = [];
                }
                segmented[restaurantId].push(item);
            });
            return segmented;
        },
        totalItems() {
            return this.cartItems.length;
        },
        totalPrice() {
            return this.cartItems.reduce((total, item) => {
                return total + parseFloat(item.price);
            }, 0);
        },
        grandTotal() {
            return this.totalPrice + this.deliveryCharge;
        }
    },
    methods: {
        async fetchRestaurantName() {
            try {
                const response = await axios.get('/api/restaurants');
                this.restaurants = response.data.data;
            } catch (error) {
                console.error('Error fetching restaurants:', error);
            }
        },
        async proceedOrder() {
            try {
                const response = await axios.post('/api/process-order', {
                    items: this.cartItems, customerName: this.customerName,
                    customerAddress: this.customerAddress,
                    deliveryCharge: this.deliveryCharge,
                    deliveryOption: this.deliveryOption,
                    paymentMethod: this.paymentMethod,
                    amount: this.grandTotal,
                });
                console.log('Order successfully processed:', response.data);
                if(response.data === 'cod'){
                    window.location.href = '/success-cod';
                } else {
                    window.location.href = response.data; // this must be paypal link
                }
                this.clearCart();
            } catch (error) {
                console.error('Error processing order:', error);
            }
        },
        getRestaurantName(restaurantId) {
            // find if passed restaurantId matches with fetched restaurants
            const restaurant = this.restaurants.find(r => r.id == restaurantId);
            return restaurant ? restaurant.name : 'Unknown Restaurant';
        },
        updateTotal() {
            this.deliveryCharge = this.deliveryOption === 'delivery' ? 5 : 0;
        },
        restaurantTotal(restaurantId) {
            return this.segmentedCart[restaurantId].reduce((total, item) => {
                return total + parseFloat(item.price);
            }, 0);
        },
        clearCart() {
            this.cartItems = [];
            sessionStorage.removeItem('cartItems');
        }
    },
    components: { Link, Head, PrimaryButton },
    async mounted() {
        this.fetchRestaurantName().then(() => {
            this.updateTotal();
        });
    }
}
</script>
<template>

    <Head title="Cart" />
    <div class="container mx-auto p-4">
        <Link :href="route('home')">
        <h1 class="text-2xl font-bold mb-4">NotGrabFood</h1>
        </Link>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Cart Items -->
            <div class="col-span-2">
                <div v-for="(items, restaurantId) in segmentedCart" :key="restaurantId"
                    class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <h2 class="text-xl font-semibold">{{ getRestaurantName(restaurantId) }}</h2>
                    <ul class="list-disc list-inside">
                        <li v-for="item in items" :key="item.id" class="mt-2">
                            <span class="font-semibold">{{ item.name }}</span> - RM {{ item.price }}
                        </li>
                    </ul>
                    <p class="mt-2 font-semibold">Total: RM {{ restaurantTotal(restaurantId).toFixed(2) }}</p>
                </div>
            </div>
            <!-- Cart Summary -->
            <div class="col-span-1 bg-white shadow-md rounded-lg p-4">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                <div class="mb-4">
                    <p>Total Items: {{ totalItems }}</p>
                    <p>Total Price: RM {{ totalPrice.toFixed(2) }}</p>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold">Delivery or Pickup</label>
                    <div class="flex flex-row justify-start">
                        <div>
                            <input type="radio" id="pickup" value="pickup" v-model="deliveryOption"
                                @change="updateTotal">
                            <label class="px-2" for="pickup">Pickup</label>
                        </div>
                        <div class="mx-3">
                            <input type="radio" id="delivery" value="delivery" v-model="deliveryOption"
                                @change="updateTotal">
                            <label class="px-2" for="delivery">Delivery (+ RM 5.00)</label>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold">Payment Method</label>
                    <div class="flex flex-row justify-start">
                        <div>
                            <input type="radio" id="cash" value="cash" v-model="paymentMethod">
                            <label class="px-2" for="cash">Cash</label>
                        </div>
                        <div class="mx-3">
                            <input type="radio" id="paypal" value="paypal" v-model="paymentMethod">
                            <label class="px-2" for="paypal">Card (Paypal)</label>
                        </div>
                    </div>

                </div>
                <div class="mt-4">
                    <h1 class="font-semibold">Grand Total: RM {{ grandTotal.toFixed(2) }}</h1>
                </div>
                <div class="mb-4 mt-4">
                    <label for="customerName" class="block font-semibold">Customer Name</label>
                    <input type="text" id="customerName" v-model="customerName"
                        class="border border-gray-300 rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="customerAddress" class="block font-semibold">Customer Address</label>
                    <input type="text" id="customerAddress" v-model="customerAddress"
                        class="border border-gray-300 rounded-md p-2 w-full">
                </div>
                <div class="mt-4 flex justify-start">
                    <button @click="clearCart" class="bg-red-500 text-white px-4 py-2 rounded-md">Clear Cart</button>
                    <button @click="proceedOrder" :disabled="!customerName && !customerAddress" :class="customerName ? 'opacity-100' : 'opacity-25'" class="bg-green-500 text-white px-4 py-2 mx-2 rounded-md">Proceed
                        Order</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.container {
    max-width: 1200px;
}
</style>