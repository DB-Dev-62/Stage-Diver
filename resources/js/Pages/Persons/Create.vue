<template>
  <div>
    <Head title="Erstelle Helfer" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/persons">Helfer</Link>
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

          <text-input v-model="form.phone" :error="form.errors.phone" class="pb-8 pr-6 w-full lg:w-1/2" label="Telefon" />
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="E-Mail" />
          <select-input v-model="form.year" :error="form.errors.year" class="pb-8 pr-6 w-full lg:w-1/2" label="Jahr">
            <option :value="null" />
            <option v-for="year in nextYears" :key="year" :value="year">{{ year }}</option>
          </select-input>
          <select-input v-model="form.registered" :error="form.errors.registered" class="pb-8 pr-6 w-full lg:w-1/2" label="Angemeldet">
            <option :value="null" />
            <option value="1">Ja</option>
            <option value="0">Nein</option>
          </select-input>
          <select-input v-model="form.friday" :error="form.errors.friday" class="pb-8 pr-6 w-full lg:w-1/2" label="Freitag">
            <option :value="null" />
            <option value="1">Ja</option>
            <option value="0">Nein</option>
          </select-input>
          <select-input v-model="form.saturday" :error="form.errors.saturday" class="pb-8 pr-6 w-full lg:w-1/2" label="Samstag">
            <option :value="null" />
            <option value="1">Ja</option>
            <option value="0">Nein</option>
          </select-input>
          <select-input v-model="form.sunday" :error="form.errors.sunday" class="pb-8 pr-6 w-full lg:w-1/2" label="Sonntag">
            <option :value="null" />
            <option value="1">Ja</option>
            <option value="0">Nein</option>
          </select-input>
          <select-input v-model="form.t_shirt_size" :error="form.errors.t_shirt_size" class="pb-8 pr-6 w-full lg:w-1/2" label="T-Shirt Größen">
            <option :value="null" />
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="2XL">2XL</option>
            <option value="3XL">3XL</option>
            <option value="4XL">4XL</option>
            <option value="5XL">5XL</option>
          </select-input>
          <select-input v-model="form.t_shirt_picked_up" :error="form.errors.t_shirt_picked_up" class="pb-8 pr-6 w-full lg:w-1/2" label="T-Shirt abgeholt">
            <option :value="null" />
            <option value="1">Ja</option>
            <option value="0">Nein</option>
          </select-input>
          <select-input v-model="form.food" :error="form.errors.food" class="pb-8 pr-6 w-full lg:w-1/2" label="Essen">
            <option :value="null" />
            <option value="Fleisch">Omnivore</option>
            <option value="Vegetarier">Vegetarisch</option>
            <option value="Veganer">Vegan</option>
          </select-input>
          <textarea-input v-model="form.allergies" :error="form.errors.allergies" class="pb-8 pr-6 w-full lg:w-2/2" rows="4" label="Allergien" />
          <textarea-input v-model="form.other" :error="form.errors.other" class="pb-8 pr-6 w-full lg:w-2/2" rows="4" label="Sonstiges" />
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
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TextareaInput from '@/Shared/TextareaInput'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput,
  },
  layout: Layout,
  props: {
    ressortCategorySelect: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        ressort_category_id: null,
        phone: null,
        email: null,
        year: null,
        registered: null,
        friday: null,
        friday_beer: null,
        saturday: null,
        saturday_beer: null,
        sunday: null,
        sunday_beer: null,
        t_shirt_size: null,
        t_shirt_picked_up: null,
        food: null,
        allergies: null,
        other: null,
        note: null,
      }),
    }
  },
  computed: {
    currentYear() {
      return new Date().getFullYear()
    },
    nextYears() {
      return [this.currentYear, this.currentYear + 1, this.currentYear + 2]
    },
  },
  methods: {
    store() {
      this.form.post('/persons')
    },
  },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
