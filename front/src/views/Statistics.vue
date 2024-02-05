<template>
  <PageComponent title="Statistics">

    <!--    Years-->
    <Menu as="div" class="relative inline-block text-left mr-2">
      <div>
        <div>Year</div>
        <MenuButton
            class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
          {{ year }}
          <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true"/>
        </MenuButton>
      </div>
      <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 ">
        <MenuItems
            class="absolute right-0 z-10 mt-21 origin-top-right items-center rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
          <div class="py-1">
            <MenuItem @click="year=Year" v-for="Year in years" :key="Year.id" v-slot="{ active }">
              <a :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-5 py-1 text-sm']">{{
                  Year
                }}</a>
            </MenuItem>
          </div>
        </MenuItems>
      </transition>
    </Menu>
    <!--    Months-->
    <Menu as="div" class="relative inline-block text-left mr-2">
      <div>
        <div>Month</div>
        <MenuButton
            class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
          {{ month }}
          <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true"/>
        </MenuButton>
      </div>
      <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 ">
        <MenuItems
            class="absolute right-0 z-10 mt-21 origin-top-right items-center rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
          <div class="py-1">
            <MenuItem @click="month=Month" v-for="Month in months" :key="Month.id" v-slot="{ active }">
              <a :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-5 py-1 text-sm']">{{
                  Month
                }}</a>
            </MenuItem>
          </div>
        </MenuItems>
      </transition>
    </Menu>
    <Menu as="div" class="relative inline-block text-left mr-2">
      <div>
        <div>BRAND</div>
        <MenuButton
            class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
          {{ brand?brand:'None' }}
          <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true"/>
        </MenuButton>
      </div>
      <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 ">
        <MenuItems
            class="absolute right-0 z-10 mt-21 origin-top-right items-center rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
          <div class="py-1">
            <MenuItem @click="brand=''"  v-slot="{ active }" class="bg-gray-100">
              <a :class="[active ? 'bg-gray-200 text-gray-900' : 'text-gray-700', 'block px-5 py-1 text-sm']">None</a>
            </MenuItem>
            <MenuItem @click="brand=Brand" v-for="Brand in brands" :key="Brand" v-slot="{ active }">
              <a :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-5 py-1 text-sm']">{{
                  Brand
                }}</a>
            </MenuItem>
          </div>
        </MenuItems>
      </transition>
    </Menu>
    <StatisticsTable :tableData="statistics"/>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {ChevronDownIcon} from '@heroicons/vue/20/solid'
import StatisticsTable from "../components/StatisticsTable.vue";
</script>
<script>
import axiosClient from "../axios.js";

let months = [];
for (let i = 1; i <= 12; i++) months.push(i)

let years = [];
let title = `Carsss`;

export default {
  data() {
    return {
      years: [],
      brands:[],
      year: 2023,
      month: 1,
      brand: '',
      statistics: [],
    };
  },
  methods: {
    async getYears() {
      axiosClient.get('getyears').then((data) => {
        years = data.data;
      })
    },
    async getStatistics(year, month,brand) {
      axiosClient.post('statisticsforthemonth', {year: year, month: month, brand: brand}).then((data) => {
        this.statistics = data.data
      })
    },async getBrands() {
      axiosClient.get('getbrands').then((data) => {
        this.brands = data.data;
      })
    },
  },
  watch: {
    year(newYear) {
      this.getStatistics(newYear, this.month, this.brand);
      console.log(this.brand)
    },
    month(newMonth) {
      this.getStatistics(this.year, newMonth, this.brand);
      console.log(this.brand)
    },
    brand(newBrand){
      this.getStatistics(this.year, this.month, newBrand);
    }
  },
  mounted() {
    this.getYears();
    this.getBrands();
    this.getStatistics(this.year, this.month,this.brand);
  },

};
</script>

<style lang="scss" scoped>

</style>