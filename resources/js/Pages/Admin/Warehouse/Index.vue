<template>
  <div class="min-h-screen bg-base-200/50" dir="rtl">
    <div class="max-w-4xl mx-auto px-4 py-6 md:py-10">

      <!-- Header with back button -->
      <div class="mb-6">
        <Link :href="route('admin.warehouse.allwarehouses')" class="btn btn-ghost btn-sm gap-2 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
          </svg>
          العودة
        </Link>

        <div class="bg-base-100 border border-base-300 rounded-2xl shadow-sm px-6 py-5">
          <p class="text-xs font-semibold uppercase tracking-widest text-base-content/40 mb-2">إدارة المخزون</p>
          <h1 class="text-2xl font-bold text-base-content">مخزن {{ warehouse.name }}</h1>
        </div>
      </div>

      <Alert v-if="page.flash.message" type="success" :message="page.flash.message" class="mb-4" />

      <div v-if="products.length" class="flex flex-col gap-4">
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
          :quantity="items[product.id]"
          @quantity-changed="items[product.id] = $event"
        />

        <button @click="submit" class="btn btn-primary w-full rounded-xl mt-2">تأكيد الصرف</button>
      </div>

      <div v-else class="bg-base-100 border border-dashed border-base-300 rounded-2xl py-20 flex flex-col items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M17.25 6.75l-6-6-6 6m12-6v18a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 20.25V6.75" />
        </svg>
        <h3 class="font-semibold text-base-content/50">لا توجد مواد في المخزن</h3>
        <p class="text-sm text-base-content/40">قم بإضافة مواد جديدة لتظهر هنا</p>
      </div>

    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
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
  props.products.forEach(product => items[product.id] = 0)
}
</script>
