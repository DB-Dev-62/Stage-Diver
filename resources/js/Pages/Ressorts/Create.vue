<template>
  <div>
    <Head title="Erstelle Ressort" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/ressorts">Ressort</Link>
      <span class="font-medium ml-2">/</span> Erstellen
    </h1>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />

          <select-input v-model="form.ressort_category_id" :error="form.errors.ressort_category_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Kategorie">
            <option :value="null" />
            <option v-for="category in ressortCategorySelect" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select-input>
          <textarea-input v-model="form.info" :error="form.errors.info" class="pb-8 pr-6 w-full lg:w-2/2" rows="4" label="Info" />
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
import SelectInput from '@/Shared/SelectInput'
import TextareaInput from '@/Shared/TextareaInput'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextareaInput,
    TextInput,
  },
  layout: Layout,
  props: {
    ressortCategorySelect: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        ressort_category_id: null,
        name: null,
        supporter: null, //TODO kann weg ?!
        info:null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/ressorts')
    },
  },
}
</script>
