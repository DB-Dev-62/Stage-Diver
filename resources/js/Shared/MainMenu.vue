<template>
  <div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/guests">
        <icon name="guests" class="mr-2 w-4 h-4" :class="isUrl('guests') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('guests') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Gästeliste</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/persons">
        <icon name="person" class="mr-2 w-4 h-4" :class="isUrl('persons') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('persons') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Helfer</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/ressorts">
        <icon name="ressorts" class="mr-2 w-4 h-4" :class="isUrl('ressorts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('ressorts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Ressorts</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/ressort-categories">
        <icon name="categories" class="mr-2 w-4 h-4" :class="isUrl('ressort-categories') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('ressort-categories') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Kategorien</div>
      </Link>
    </div>
  </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
