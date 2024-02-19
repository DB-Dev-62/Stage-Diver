<template>
  <div class="max-w-xs relative space-y-3">
    <label
      v-if="label"
      for="search"
      class="text-gray-900 block"
    >
      {{ label }}
    </label>

    <input
      id="search"
      v-model="searchTerm"
      type="text"
      placeholder="Suchen..."
      class="p-2 mb-0.5 w-full border border-gray-300 rounded"
    />

    <ul
      v-if="searchItems.length"
      class="w-full rounded bg-white border border-gray-300 px-4 py-2 space-y-1 absolute z-10"
    >
      <li
        v-for="item in searchItems"
        :key="item.name"
        class="cursor-pointer hover:bg-gray-100 p-1"
        @click="selectItem(item)"
      >
        {{ item.name }}
      </li>
    </ul>
  </div>
</template>

<script>
import {computed, ref, watch} from 'vue'

export default {
  props: {
    label: String,
    items: Array,
  },
  emits: ['on-selected', 'on-input'],
  setup(props, { emit }) {

    let searchTerm = ref('')

    const searchItems = computed(() => {
      if (searchTerm.value === '') {
        return []
      }
      let matches = 0
      return props.items.filter(item => {
        if (item.name.toLowerCase().includes(searchTerm.value.toLowerCase()) && matches < 10) {
          matches++
          return item
        }
      })
    })

    watch(searchTerm, (val) => {
      emit('on-input', val)
    })

    const selectItem = (item) => {
      selectedItem.value = item
      searchTerm.value = ''
      emit('on-selected', item)
    }

    let selectedItem = ref('')

    return {
      searchTerm,
      searchItems,
      selectItem,
      selectedItem,
    }
  },
}
</script>
