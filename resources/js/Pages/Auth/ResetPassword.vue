<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <Link href="/login">
        <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      </Link>
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="submit">
        <div class="px-10 py-12">
          <div>
            <text-input v-model="form.email" :error="errors.email" class="mt-10" label="E-Mail-Adresse" type="email" autofocus autocapitalize="off" />
          </div>
          <div class="mt-4">
            <text-input v-model="form.password" :error="errors.password" class="mt-6" label="Passwort" type="password" />
          </div>
          <div class="mt-2">
            <text-input v-model="form.password_confirmation" :error="errors.password" class="mt-6" label="Passwort wiederholen" type="password" />
          </div>
        </div>
        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
          <loading-button :loading="form.processing" class="ml-auto btn-indigo" type="submit">Passwort zurücksetzen</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'


export default {
  components: {
    LoadingButton,
    Logo,
    TextInput,
    Link,
  },
  props: {
    token: String,
    email: String,
    errors: Object,
  },
  data() {
    return {
      form: {
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.post('/password-reset', this.form)
    },
  },
}
</script>

