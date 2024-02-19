<template>
  <div>
    <Head title="Ressorts" />
    <h1 class="mb-8 text-xl font-bold">Ressorts</h1>
    <div class="flex items-center justify-between mb-6">
      <search v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset" />
      <Link class="btn-indigo" href="/ressorts/create">
        Hinzufügen
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Aktion</th>
            <th class="pb-4 pt-6 px-6">Kategorie</th>
            <th class="pb-4 pt-6 px-6">Name</th>
            <th class="pb-4 pt-6 px-6">Info</th>
            <th class="pb-4 pt-6 px-6" />
          </tr>
        </thead>
        <tbody>
          <tr v-for="ressort in ressorts.data" :key="ressort.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <div class="flex items-center px-6 py-2 justify-left">
                <Link class="focus:text-white text-xs btn-gray hover:bg-indigo-500" :class="ressort.ressort_work_shifts_count ? 'bg-indigo-600' : 'bg-gray-600'" :href="`/ressorts/${ressort.id}/work-shifts`">
                  Schichtzeiten ({{ ressort.ressort_work_shifts_count }})
                </Link>
              </div>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ressorts/${ressort.id}/edit`">
                {{ ressort.ressort_category_name }}{{ ressort.ressort_category_deleted_at ? ' (Gelöscht)' : '' }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/ressorts/${ressort.id}/edit`" tabindex="-1">
                {{ ressort.name }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ressorts/${ressort.id}/edit`" tabindex="-1">
                {{ ressort.info }}
              </Link>
            </td>
          </tr>
          <tr v-if="ressorts.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">Keine Ressorts angelegt.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="my-6">Gesamt: {{ ressorts.total }}</div>
    <pagination class="mt-6" :links="ressorts.links" />
  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import Search from '@/Shared/Search'

export default {
  components: {
    Head,
    Link,
    Pagination,
    Search,
  },
  layout: Layout,
  props: {
    filters: Object,
    ressorts: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.ressorts.name,
        ressort_category_id: this.ressorts.ressort_category_id,
        info: this.ressorts.info,
      }),
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/ressorts', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
