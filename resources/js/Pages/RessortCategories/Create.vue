<template>
  <div>
    <Head title="Erstelle Kategorie" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/ressort-categories">Kategorien</Link>
      <span class="font-medium ml-2">/</span> Erstellen
    </h1>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
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
import SelectInput from '@/Shared/SelectInput'


export default {
  components: {
    SelectInput,
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
        ressort: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/ressort-categories')
    },
  },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
