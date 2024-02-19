<template>
  <div>
    <template
      v-for="chip in chips"
    >
      <div v-if="chip.selected" :key="chip.label" class="inline-flex items-center rounded-lg bg-white border border-gray-200 p-2 mb-4 mr-2">
        <span class="px-1 text-sm">{{ chip.label }}: <b>{{ chip.options[chip.selected] }}</b></span>
        <button
          type="button"
          class="h-5 w-5 p-1 ml-1 rounded-full bg-red-400 bg-opacity-25 focus:outline-none"
          @click="chip.selected = null"
        >
          <svg
            class="text-red-500 text-opacity-75"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
    </template>
  </div>
</template>



<script>
export default {
  props: {
    chips: Object,
  },
}
</script>
