<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/persons">Helfer</Link>
      <span class="font-medium ml-2">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="person.deleted_at" class="mb-6" @restore="restore"> This person has been deleted. </trashed-message>
    <div class="max-w-5xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
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
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!person.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Löschen</button>
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
import TextareaInput from '@/Shared/TextareaInput'

export default {
  components: {
    TextareaInput,
    Head,
    Link,
    LoadingButton,
    TextInput,
    SelectInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    person: Object,
    ressortSelect: Object,
    ressortCategorySelect: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.person.name,
        ressort_category_id: this.person.ressort_category_id,
        ressort_category_name: this.person.ressort_category_name,
        email: this.person.email,
        phone: this.person.phone,
        year: this.person.year,
        registered: this.person.registered,
        friday: this.person.friday,
        friday_beer: this.person.friday_beer,
        saturday: this.person.saturday,
        saturday_beer: this.person.saturday_beer,
        sunday: this.person.sunday,
        sunday_beer: this.person.sunday_beer,
        t_shirt_size: this.person.t_shirt_size,
        t_shirt_picked_up: this.person.t_shirt_picked_up,
        food: this.person.food,
        allergies: this.person.allergies,
        other: this.person.other,
        note: this.person.note,
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
    update() {
      this.form.put(`/persons/${this.person.id}`)
    },
    destroy() {
      if (confirm('Wirklich löschen?')) {
        this.$inertia.delete(`/persons/${this.person.id}`)
      }
    },
    restore() {
      if (confirm('Wirklich wiederherstellen?')) {
        this.$inertia.put(`/persons/${this.person.id}/restore`)
      }
    },
  },
}
</script>
