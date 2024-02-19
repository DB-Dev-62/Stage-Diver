<template>
  <div>
    <Head title="Kategorien" />
    <h1 class="mb-8 text-xl font-bold">
      <span class="text-indigo-400 font-medium" /> Kategorien
    </h1>
    <div class="flex items-center justify-between mb-6">
      <search v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset" />
      <Link class="btn-indigo" href="/ressort-categories/create">
        Hinzufügen
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Name</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in ressortCategories.data" :key="category.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/ressort-categories/${category.id}/edit`">
                {{ category.name }}
                <icon v-if="category.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/ressort-categories/${category.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="ressortCategories.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">Keine Kategorien angelegt.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="my-6">Gesamt: {{ ressortCategories.total }}</div>
    <pagination class="mt-6" :links="ressortCategories.links" />
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
    ressortCategories: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.ressortCategories.name,
        ressort_id: this.ressortCategories.ressort_id,
      }),
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/ressort-categories', pickBy(this.form), { preserveState: true })
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
