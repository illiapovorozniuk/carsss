<script setup>
const props = defineProps({
  errorMsg: String,
});
</script>

<template>
  <div v-if="errorMsg!==''" class="flex items-center justify-between py-3  px-5 bg-red-500 text-white rounded mx-auto ">
    {{ errorMsg }}
    <span @click="errorMsg=''"
          class="w-8 h-8 flex items-center justify-center rounded-full transition-colors hover:bg-[rgba(0,0,0,0.2)]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
</svg>
</span>
  </div>

</template>

<style scoped lang="scss">

</style>