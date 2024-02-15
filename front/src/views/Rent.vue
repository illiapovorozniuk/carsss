<template>
  <PageComponent title="Rent a car">
    <form @submit.prevent="getCars">

      <div class="space-y-2">

        <ErrorMSG :error-msg="errorMsg" @close-error="CloseError"></ErrorMSG>
        <div class="border-b border-gray-900/10 pb-12 flex justify-center">

          <div class="flex content-center mr-6">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 mr-4">

              <div class="w-64">
                <label for="datetime" class="block text-sm font-medium text-gray-700">Pickup Date and Time</label>
                <input
                    v-model="startDatetime"
                    type="datetime-local"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="Select Date and Time"
                />
              </div>

            </div>
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8">
              <div class="w-64">
                <label for="datetime" class="block text-sm font-medium text-gray-700">Return Date and Time</label>
                <input
                    v-model="endDatetime"
                    type="datetime-local"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="Select Date and Time"
                />
              </div>
            </div>

          </div>
          <button type="submit"
                  class="rounded-md bg-indigo-600 px-3 py-3 mt-auto text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            SEARCH
          </button>
        </div>


      </div>
      <CarsTable :tableData="cars"
                 :start_datetime="startDatetime" :end_datetime="endDatetime" @refresh-table="getCars"></CarsTable>


    </form>
  </PageComponent>
</template>

<script setup>

import PageComponent from "../components/PageComponent.vue";

import ErrorMSG from "../components/ErrorMSG.vue";
import CarsTable from "../components/CarsTable.vue";
</script>
<script>
import {ref} from "vue";
import axiosClient from "../axios.js";

const now = new Date();
now.setDate(now.getDate() + 1);
let startDatetime = now.toISOString().slice(0, 16);
now.setDate(now.getDate() + 4);
let endDatetime = now.toISOString().slice(0, 16);

const errorMsg = ref('');


export default {
  data() {
    return {
      month: 1,
      statistics: [],
      cars: [],
      startDatetime: startDatetime,
      endDatetime: endDatetime
    };
  },
  methods: {

    async getCars() {
      axiosClient.post('/rent/searchfreecars', {start_date_time: startDatetime, end_date_time: endDatetime}).then(
          (data) => {
            this.cars = data.data;
          }
      ).catch(err => {
            errorMsg.value = err.response.data.error
          }
      )
    },
    CloseError(){
      errorMsg.value = '';
    }
  },
  watch: {
    year(newYear) {
      this.getStatistics(newYear, this.month);
    },
    month(newMonth) {
      this.getStatistics(this.year, newMonth);
    },

  },
  CloseError(){
    errorMsg.value = '';
  }
};
</script>
<style scoped lang="scss">

</style>