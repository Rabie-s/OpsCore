<template>
  <main class="min-h-screen bg-base-200/50" dir="rtl">

    <div class="max-w-3xl mx-auto px-3 sm:px-5 py-5 sm:py-8">

      <!-- Back Navigation -->
      <div class="mb-5">
        <Link
          :href="route('admin.warehouse.allwarehouses')"
          class="btn btn-ghost btn-sm gap-2 px-2"
        >
          <svg
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.7"
              d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
            />
          </svg>
          العودة للمخازن
        </Link>
      </div>

      <!-- Header -->
      <section
        class="bg-base-100 border border-base-300/70
               rounded-2xl shadow-sm p-4 sm:p-6 mb-5"
      >
        <div class="flex items-center gap-3">

          <div
            class="w-12 h-12 rounded-xl bg-primary/10
                   flex items-center justify-center text-primary shrink-0"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.7"
                d="M3 7.5L12 3l9 4.5M3 7.5v9L12 21l9-4.5v-9M3 7.5l9 4.5m0 9v-9m0 0l9-4.5"
              />
            </svg>
          </div>

          <div class="min-w-0">
            <p class="text-xs font-medium text-base-content/45 mb-1">
              إدارة المخزون
            </p>

            <h1 class="text-xl sm:text-2xl font-bold text-base-content break-words">
              {{ warehouse.name }}
            </h1>
          </div>

        </div>
      </section>

      <!-- Alert -->
      <Alert
        v-if="page.flash.message"
        type="success"
        :message="page.flash.message"
        class="mb-5"
      />

      <!-- Products -->
      <section v-if="products.length">

        <div class="flex items-center justify-between mb-4 px-1">

          <div>
            <h2 class="font-bold text-base-content">
              المواد المتوفرة
            </h2>
            <p class="text-xs text-base-content/45 mt-1">
              حدد الكميات التي تريد صرفها
            </p>
          </div>

          <span class="badge badge-primary badge-outline font-semibold">
            {{ products.length }} مادة
          </span>

        </div>

        <div class="space-y-3">
          <ProductCard
            v-for="product in products"
            :key="product.id"
            :product="product"
            :quantity="items[product.id]"
            @quantity-changed="items[product.id] = $event"
          />
        </div>

        <!-- Submit -->
        <div class="mt-5 sticky bottom-3 z-20">
          <button
            @click="submit"
            :disabled="!hasSelectedItems"
            class="btn btn-primary w-full rounded-xl min-h-12
                   shadow-lg text-base font-bold"
          >
            <svg
              class="w-5 h-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              />
            </svg>

            تأكيد صرف المواد
          </button>
        </div>

      </section>

      <!-- Empty State -->
      <section
        v-else
        class="bg-base-100 border border-dashed border-base-300
               rounded-2xl py-16 px-5 flex flex-col items-center
               justify-center text-center"
      >
        <div
          class="w-16 h-16 rounded-2xl bg-base-200
                 flex items-center justify-center mb-4"
        >
          <svg
            class="w-8 h-8 text-base-content/25"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M17.25 6.75l-6-6-6 6"
            />
          </svg>
        </div>

        <h3 class="font-bold text-base-content">
          لا توجد مواد في المخزن
        </h3>

        <p class="text-sm text-base-content/45 mt-2">
          قم بإضافة مواد جديدة لتظهر هنا.
        </p>
      </section>

    </div>
  </main>
</template>

<script setup>
import { reactive, computed, onMounted } from 'vue'
import { router, usePage, Link } from '@inertiajs/vue3'
import Alert from '@/Components/Admin/UI/Alert.vue'
import ProductCard from '@/Components/Admin/WarehouseUi/ProductCard.vue'

const props = defineProps({
  products: { type: Array, required: true },
  warehouse: { type: Object, required: true },
  warehouse_id: { type: String, required: true },
})

const page = usePage()
const items = reactive({})

const hasSelectedItems = computed(() => {
  return Object.values(items).some(quantity => Number(quantity) > 0)
})

onMounted(() => {
  props.products.forEach(product => {
    items[product.id] = 0
  })
})

function submit() {
  Object.entries(items).forEach(([productId, quantity]) => {
    if (quantity > 0) {
      router.post(route('admin.warehouse.withdraw'), {
        wareHouseId: props.warehouse_id,
        productId: Number(productId),
        quantity,
      })
    }
  })

  props.products.forEach(product => {
    items[product.id] = 0
  })
}
</script>