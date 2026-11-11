<template>
  <div
    class="group bg-base-100 border border-base-300/70 rounded-2xl shadow-sm
           hover:shadow-md hover:border-primary/30 transition-all duration-200
           overflow-hidden"
    dir="rtl"
  >
    <div class="p-4 sm:p-5">

      <!-- Product Information -->
      <div class="flex items-start gap-3 sm:gap-4">

        <!-- Product Image -->
        <div
          class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-xl
                 bg-base-200 border border-base-300/70 overflow-hidden
                 flex items-center justify-center"
        >
          <img
            v-if="product.image"
            :src="imageUrl"
            :alt="product.name"
            class="w-full h-full object-cover transition-transform duration-300
                   group-hover:scale-105"
          />

          <svg
            v-else
            class="w-8 h-8 text-base-content/20"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M3 7.5L12 3l9 4.5M3 7.5v9L12 21l9-4.5v-9M3 7.5l9 4.5m0 9v-9m0 0l9-4.5"
            />
          </svg>
        </div>

        <!-- Product Details -->
        <div class="flex-1 min-w-0 pt-0.5">

          <h3
            class="text-sm sm:text-base font-bold text-base-content
                   leading-7 whitespace-normal break-words"
          >
            {{ product.name }}
          </h3>

          <div class="flex flex-wrap items-center gap-2 mt-2">

            <span
              v-if="product.product_type"
              class="inline-flex items-center gap-1.5 text-xs
                     text-base-content/60 bg-base-200
                     rounded-lg px-2.5 py-1"
            >
              {{ product.product_type.name }}
            </span>

            <span
              class="inline-flex items-center gap-1.5 text-xs font-semibold
                     rounded-lg px-2.5 py-1"
              :class="Number(product.stock_in_warehouse) > 0
                ? 'bg-success/10 text-success'
                : 'bg-error/10 text-error'"
            >
              <span
                class="w-1.5 h-1.5 rounded-full"
                :class="Number(product.stock_in_warehouse) > 0
                  ? 'bg-success'
                  : 'bg-error'"
              ></span>

              {{ product.stock_in_warehouse }} متوفر
            </span>

          </div>
        </div>
      </div>

      <!-- Quantity Selector -->
      <div
        class="flex items-center justify-between gap-3
               mt-4 pt-4 border-t border-base-200"
      >

        <div class="min-w-0">
          <p class="text-sm font-semibold text-base-content">
            الكمية المطلوبة
          </p>
          <p class="text-xs text-base-content/40 mt-1">
            حدد كمية الصرف
          </p>
        </div>

        <!-- Counter -->
        <div
          class="join border border-base-300 rounded-xl
                 bg-base-100 shrink-0 overflow-hidden"
          dir="ltr"
        >
          <button
            type="button"
            class="join-item btn btn-ghost btn-sm w-10 min-h-11 h-11
                   rounded-none text-lg"
            :disabled="currentQuantity <= 0"
            @click="updateQuantity(currentQuantity - 1)"
            aria-label="تقليل الكمية"
          >
            −
          </button>

          <input
            type="number"
            min="0"
            :max="maxQuantity"
            :value="currentQuantity"
            @input="handleInput"
            class="join-item input input-ghost input-sm w-14 sm:w-16
                   min-h-11 h-11 rounded-none text-center font-bold
                   text-base-content focus:outline-none
                   [appearance:textfield]
                   [&::-webkit-inner-spin-button]:appearance-none
                   [&::-webkit-outer-spin-button]:appearance-none"
            aria-label="الكمية المطلوبة"
          />

          <button
            type="button"
            class="join-item btn btn-ghost btn-sm w-10 min-h-11 h-11
                   rounded-none text-lg"
            :disabled="currentQuantity >= maxQuantity"
            @click="updateQuantity(currentQuantity + 1)"
            aria-label="زيادة الكمية"
          >
            +
          </button>
        </div>

      </div>

      <!-- Selected Quantity Indicator -->
      <div
        v-if="currentQuantity > 0"
        class="flex items-center justify-between mt-3 px-3 py-2
               rounded-lg bg-primary/5 text-primary"
      >
        <span class="text-xs font-medium">الكمية المحددة للصرف</span>
        <span class="text-sm font-bold">{{ currentQuantity }}</span>
      </div>

    </div>
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

const imageUrl = computed(() => `/storage/${props.product.image}`)

const maxQuantity = computed(() => {
  return Math.max(0, Number(props.product.stock_in_warehouse) || 0)
})

const currentQuantity = computed(() => {
  return Math.min(
    maxQuantity.value,
    Math.max(0, Number(props.quantity) || 0)
  )
})

function updateQuantity(value) {
  const quantity = Math.min(
    maxQuantity.value,
    Math.max(0, Math.floor(Number(value) || 0))
  )

  emit('quantity-changed', quantity)
}

function handleInput(event) {
  updateQuantity(event.target.value)
}
</script>