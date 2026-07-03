<template>

  <div class="flex min-h-screen items-center justify-center bg-base-200">
    <div class="card w-full max-w-sm shadow-xl">
      <div class="card-body">

        <h2 class="card-title mb-4 justify-center text-2xl">Admin Login</h2>


        <Alert type="error" v-if="errors.email" :message="errors.email" />

        <form @submit.prevent="login">
          <fieldset class="fieldset">
            <legend class="fieldset-legend">Name</legend>
            <input v-model="form.email" type="text" placeholder="Enter your name" class="input input-bordered w-full"
              required />
          </fieldset>

          <fieldset class="fieldset mt-4">
            <legend class="fieldset-legend">Password</legend>
            <input v-model="form.password" type="password" placeholder="Enter your password"
              class="input input-bordered w-full" required />
          </fieldset>


          <button type="submit" class="btn btn-primary mt-6 w-full">
            Login
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ errors: Object })
import { reactive } from 'vue'
import { useForm } from "@inertiajs/vue3"
import Alert from '@/Components/Admin/UI/Alert.vue'

const form = useForm({
  email: '',
  password: '',
})
function login() {
  console.log('Clicked')
  form.post(route('admin.auth.login'))
}

</script>
