<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/ressorts">Ressorts</Link>
      <span class="font-medium ml-2">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="ressort.deleted_at" class="mb-6" @restore="restore"> This ressort has been deleted. </trashed-message>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div id="printarea" class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <select-input v-model="form.ressort_category_id" :error="form.errors.ressort_category_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Kategorie">
            <option :value="null" />
            <option v-for="category in ressortCategorySelect" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select-input>
          <textarea-input v-model="form.info" :error="form.errors.info" class="pb-8 pr-6 w-full lg:w-2/2" rows="4" label="Info" />
        </div>

        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!ressort.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Löschen</button>
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
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import SelectInput from '@/Shared/SelectInput'
import TextareaInput from '@/Shared/TextareaInput'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
    TextareaInput,
  },
  layout: Layout,
  props: {
    ressort: Object,
    ressortCategorySelect: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.ressort.name,
        ressort_category_id: this.ressort.ressort_category_id,
        ressort_category_name: this.ressort.ressort_category_name,
        info: this.ressort.info,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/ressorts/${this.ressort.id}`)
    },
    destroy() {
      if (confirm('Wirklich löschen?')) {
        this.$inertia.delete(`/ressorts/${this.ressort.id}`)
      }
    },
    restore() {
      if (confirm('Wirklich wiederherstellen?')) {
        this.$inertia.put(`/ressorts/${this.ressort.id}/restore`)
      }
    },
  },
}
</script>
