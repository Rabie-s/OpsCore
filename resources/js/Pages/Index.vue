<template>
    <div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300">
        <div class="min-h-screen flex flex-col items-center justify-center p-6">
            <!-- Logo Icon -->
            <div class="mb-8">
                <div class="w-24 h-24 rounded-3xl bg-primary/10 flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-2">OpsCore</h1>
            <p class="text-lg text-base-content/60 text-center mb-2">نظام إدارة المخزون</p>
            <p class="text-base-content/50 text-center mb-8">مركز عجلون - مراكز الخدمات الحكومية</p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="/warehouses" class="btn btn-primary">
                    جميع المخازن
                </a>
                <a href="/admin" class="btn btn-outline">
                    لوحة التحكم
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer footer-center p-4 bg-base-300 text-base-content text-sm">
            <p>Developed by <strong>Rabie Smadi</strong> | GSC Ajloun</p>
        </footer>
    </div>
</template>

<script setup>
// Simple landing page
</script>
