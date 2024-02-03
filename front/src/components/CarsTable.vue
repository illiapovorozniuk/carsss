<template xmlns="http://www.w3.org/1999/html">
  <div v-if="totalPages>=1" class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-white border-b">
            <tr>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Name</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Year of the vehicle</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Transmission type</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Color</th>
              <th scope="col"
                  class="text-sm font-medium text-gray-900 px-6 py-4 text-left bg-green-50 border-l-2 border-l-green-100">
                Price
              </th>

            </tr>
            </thead>
            <tbody>
            <tr @click="ConfirmationDialog(car_row.name,car_row.car_id, car_row.year)" :class="[index%2===0?'bg-gray-100 border-b cursor-pointer':'cursor-pointer']"
                v-for="(car_row,index) in paginatedTableData">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ car_row.name }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.year }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.transmission }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.color }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap bg-green-100 border-l-2 border-l-green-200">
                {{ Math.floor(Math.random() * (1000 - 100) + 100) }} $
              </td>
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
  <DialogWindow :open="dialogOpen" @close-dialog="closeDialog" title="Booking confirmation" @create-booking="createBooking">
    Booking Details:
    <ul class="list-disc">
      <li>Car: {{car.name}} {{car.year}}</li>
      <li>Pickup Date and Time: {{ start_datetime?start_datetime.replace("T", ' '):''}}</li>
      <li>Return Date and Time: {{end_datetime?end_datetime.replace("T", ' '):''}}</li>
    </ul>
  </DialogWindow>

</template>
<script>

import Pagination from "./Pagination.vue";
import DialogWindow from "./DialogWindow.vue";
import axiosClient from "../axios.js";

export default {
  components: {DialogWindow, Pagination},
  props: ["tableData", "start_datetime","end_datetime"],
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 12, // COUNT OF ROWS PER PAGE
      car: {
        id: '',
        name: '',
        year: ''
      },
      dialogOpen: false,
    };
  },
  emits: ['refresh-table'],
  computed: {
    paginatedTableData(
    ) {
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
    ConfirmationDialog(name,car_id,year) {
      this.dialogOpen = true;
      this.car.id = car_id;
      this.car.name = name;
      this.car.year = year;

    },
   async createBooking(){
      axiosClient.post('/rent/createnewbooking',
          {car_id: this.car.id, start_date_time: this.start_datetime, end_date_time: this.end_datetime})
          .then(
          (data) => {
            this.cars = data.data;
            this.closeDialog();
            this.refreshTable();
          }
      )
    },
    changePage(newPage) {
      this.currentPage = newPage;
    },
    closeDialog() {
      this.dialogOpen = false;
    },
    refreshTable(){
      this.$emit('refresh-table');
    },
  },
};
</script>
<style scoped lang="scss">

</style>