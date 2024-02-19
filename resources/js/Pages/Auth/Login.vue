<template>
  <Head title="Login"/>
  <div class="flex items-center justify-center p-6 min-h-screen bg-indigo-800">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50"/>
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold">Willkommen zurück!</h1>
          <div class="mt-6 mx-auto w-24 border-b-2"/>
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="E-Mail" type="email"
                      autofocus autocapitalize="off"/>
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Passwort"
                      type="password"/>
          <div class="flex items-center justify-between mt-2">
            <div class="flex items-center">
              <label class="select-none" for="remember">
                <input id="remember" v-model="form.remember" class="mr-1" type="checkbox"/>
                <span class="text-sm">Angemeldet bleiben</span>
              </label>
            </div>
            <div class="text-sm">
              <Link class="text-medium text-right text-red-700 hover:text-red-500" href="/forgot-password">
                Passwort vergessen?
              </Link>
            </div>
          </div>
        </div>
        <div class="flex justify-center px-10 py-4 bg-gray-100 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Anmelden</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    LoadingButton,
    Logo,
    TextInput,
    Link,
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false,
      }),
    }
  },
  methods: {
    login() {
      this.form.post('/login')
    },
  },
}
</script>
