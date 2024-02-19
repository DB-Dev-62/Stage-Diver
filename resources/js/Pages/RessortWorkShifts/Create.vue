<template>
  <div>
    <Head title="Erstelle Schichtzeit" />
    <h1 class="mb-8 text-xl font-bold">
      Ressorts<span class="font-medium ml-2">/</span> <Link class="text-indigo-400 hover:text-indigo-600" :href="`/ressorts/${ressort.id}/work-shifts`">{{ ressort.name }}</Link>
      <span class="font-medium ml-2">/</span> Schichtzeiten<span class="font-medium ml-2">/</span> Erstellen
    </h1>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.day" label="Tag" :error="form.errors.day" class="pb-8 pr-6 w-full">
            <option value="DO">Donnerstag</option>
            <option value="FR">Freitag</option>
            <option value="SA">Samstag</option>
            <option value="SO">Sonntag</option>
            <option value="MO">Montag</option>
          </select-input>
          <text-input v-model="form.time_start" :error="form.errors.time_start" class="pb-8 pr-6 w-full lg:w-1/2" label="Startzeit" />
          <text-input v-model="form.time_end" :error="form.errors.time_end" class="pb-8 pr-6 w-full lg:w-1/2" label="Endzeit" />
          <text-input v-model="form.supporter_min" :error="form.errors.supporter_min" class="pb-8 pr-6 w-full lg:w-1/2" label="Helfer (Mindestanzahl)" />
          <text-input v-model="form.supporter_max" :error="form.errors.supporter_max" class="pb-8 pr-6 w-full lg:w-1/2" label="Helfer (Maximalanzahl)" />
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
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'


export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    ressortSelect: Object,
    ressort: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        ressort_id: null,
        day: null,
        time_start: null,
        time_end: null,
        supporter_min: null,
        supporter_max: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(`/ressorts/${this.ressort.id}/work-shifts`)
    },
  },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
