<template>
  <div>
    <Head title="Work Shifts" />
    <h1 class="mb-8 text-xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/ressorts">Ressorts</Link><span class="font-medium ml-2">/</span> {{ ressort.name }}<span class="font-medium ml-2">/</span> Schichtzeiten
    </h1>
    <div class="flex items-center justify-between mb-6">
      <search v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset" />

      <Link class="btn-indigo" :href="`/ressorts/${ressort.id}/work-shifts/create`">
        Hinzufügen
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Tag</th>
            <th class="pb-4 pt-6 px-6 text-right">Zeitspanne</th>
            <th class="pb-4 pt-6 px-6 text-right">Helfer</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="workShift in ressortWorkShifts.data" :key="workShift.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ressorts/${workShift.ressort_id}/work-shifts/${workShift.id}/edit`">
                {{ workShift.day }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 justify-end" :href="`/ressorts/${workShift.ressort_id}/work-shifts/${workShift.id}/edit`" tabindex="-1">
                {{ workShift.time_start }} - {{ workShift.time_end }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 justify-end" :href="`/ressorts/${workShift.ressort_id}/work-shifts/${workShift.id}/edit`" tabindex="-1">
                {{ formatSupporter(workShift.supporter_min, workShift.supporter_max) }}
              </Link>
            </td>
            <td class="w-px border-t" style="width: 100%">
              <Link class="flex items-center px-4 justify-end" :href="`/ressorts/${workShift.ressort_id}/work-shifts/${workShift.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="ressortWorkShifts.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="5">Keine Schichtzeiten hinterlegt.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="my-6">Gesamt: {{ ressortWorkShifts.total }}</div>
    <pagination class="mt-6" :links="ressortWorkShifts.links" />
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
import Search from '@/Shared/Search'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    Search,
  },
  layout: Layout,
  props: {
    filters: Object,
    ressort: Object,
    ressortWorkShifts: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        ressort_name: this.ressortWorkShifts.ressort_name,
        day: this.ressortWorkShifts.day,
        time_start: this.ressortWorkShifts.time_start,
        supporter_min: this.ressortWorkShifts.supporter_min,
        supporter_max: this.ressortWorkShifts.supporter_max,
      }),
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/ressorts/'+this.ressort.id+'/work-shifts', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    formatSupporter(min, max){
      if(min === max || !max){
        return min
      } else {
        return min + ' - ' + max
      }
    },
  },
}
</script>
