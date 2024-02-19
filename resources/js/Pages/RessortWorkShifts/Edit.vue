<template>
  <div>
    <Head title="Ändere Schichtzeit" />
    <h1 class="mb-8 text-xl font-bold">
      Ressorts<span class="font-medium ml-2">/</span> <Link class="text-indigo-400 hover:text-indigo-600" :href="`/ressorts/${ressort.id}/work-shifts`">{{ ressort.name }}</Link>
      <span class="font-medium ml-2">/</span> Schichtzeiten<span class="font-medium ml-2">/</span> Ändern
    </h1>
    <trashed-message v-if="ressortWorkShift.deleted_at" class="mb-6" @restore="restore"> This work shift has been deleted. </trashed-message>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.day" label="Tag" :error="form.errors.day" class="pb-8 pr-6 w-full">
            <option value="DO">Donnerstag</option>
            <option value="FR">Freitag</option>
            <option value="SA">Samstag</option>
            <option value="SO">Sonntag</option>
            <option value="MO">Montag</option>
          </select-input>
          <text-input v-model="form.time_start" :error="form.errors.time_start" class="pb-8 pr-6 w-full lg:w-1/2" rows="4" label="Startzeit" />
          <text-input v-model="form.time_end" :error="form.errors.time_end" class="pb-8 pr-6 w-full lg:w-1/2" rows="4" label="Endzeit" />
          <text-input v-model="form.supporter_min" :error="form.errors.supporter_min" class="pb-8 pr-6 w-full lg:w-1/2" rows="4" label="Helfer (Mindestanzahl)" />
          <text-input v-model="form.supporter_max" :error="form.errors.supporter_max" class="pb-8 pr-6 w-full lg:w-1/2" rows="4" label="Helfer (Maximalanzahl)" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!ressortWorkShift.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Löschen</button>
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
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    TextInput,
    TrashedMessage,
    SelectInput,
  },
  layout: Layout,
  props: {
    ressort: Object,
    ressortWorkShift: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        ressort_name: this.ressortWorkShift.ressort_name,
        day: this.ressortWorkShift.day,
        time_start: this.ressortWorkShift.time_start,
        time_end: this.ressortWorkShift.time_end,
        supporter_min: this.ressortWorkShift.supporter_min,
        supporter_max: this.ressortWorkShift.supporter_max,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/ressorts/${this.ressort.id}/work-shifts/${this.ressortWorkShift.id}`)
    },
    destroy() {
      if (confirm('Wirklich löschen?')) {
        this.$inertia.delete(`/ressorts/${this.ressort.id}/work-shifts/${this.ressortWorkShift.id}`)
      }
    },
    restore() {
      if (confirm('Wirklich wiederherstellen?')) {
        this.$inertia.put(`/ressorts/${this.ressort.id}/work-shifts/${this.ressortWorkShift.id}/restore`)
      }
    },
  },
}
</script>
