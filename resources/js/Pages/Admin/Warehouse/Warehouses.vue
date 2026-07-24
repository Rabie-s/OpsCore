<template>
    <div class="max-w-6xl mx-auto p-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">Warehouses</h1>
                <p class="text-sm text-base-content/60">
                    {{ warehouses.length }} {{ warehouses.length === 1 ? 'warehouse' : 'warehouses' }} total
                </p>
            </div>
        </div>

        <!-- Empty state -->
        <div v-if="warehouses.length === 0" class="hero bg-base-200 rounded-box py-16">
            <div class="hero-content text-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/30" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7.5L12 3l9 4.5M3 7.5v9L12 21m-9-4.5L12 21m0 0l9-4.5m-9 4.5v-9m9 4.5v-9M3 7.5L12 12m0 0l9-4.5M12 12v9" />
                    </svg>
                    <h3 class="font-semibold mt-4">No warehouses found</h3>
                    <p class="text-sm text-base-content/60 mt-1">Warehouses you create will show up here.</p>
                </div>
            </div>
        </div>

        <!-- Warehouse grid -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="warehouse in warehouses" :key="warehouse.id"
                class="card bg-base-100 border border-base-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="card-body gap-3">
                    <div class="flex items-start gap-3">
                        <div class="avatar placeholder shrink-0">
                            <div
                                class="bg-primary/10 text-primary rounded-lg w-11 h-11 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>
                        </div>
                        <div class="min-w-0">
                            <h2 class="card-title text-base leading-tight truncate">{{ warehouse.name }}</h2>
                            <p class="flex items-center gap-1 text-sm text-base-content/60 truncate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ warehouse.location }}
                            </p>
                        </div>
                    </div>

                    <div class="card-actions justify-end pt-2 border-t border-base-200">
                        <Link class="btn btn-primary btn-sm gap-1" :href="route('admin.warehouse', warehouse.id)">
                            Visit
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
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