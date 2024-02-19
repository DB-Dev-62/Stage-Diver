<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <Link href="/login">
        <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      </Link>
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="submit">
        <div class="px-10 py-12">
          <div v-if="status.length" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
          </div>
          <div class="mb-4 text-sm text-gray-600">
            Teilen Sie uns bitte Ihre E-Mail-Adresse mit und wir senden Ihnen einen Link zum Zurücksetzen des Passworts per E-Mail zu.
          </div>
          <div>
            <text-input v-model="form.email" :error="errors.email" class="mt-10" label="E-Mail-Adresse" type="email" autofocus autocapitalize="off" />
          </div>
        </div>
        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex items-center justify-between">
          <Link class="text-sm" href="/login">
            Zurück zur Anmeldung
          </Link>
          <loading-button :loading="form.processing" class="ml-auto btn-indigo" type="submit">Link anfordern</loading-button>
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
    status: String,
    errors: Object,
  },
  data() {
    return {
      form: {
        email: '',
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.post('/forgot-password', this.form)
    },
  },
}
</script>
<!-- batmaz.d@gmail.com -->
