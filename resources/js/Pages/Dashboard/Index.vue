<template>
  <Head title="Dashboard" />
  <div v-show="scrollTop" class="fixed cursor-pointer text-indigo-100 right-0 bottom-0 mr-8 mb-8 bg-indigo-500 shadow-sm border border-gray-200 rounded p-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" @click="scrollUp">
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
    </svg>
  </div>
  <div class="block mb-4">
    <div class="flex justify-between">
      <nav class="flex items-center flex-wrap" aria-label="Tabs">
        <a v-for="ressortCategory in ressortCategoryTabs" :key="ressortCategory.id" :class="[ form.tab === ressortCategory.id ? ['bg-indigo-100', 'text-indigo-700'] : ['text-gray-500', 'hover:text-gray-700']]" class="px-3 py-2 font-medium text-lg rounded-md mb-4 mr-4" href="#" @click="changeTab(ressortCategory.id)">
          {{ ressortCategory.name }}
        </a>
      </nav>
    </div>
    <div class="pt-8 font-medium flex space-x-4">
      <div v-if="form.view === 1"><a :href="'/?view=2&tab=' + form.tab + '&day=' +form.day + '&status=' + form.status" class="text-sm">Ansicht: <b class="text-gray-700 hover:text-gray-500">Tag / Ressorts</b></a></div>
      <div v-if="form.view === 2"><a :href="'/?view=1&tab=' + form.tab + '&day=' +form.day + '&status=' + form.status" class="text-sm">Ansicht: <b class="text-gray-700 hover:text-gray-500">Ressort / Tage</b></a></div>
      <div v-if="form.day === 'all'"><a :href="'/?view=' + form.view + '&tab=' + form.tab + '&day=fr' + '&status=' + form.status" class="text-sm">Tage: <b class="text-gray-700 hover:text-gray-500">Alle</b></a></div>
      <div v-if="form.day === 'fr'"><a :href="'/?view=' + form.view + '&tab=' + form.tab + '&day=sa' + '&status=' + form.status" class="text-sm">Tage: <b class="text-gray-700 hover:text-gray-500">FR</b></a></div>
      <div v-if="form.day === 'sa'"><a :href="'/?view=' + form.view + '&tab=' + form.tab + '&day=so' + '&status=' + form.status" class="text-sm">Tage: <b class="text-gray-700 hover:text-gray-500">SA</b></a></div>
      <div v-if="form.day === 'so'"><a :href="'/?view=' + form.view + '&tab=' + form.tab + '&day=all' + '&status=' + form.status" class="text-sm">Tage: <b class="text-gray-700 hover:text-gray-500">SO</b></a></div>
      <div v-if="form.status === 'all'"><a :href="'/?view=' + form.view + '&tab=' + form.tab + '&day=' + form.day + '&status=open'" class="text-sm">Filter: <b class="text-gray-700 hover:text-gray-500">Alle Schichten</b></a></div>
      <div v-if="form.status === 'open'"><a :href="'/?view=' + form.view + '&tab=' + form.tab + '&day=' + form.day +'&status=open-with-optional'" class="text-sm">Filter: <b class="text-gray-700 hover:text-gray-500">Freie Schichten</b></a></div>
      <div v-if="form.status === 'open-with-optional'"><a :href="'/?view=' + form.view + '&tab=' + form.tab + '&day=' + form.day + '&status=all'" class="text-sm">Filter: <b class="text-gray-700 hover:text-gray-500">Freie Schichten (mit Optional)</b></a></div>
    </div>
  </div>
  <div v-for="(ressortCategoryArr, ressortCategoryId) in ressortCategories" v-show="parseInt(form.tab) === parseInt(ressortCategoryId)" :key="ressortCategoryId">
    <div v-if="parseInt(form.tab) === parseInt(ressortCategoryId)">
      <div class="mb-10">
        <div v-for="day in days" class="bg-white shadow pt-4 pb-2 px-4">
          <table>
            <tr>
              <td class="pr-4">
                <div class="text-lg font-medium mb-2">{{ day }}</div>
              </td>
              <td>
                <span v-for="ressort in ressorts">
                  <span v-if="parseInt(ressort.ressort_category_id) === parseInt(ressortCategoryId)" class="inline-flex items-center">
                    <div class="inline-flex items-center border border-gray-200 bg-gray-100 p-2 text-sm font-medium mr-2 mb-2">
                      <a :href="'#' + day + ressort.id" class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                        </svg>
                      </a>
                      <a class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2" :href="`/ressorts/${ressort.id}/pdf/${day.toLowerCase()}`" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                          <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                      </a>
                      {{ ressort.name }}
                    </div>
                  </span>
                </span>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div v-for="(valueArr1, key1) in ressortCategoryArr" :key="key1" class="mb-10">
        <div class="border-b border-gray-200">
          <div v-for="(ressortWorkShifts, key2) in valueArr1" :key="key2">
            <div v-if="view === 1">
              <div class="bg-indigo-100 p-4 border-b border-gray-200 border-b">
                <div class="font-medium">
                  <div class="text-xl inline-block font-bold mr-4">{{ key1 }}</div><div class="inline-block text-lg">{{ key2 }}</div>
                </div>
              </div>
            </div>
            <div v-else>
              <div class="bg-indigo-100 p-4 border-b border-gray-200 border-b">
                <div class="font-medium">
                  <div class="text-xl inline-block font-bold mr-4">{{ key2 }}</div><div class="inline-block text-lg">{{ key1 }}</div>
                </div>
              </div>
            </div>
            <div class="bg-white px-4">
              <div v-for="ressortWorkShift in ressortWorkShifts" :id="ressortWorkShift.day + ressortWorkShift.ressort_id" :key="ressortWorkShift.id" class="border-b py-6">
                <table class="w-full whitespace-nowrap">
                  <tr>
                    <td class="text-right" style="min-width: 85px">
                      <div class="font-medium text-sm text-gray-900"> {{ ressortWorkShift.time_start }} - {{ ressortWorkShift.time_end }} Uhr</div>
                      <div class="text-xs text-gray-500 mt-1">{{ ressortWorkShift.supporter_min }} Helfer</div>
                      <div v-if="ressortWorkShift.supporter_max - ressortWorkShift.supporter_min" class="text-xs text-gray-500 mt-1">{{ ressortWorkShift.supporter_max - ressortWorkShift.supporter_min }} Optional</div>
                    </td>
                    <td class="pl-8" style="width: 100%">
                      <div class="flex flex-wrap">
                        <div v-for="person in ressortWorkShift.persons" :key="person.id" class="mr-4 mb-4 py-2 px-6 border shadow-md relative" :class="parseInt(person.is_optional) === 1 ? 'bg-green-50' : 'bg-gray-50'">
                          <div class="text-sm absolute right-0 top-0 mr-1 mt-1 text-gray-500 hover:text-gray-700 cursor-pointer" @click="deletePerson(ressortWorkShift, ressortCategoryArr, person.id)">x</div>
                          <div class="text-sm text-gray-900">{{ person.name }}</div>
                          <Popper
                            :hover="true"
                            placement="bottom-end"
                          >
                            <a :href="`/persons/${person.id}/pdf/workload`" target="_blank"><div class="mt-1.5 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="person.workload >= 12 ? 'bg-red-100 text-red-800' : 'bg-gray-200 text-gray-800'">{{ person.workload }} Stunden</div></a>
                            <template #content>
                              <div class="bg-white p-4 shadow">
                                <table>
                                  <tr v-for="personRessortWorkShift in person.ressort_work_shifts">
                                    <td class="p-1 font-bold">{{ personRessortWorkShift.day }}</td>
                                    <td class="p-1 font-medium text-right">{{ personRessortWorkShift.time_start }} - {{ personRessortWorkShift.time_end }} Uhr</td>
                                    <td class="p-1 text-xs">{{ personRessortWorkShift.ressort.name }}</td>
                                  </tr>
                                </table>
                              </div>
                            </template>
                          </Popper>
                        </div>
                        <div v-for="n in (ressortWorkShift.supporter_min - ressortWorkShift.persons.filter(person => parseInt(person.is_optional) === 0).length)" :key="n" class="border-2 border-gray-300 border-dashed rounded-lg mr-4 mb-4 p-8" />
                        <div v-for="n in (ressortWorkShift.supporter_max - ressortWorkShift.supporter_min - ressortWorkShift.persons.filter(person => parseInt(person.is_optional) === 1).length)" :key="n" class="border-2 border-green-300 border-dashed rounded-lg mr-4 mb-4 p-8" />
                      </div>
                      <div v-if="ressortWorkShift.supporter_max > ressortWorkShift.persons.length">
                        <autocomplete
                          class="mb-2"
                          :items="appendRessortWorkShiftPersonSelectable(ressortWorkShift, ressortCategoryArr)"
                          @on-selected="personSelectHandler"
                          @on-input="personInputHandler($event, ressortWorkShift)"
                        />
                        <label v-if="ressortWorkShift.supporter_max - ressortWorkShift.supporter_min" class="flex items-center text-sm"><input v-model="ressortWorkShift.personIsOptionalCheckbox" type="checkbox" value="1" class="mr-2" /> Helfer ist optional</label>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-if="!Object.keys(ressortCategories).length" class="mt-10 p-5 bg-white">Keine Schichten</div>
