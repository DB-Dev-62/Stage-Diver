<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/ressort-categories">Kategorien</Link>
      <span class="font-medium ml-2">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="ressortCategories.deleted_at" class="mb-6" @restore="restore"> This Category has been deleted. </trashed-message>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!ressortCategories.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Löschen</button>
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
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    ressortCategories: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.ressortCategories.name,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/ressort-categories/${this.ressortCategories.id}`)
    },
    destroy() {
      if (confirm('Wirklich löschen?')) {
        this.$inertia.delete(`/ressort-categories/${this.ressortCategories.id}`)
      }
    },
    restore() {
      if (confirm('Wirklich wiederherstellen?')) {
        this.$inertia.put(`/ressort-categories/${this.ressortCategories.id}/restore`)
      }
    },
  },
}
</script>
