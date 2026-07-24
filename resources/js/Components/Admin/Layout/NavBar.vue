<template>
    <div class="navbar bg-base-100 shadow-sm">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">daisyUI</a>
        </div>

        <div class="flex-none">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost">
                    <h3>Welcome: {{ user?.name ?? 'Guest' }}</h3>
                </div>
                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li v-if="!user">
                        <Link :href="route('admin.auth.login')">Login</Link>
                    </li>
                    <li v-if="user">
                        <Link method="post" :href="route('admin.auth.logout')">Logout</Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePage, router, Link } from '@inertiajs/vue3'
import { computed } from "vue";
const page = usePage()
const user = computed(() => page.props.auth.admin ?? null)


function logout() {
    router.post(route('admin.auth.logout'))
}

</script>