</template>

<script>
import Autocomplete from '@/Shared/Autocomplete'
import Layout from '@/Shared/Layout'
import {Head} from '@inertiajs/inertia-vue3'
import Popper from 'vue3-popper'
import axios from 'axios'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'

export default {
  components: {
    Autocomplete,
    Head,
    Popper,
  },
  layout: Layout,
  props: {
    ressortCategoryTabs: Object,
    ressortCategories: Object,
    ressorts: Object,
    days: Array,
    selectedView: [Number, String],
    selectedStatus: [Number, String],
    selectedDay: [Number, String],
    selectedTab: [Number, String],
  },
  data() {
    return {
      form: {
        tab: this.selectedTab,
        status: this.selectedStatus,
        day: this.selectedDay,
        view: this.selectedView,
      },
      personSelectable: [],
      personIsOptionalCheckbox: false,
      scrollTop: 0,
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.reloadForm()
      }, 10),
    },
  },
  mounted() {
    document.getElementById('scrollContainer').addEventListener('scroll', this.handleScroll)
  },
  unmounted() {
    document.getElementById('scrollContainer').removeEventListener('scroll', this.handleScroll)
  },
  methods: {
    reloadForm() {
      this.$inertia.get('/', pickBy(this.form), {preserveState: true, preserveScroll: true})
    },
    appendRessortWorkShiftPersonSelectable(ressortWorkShift, ressortCategoryArr) {
      return this.personSelectable.map(obj => ({ ...obj, ressortWorkShift: ressortWorkShift, ressortCategoryArr: ressortCategoryArr }))
    },
    changeTab(id) {
      this.form.tab = id
    },
    addPerson(ressortWorkShift, ressortCategoryArr, personId, isOptional) {

      let self = this

      axios.post('/ressorts/'+ressortWorkShift.ressort_id+'/work-shifts/'+ressortWorkShift.id+'/persons/add',  {person: personId, isOptional: isOptional}).then((response) => {
        if(response.data.success){
          self.reloadForm()
        }
      })
    },
    deletePerson(ressortWorkShift, ressortCategoryArr, personId){
      if(confirm('Wirklich entfernen?')){
        let self = this

        axios.post('/ressorts/'+ressortWorkShift.ressort_id+'/work-shifts/'+ressortWorkShift.id+'/persons/delete',  {person: personId}).then((response) => {
          if(response.data.success){
            self.reloadForm()
          }
        })
      }
    },
    personInputHandler(input, ressortWorkShift){

      let self = this

      axios.post('/persons/search',  {searchValue: input, ressortWorkShiftId: ressortWorkShift.id}).then((response) => {
        self.personSelectable = response.data
      })
    },
    personSelectHandler(selectedPerson){

      let isOptional = 0

      if(selectedPerson.ressortWorkShift.personIsOptionalCheckbox){
        isOptional = 1
      }

      this.addPerson(selectedPerson.ressortWorkShift, selectedPerson.ressortCategoryArr, selectedPerson, isOptional)
    },
    handleScroll() {
      let scrollContainer = document.getElementById('scrollContainer')
      if(scrollContainer){
        this.scrollTop = scrollContainer.scrollTop
      } else {
        this.scrollTop = 0
      }
    },
    scrollUp(){
      document.getElementById('scrollContainer').scrollTo(0,0)
    },
  },
}
</script>
