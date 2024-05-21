<template>
    <div v-if="isOpen" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-4 rounded-lg w-1/3">
            <h2 class="text-2xl font-bold mb-4">{{ item.name }}</h2>
            <p class="text-lg">{{ item.details }}</p>
            <p class="text-lg font-semibold">Price: RM {{ item.price }}</p>
            <img :src="item.image" alt="Item image" class="mt-4 w-auto h-[200px]">
            <button @click="$emit('close')" class="mt-4 bg-blue-500 text-white p-2 rounded">Close</button>
            <button @click="addItemToCart" class="mt-4 bg-green-500 text-white p-2 mx-2 rounded">Add to Cart</button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  item: Object,
  isOpen: Boolean,
  addToCart: Function // Add the addToCart prop for adding item to cart
});

// Function to add item to cart
const addItemToCart = () => {
  props.addToCart(props.item);
};
</script>
