<template>
    <div class="p-4 md:p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Warehouses</h1>
            <p class="text-sm opacity-70">{{ warehouses.length }} {{ warehouses.length === 1 ? 'warehouse' : 'warehouses' }} total</p>
        </div>

        <!-- Empty state -->
        <div v-if="warehouses.length === 0" role="alert" class="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L12 3l9 4.5M3 7.5v9L12 21m-9-4.5L12 21m0 0l9-4.5m-9 4.5v-9m9 4.5v-9M3 7.5L12 12m0 0l9-4.5M12 12v9" />
            </svg>
            <span>No warehouses found</span>
        </div>

        <!-- Warehouse grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="warehouse in warehouses" :key="warehouse.id" class="card card-compact bg-base-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">{{ warehouse.name }}</h2>
                    <div class="flex items-center gap-1 text-sm opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        {{ warehouse.location }}
                    </div>
                    <div class="card-actions justify-end">
                        <Link :href="route('admin.warehouse', warehouse.id)" class="btn btn-sm btn-primary">
                            Visit
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps(['warehouses'])
</script>
