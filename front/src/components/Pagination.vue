<script setup>
import { FwbPagination } from 'flowbite-vue'
import { ref } from 'vue'

const props = defineProps({
  total_pages: Number,
  slice_length: Number

});
const currentPage = ref(1)
</script>
<template>
  <fwb-pagination class="bg-gray-100 max-w-50" v-model="currentPage" :total-pages=3 :slice-length="4"></fwb-pagination>
</template>