<template>
  <div>
    <Head title="Helfer" />
    <h1 class="mb-8 text-xl font-bold">Helfer</h1>
    <div class="flex items-center justify-between mb-6">
      <filter-search v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <div class="flex justify-between">
          <filter-select :chips="filterLeft" class="w-full mr-4 " />
          <filter-select :chips="filterRight" class="w-full" />
        </div>
      </filter-search>
      <div class="flex items-center">
        <loading-button :loading="processing" class="btn-indigo mr-2" type="button" @click="createPdf">PDF erstellen</loading-button>
        <Link class="btn-indigo" href="/persons/create">
          Hinzufügen
        </Link>
      </div>
    </div>
    <filter-chips :chips="chips" />
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 justify-left sticky-col first-col" style="padding-left: 1.5rem; padding-right: 10rem">Aktion</th>
            <th class="pb-4 pt-6 px-6">Name</th>
            <th class="pb-4 pt-6 px-6">Ressort</th>
            <th class="pb-4 pt-6 px-6">Telefon</th>
            <th class="pb-4 pt-6 px-6">E-Mail</th>
            <th class="pb-4 pt-6 px-6">Jahr</th>
            <th class="pb-4 pt-6 px-6">Angemeldet</th>
            <th class="pb-4 pt-6 px-6">Freitag</th>
            <th class="pb-4 pt-6 px-6">Samstag</th>
            <th class="pb-4 pt-6 px-6">Sonntag</th>
            <th class="pb-4 pt-6 px-6">T-Shirt Größe</th>
            <th class="pb-4 pt-6 px-6">T-Shirt abgeholt</th>
            <th class="pb-4 pt-6 px-6">Essen</th>
            <th class="pb-4 pt-6 px-6">Bemerkung</th>
            <th class="pb-4 pt-6 px-6">Allergien</th>
            <th class="pb-4 pt-6 px-6">Sonstiges</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="person in persons.data" :key="person.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t sticky-col first-col">
              <div class="flex items-center px-6 py-2 justify-left">
                <a class="focus:text-white text-xs btn-gray hover:bg-indigo-500" :class="{'pointer-events-none' : !person.ressortWorkShifts.length, 'bg-gray-600' : !person.ressortWorkShifts.length, 'bg-indigo-600' : person.ressortWorkShifts.length}" :href="`/persons/${person.id}/pdf/workload`" target="_blank">
                  Schichtplan ({{ person.ressortWorkShifts.length }})
                </a>
              </div>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/persons/${person.id}/edit`">
                {{ person.name }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.ressort_category_name }}{{ person.ressort_category_deleted_at ? ' (Gelöscht)' : '' }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.phone }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.email }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.year }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ formatSelectedChoice(person.registered) }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ formatSelectedChoice(person.friday) }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ formatSelectedChoice(person.saturday) }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ formatSelectedChoice(person.sunday) }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.t_shirt_size }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ formatSelectedChoice(person.t_shirt_picked_up) }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ formatFood(person.food) }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.note }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.allergies }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                {{ person.other }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="persons.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="17">Keine Helfer angelegt.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="my-6">Gesamt: {{ persons.total }}</div>
    <pagination class="mt-6" :links="persons.links" />
  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import FilterSearch from '@/Shared/FilterSearch'
import FilterSelect from '@/Shared/FilterSelect'
import FilterChips from '@/Shared/FilterChips'
import merge from 'lodash/merge'
import axios from 'axios'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    FilterSearch,
    FilterSelect,
    FilterChips,
    LoadingButton,
  },
  layout: Layout,
  props: {
    filters: Object,
    filterChips: Object,
    filterValues: Object,
    persons: Object,
    ressortCategorySelect: Object,
  },
  data() {
    return {
      processing: false,
      form: this.$inertia.form({
        name: this.persons.name,
        ressort_category_id: this.persons.ressort_category_id,
        ressortWorkShifts: this.persons.ressortWorkShifts,
        email: this.persons.email,
        phone: this.persons.phone,
        year: this.persons.year,
        registered: this.persons.registered,
        friday: this.persons.friday,
        friday_beer: this.persons.friday_beer,
        saturday: this.persons.saturday,
        saturday_beer: this.persons.saturday_beer,
        sunday: this.persons.sunday,
        sunday_beer: this.persons.sunday_beer,
        t_shirt_size: this.persons.t_shirt_size,
        t_shirt_picked_up: this.persons.t_shirt_picked_up,
        food: this.persons.food,
        allergies: this.persons.allergies,
        other: this.persons.other,
        note: this.persons.note,
      }),
      chips: {
        year: {
          label: 'Jahr',
          selected: this.filterChips.year,
          options: {
            2022: '2022',
            2023: '2023',
            2024: '2024',
            2025: '2025',
            'none': 'Nicht gesetzt',
          },
        },
        friday: {
          label: 'Freitag',
          selected: this.filterChips.friday,
          options: {
            'yes': 'Ja',
            'no': 'Nein',
            'none': 'Nicht gesetzt',
          },
        },
        sunday: {
          label: 'Sonntag',
          selected: this.filterChips.sunday,
          options: {
            'yes': 'Ja',
            'no': 'Nein',
            'none': 'Nicht gesetzt',
          },
        },
        t_shirt_size: {
          label: 'T-Shirt Größe',
          selected: this.filterChips.t_shirt_size,
          options: {
            'XS': 'XS',
            'S': 'S',
            'M': 'M',
            'L': 'L',
            'XL': 'XL',
            '2XL': '2XL',
            '3XL': '3XL',
            '4XL': '4XL',
            '5XL': '5XL',
            'none': 'Nicht gesetzt',
          },
        },
        note:{
          label: 'Bemerkung',
          selected: this.filterChips.note,
          options:{
            'true': 'Vorhanden',
            'false': 'Keine',
          },
        },
        other:{
          label: 'Sonstiges',
          selected: this.filterChips.other,
          options:{
            'true': 'Vorhanden',
            'false': 'Keine',
          },
        },
        registered: {
          label: 'Angemeldet',
          selected: this.filterChips.registered,
          options: {
            'yes': 'Ja',
            'no': 'Nein',
            'none': 'Nicht gesetzt',
          },
        },
        saturday: {
          label: 'Samstag',
          selected: this.filterChips.saturday,
          options: {
            'yes': 'Ja',
            'no': 'Nein',
            'none': 'Nicht gesetzt',
          },
        },
        food: {
          label: 'Essen',
          selected: this.filterChips.food,
          options: {
            'Fleisch': 'Omnivore',
            'Vegetarier': 'Vegetarisch',
            'Veganer': 'Vegan',
            'none': 'Nicht gesetzt',
          },
        },
        t_shirt_picked_up: {
          label: 'T-Shirt abgeholt',
          selected: this.filterChips.t_shirt_picked_up,
          options: {
            'yes': 'Ja',
            'no': 'Nein',
            'none': 'Nicht gesetzt',
          },
        },
        allergies:{
          label: 'Allergien',
          selected: this.filterChips.allergies,
          options:{
            'true': 'Vorhanden',
            'false': 'Keine',
          },
        },
        ressort_category_name:{
          label: 'Ressort',
          selected: this.filterChips.ressort_category_name,
          options: this.ressortCategorySelect,
        },
      },
    }
  },

  computed: {
    filterLeft: function () {
      return { ...Object.values(this.chips).splice(0, 6)}
    },
    filterRight: function () {
      return { ...Object.values(this.chips).splice(6, 10)}
    },
  },

  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/persons', merge(pickBy(this.form), pickBy(mapValues(this.chips, 'selected'))), { preserveState: true })
      }, 150),
    },

    chips: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/persons', merge(pickBy(this.form), pickBy(mapValues(this.chips, 'selected'))) , {preserveState: true})
      }, 150),
    },
  },

  methods: {
    createPdf() {

      let self = this
      self.processing = true

      axios({
        method: 'post',
        url: 'persons/pdf/filters',
        responseType: 'blob',
        data:{
          chips: this.chips,
          year: this.filterChips.year,
          friday: this.filterChips.friday,
          sunday: this.filterChips.sunday,
          t_shirt_size: this.filterChips.t_shirt_size,
          note: this.filterChips.note,
          other: this.filterChips.other,
          registered: this.filterChips.registered,
          saturday: this.filterChips.saturday,
          food: this.filterChips.food,
          t_shirt_picked_up: this.filterChips.t_shirt_picked_up,
          allergies: this.filterChips.allergies,
          ressort_category_name: this.filterChips.ressort_category_name,
        },
      })
        .then(function (response){
          const file = new Blob(
            [response.data],
            {type: 'application/pdf'})
          //Build a URL from the file
          const fileURL = URL.createObjectURL(file)
          //Open the URL on new Window
          window.open(fileURL)
          self.processing = false
        })
        .catch(function (error){
          console.log(error)
        })
    },

    reset() {
      let self = this
      this.form = mapValues(this.form, () => null)
      Object.keys(this.chips).forEach(function(value) {
        self.chips[value]['selected'] = null
      })
    },

    formatSelectedChoice(value) {
      if(value === '1' || value === 1) {
        return 'Ja'
      }
      if(value === '0' || value === 0) {
        return 'Nein'
      }
      return ''
    },

    formatFood(value) {
      if(value === 'Fleisch') {
        return 'Omnivore'
      }
      if(value === 'Vegetarier') {
        return 'Vegetarisch'
      }
      if(value === 'Veganer') {
        return 'Vegan'
      }
      return ''
    },
  },
}
</script>
