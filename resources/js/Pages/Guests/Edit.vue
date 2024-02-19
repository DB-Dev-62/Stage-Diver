<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/guests">Gästeliste</Link>
      <span class="font-medium ml-2">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="guest.deleted_at" class="mb-6" @restore="restore"> This guest has been deleted. </trashed-message>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <div class="pb-8 pr-6 w-full lg:w-1/2">
            <label class="form-label">Tage</label>
            <select v-model="form.days" multiple="" class="form-select">
              <option value="DO">Donnerstag</option>
              <option value="FR">Freitag</option>
              <option value="SA">Samstag</option>
              <option value="SO">Sonntag</option>
              <option value="MO">Montag</option>
            </select>
          </div>
          <text-input v-model="form.number_of_person" :error="form.errors.number_of_person" class="pb-8 pr-6 w-full lg:w-1/2" label="Anzahl Personen" />
          <textarea-input v-model="form.note" :error="form.errors.note" class="pb-8 pr-6 w-full lg:w-2/2" rows="4" label="Bemerkung" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!guest.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Löschen</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Speichern</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'

import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Link,
    Head,
    LoadingButton,
    TextInput,
    TextareaInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    guest: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.guest.name,
        days: this.guest.days,
        number_of_person: this.guest.number_of_person,
        note: this.guest.note,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/guests/${this.guest.id}`)
    },
    destroy() {
      if (confirm('Wirklich löschen? guest?')) {
        this.$inertia.delete(`/guests/${this.guest.id}`)
      }
    },
    restore() {
      if (confirm('Wirklich wiederherstellen?')) {
        this.$inertia.put(`/guests/${this.guest.id}/restore`)
      }
    },
  },
}
</script>
