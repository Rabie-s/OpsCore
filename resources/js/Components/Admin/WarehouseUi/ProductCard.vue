<template>
  <div class="bg-base-100 border border-base-300 rounded-2xl flex items-center gap-5 px-5 py-4 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-200">
    <div class="shrink-0 w-20 h-20 rounded-xl overflow-hidden border border-base-300 bg-base-200">
      <img :src="imageUrl" :alt="product.name" class="w-full h-full object-cover" />
    </div>
    <div class="flex-1 min-w-0">
      <h3 class="font-bold text-base-content truncate">{{ product.name }}</h3>
      <div class="flex items-center gap-2 mt-2">
        <span class="text-xs text-base-content/40 bg-base-200 rounded-md px-2 py-0.5">{{ product.product_type.name }}</span>
        <span class="badge badge-ghost badge-sm font-semibold">{{ product.stock_in_warehouse }}</span>
      </div>
    </div>
    <input
      type="number"
      :value="quantity"
      @input="emit('quantity-changed', Number($event.target.value))"
      min="0"
      :max="product.stock_in_warehouse"
      class="input input-bordered input-md w-24 text-center shrink-0"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
  quantity: {
    type: Number,
    default: 0,
  },
})

const emit = defineEmits(['quantity-changed'])

const imageUrl = computed(() => {
  const baseUrl = import.meta.env.VITE_APP_URL || 'http://127.0.0.1:8000'
  return `${baseUrl}/storage/${props.product.image}`
})
</script>
