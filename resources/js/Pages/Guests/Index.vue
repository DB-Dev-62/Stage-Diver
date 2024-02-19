<template>
  <div>
    <Head title="Gästeliste" />
    <h1 class="mb-8 text-xl font-bold">
      <span class="text-indigo-400 font-medium" /> Gästeliste
    </h1>
    <div class="flex items-center justify-between mb-6">
      <filter-search v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <filter-select :chips="chips" />
      </filter-search>
      <Link class="btn-indigo" href="/guests/create">
        Hinzufügen
      </Link>
    </div>
    <filter-chips :chips="chips" />
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Name</th>
            <th class="pb-4 pt-6 px-6">Tag</th>
            <th class="pb-4 pt-6 px-6">Anzahl Personen</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Bemerkung</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="guest in guests.data" :key="guest.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/guests/${guest.id}/edit`">
                {{ guest.name }}
                <icon v-if="guest.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/guests/${guest.id}/edit`">
                <span v-for="(day, i) in guest.days" :key="day">
                  <span v-if="i !== 0">,</span> {{ day }}
                </span>
                <icon v-if="guest.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/guests/${guest.id}/edit`" tabindex="-1">
                {{ guest.number_of_person }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/guests/${guest.id}/edit`" tabindex="-1">
                {{ guest.note }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/guests/${guest.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="guests.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">Keine Gäste angelegt.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="my-6">Gesamt: {{ guests.total }}</div>
    <pagination class="mt-6" :links="guests.links" />
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
import FilterSelect from '@/Shared/FilterSelect'
import FilterChips from '@/Shared/FilterChips'
import FilterSearch from '@/Shared/FilterSearch'
import merge from 'lodash/merge'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    FilterSearch,
    FilterSelect,
    FilterChips,
  },
  layout: Layout,
  props: {
    filters: Object,
    filterChips: Object,
    guests: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
      },
      chips: {
        day: {
          label: 'Tag',
          selected: this.filterChips.day,
          options: {
            DO: 'Donnerstag',
            FR: 'Freitag',
            SA: 'Samstag',
            SO: 'Sonntag',
            Mo: 'Montag',
          },
        },
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/guests', merge(pickBy(this.form), pickBy(mapValues(this.chips, 'selected'))), { preserveState: true })
      }, 150),
    },
    chips: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/guests', merge(pickBy(this.form), pickBy(mapValues(this.chips, 'selected'))) , {preserveState: true})
      }, 150),
    },
  },
  methods: {
    reset() {
      let self = this
      this.form = mapValues(this.form, () => null)
      Object.keys(this.chips).forEach(function(value) {
        self.chips[value]['selected'] = null
      })
    },
  },
}
</script>
