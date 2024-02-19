<template>
  <div>
    <Head title="Erstelle Gast" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/guests">Gast</Link>
      <span class="font-medium ml-2">/</span> Erstellen
    </h1>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
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
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Erstellen</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import TextareaInput from '@/Shared/TextareaInput'


export default {
  components: {
    TextareaInput,
    Head,
    Link,
    LoadingButton,
    TextInput,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        days: null,
        number_of_person: null,
        note: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/guests')
    },
  },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
