<template>
  <div>
    <template
      v-for="chip in chips" :key="chip.label"
    >
      <div>
        <template v-if="!chip.multiple">
          <label class="block text-gray-800">{{ chip.label }}:</label>
          <select v-model="chip.selected" class="mt-1 w-full form-select mb-4" :class="chip.selected === null ? 'text-gray-400' : 'font-bold'">
            <option :value="null">Alle</option>
            <template
              v-for="(value, label) in chip.options" :key="label"
            >
              <option :value="label">{{ value }}</option>
            </template>
          </select>
        </template>
        <template v-if="chip.multiple">
          <label class="block text-gray-800 mb-1">{{ chip.label }}:</label>
          <multiselect
            v-model="chip.selected"
            :options="chip.options"
            :multiple="true"
            :close-on-select="false"
            :show-no-results="false"
            :show-labels="false"
            :searchable="false"
            placeholder="Alle"
            class="mb-4"
          />
        </template>
      </div>
    </template>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
  components: {
    Multiselect,
  },
  props: {
    chips: Object,
    multiple: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
.multiselect__tag, .multiselect__tag-icon:focus, .multiselect__tag-icon:hover {
    background: #0365b0;
}

.multiselect__option--highlight {
    background: #e3e8ef;
    color: #35495e;
}

.multiselect__tag-icon:after {
    color: #fff;
}

.multiselect__option--selected.multiselect__option--highlight {
    background: #f9dddc;
    color: #35495e;
}

.multiselect__placeholder{
    margin: 0;
    font-size: 16px;
}

.multiselect__tag {
    padding: 8px 26px 8px 10px;
}

.multiselect__tag-icon {
    margin-top: 4px;
}
</style>
