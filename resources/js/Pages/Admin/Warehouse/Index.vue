<template>
  <div class="min-h-screen bg-base-200/50" dir="rtl">
    <div class="max-w-4xl mx-auto px-4 py-10">

      <div class="mb-8">
        <div class="bg-base-100 border border-base-300 rounded-2xl shadow-sm px-6 py-5">
          <p class="text-xs font-semibold uppercase tracking-widest text-base-content/40 mb-2">إدارة المخزون</p>
          <h1 class="text-2xl font-bold text-base-content">مخزن {{ warehouse.name }}</h1>
        </div>
      </div>

      <Alert v-if="page.flash.message" type="success" :message="page.flash.message" class="mb-4" />

      <div v-if="products.length" class="flex flex-col gap-3">
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
        <h3 class="font-semibold text-base-content/50">لا توجد مواد في المخزن</h3>
        <p class="text-sm text-base-content/40">قم بإضافة مواد جديدة لتظهر هنا</p>
      </div>

    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
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
