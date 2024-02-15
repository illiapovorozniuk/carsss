<template xmlns="http://www.w3.org/1999/html">
  <div v-if="totalPages>=1" class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-white border-b">
            <tr>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Car</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Registration number</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Year</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Pickup Date</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Return Date</th>

            </tr>
            </thead>
            <tbody>
            <tr :class="[!(new Date(car_row.start_date)>new Date() && new Date(car_row.end_date)>new Date())
            ? new Date(car_row.start_date)<new Date() && new Date(car_row.end_date)>new Date()?
            'bg-amber-200 border-b':
            'bg-green-200 border-b' : `bg-blue-300 border-b`]"
                v-for="(car_row,index) in paginatedTableData">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ car_row.name }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{
                  car_row.registration_number
                }}
              </td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.year }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.start_date }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.end_date }}</td>
            </tr>

            </tbody>
          </table>
        </div>
      </div>
      <div class="flex items-center justify-center mt-4">
        <div class="inline-block">
          <Pagination v-if="totalPages>=2"
                      :totalPages="totalPages"
                      :currentPage="currentPage"
                      @pageChanged="changePage"></Pagination>
        </div>
      </div>
    </div>
  </div>


</template>
<script>

import Pagination from "./Pagination.vue";
import DialogWindow from "./DialogWindow.vue";
import axiosClient from "../axios.js";

export default {
  components: {DialogWindow, Pagination},
  props: ["tableData", "start_datetime", "end_datetime"],
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 12, // COUNT OF ROWS PER PAGE
    };
  },
  computed: {
    paginatedTableData() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.tableData.slice(startIndex, endIndex);
    },
    totalPages() {
      return Math.ceil(this.tableData.length / this.itemsPerPage);
    },
  },
  watch: {
    tableData() {
      this.currentPage = 1;
    }
  },
  methods: {
    changePage(newPage) {
      this.currentPage = newPage;
    },
  },
};
</script>
<style scoped lang="scss">

</style>