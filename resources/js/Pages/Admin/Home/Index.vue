<template>
    <div class="min-h-screen bg-base-200">
        <!-- Hero Section -->
        <div class="hero min-h-screen" style="background-image: url(https://gsc.jo/images/feature/1.jpg);">
            <div class="hero-overlay bg-opacity-70"></div>
            <div class="hero-content text-center text-neutral-content">
                <div class="max-w-2xl">
                    <h1 class="mb-5 text-5xl font-bold">مراكز الخدمات الحكومية</h1>
                    <h2 class="mb-5 text-3xl font-bold">مركز عجلون</h2>
                    <p class="mb-8 text-xl">
                        نظام إدارة المخزون - OpsCore
                    </p>
                    <p class="mb-5">
                        نظام متكامل لإدارة المخزون وتتبع حركة المواد داخل المستودعات
                    </p>
                    <a href="/admin" class="btn btn-primary btn-lg">تسجيل الدخول</a>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="hero py-20 bg-base-200">
            <div class="hero-content flex-col lg:flex-row gap-10">
                <div class="card bg-base-100 shadow-xl max-w-md">
                    <div class="card-body">
                        <h3 class="card-title text-2xl mb-4">عن مراكز الخدمات الحكومية</h3>
                        <p class="text-base leading-relaxed">
                            انطلاقاً من التوجيهات الملكية السامية، جاءت مراكز الخدمات الحكومية
                            كأحد مخرجات البرنامج التنفيذي لخارطة تطوير القطاع العام بهدف الارتقاء
                            بجودة الخدمات الحكومية وتحسين تجربة المواطن في الحصول عليها.
                        </p>
                        <p class="text-base leading-relaxed mt-4">
                            ترتكز هذه المراكز على قيم الشفافية والعدالة والمساواة، والابتكار،
                            والمهنية والمسؤولية والتكامل المؤسسي.
                        </p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl max-w-md">
                    <div class="card-body">
                        <h3 class="card-title text-2xl mb-4">عن النظام</h3>
                        <p class="text-base leading-relaxed">
                            نظام OpsCore هو نظام متكامل لإدارة المخزون يوفر:
                        </p>
                        <ul class="text-base mt-4 space-y-2">
                            <li class="flex items-center gap-2">
                                <span class="badge badge-primary">✓</span>
                                تتبع دقيق لحركة المواد داخل المستودعات
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="badge badge-primary">✓</span>
                                إدارة شاملة للمنتجات والتصنيفات
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="badge badge-primary">✓</span>
                                تقارير وإحصائيات مفصلة
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="badge badge-primary">✓</span>
                                واجهة سهلة الاستخدام
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer items-center p-10 bg-neutral text-neutral-content footer-center">
            <aside class="items-center grid-flow-col text-center">
                <div class="grid-flow-col gap-4 md:grid-flow-col">
                    <p class="text-lg">
                        Developed with ❤️ by <strong>Rabie Smadi</strong>
                    </p>
                    <p class="text-base">
                        For GSC Ajloun - Government Service Center
                    </p>
                    <p class="text-sm opacity-70">
                        © 2024 OpsCore Inventory Management System
                    </p>
                </div>
            </aside>
        </footer>
    </div>
</template>

<script setup>
// No additional logic needed for this static landing page
</script>
