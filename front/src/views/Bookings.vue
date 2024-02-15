<template>
  <PageComponent title = "Bookings">
    <BookingsTable :tableData="bookings"/>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import StatisticsTable from "../components/StatisticsTable.vue";
import BookingsTable from "../components/BookingsTable.vue";
</script>

<script>
import axiosClient from "../axios.js";


export default {
  data() {
    return {

      bookings: [],
    };
  },
  methods: {
    async getBookings(year, month,brand) {
      axiosClient.get('/bookings/get_bookings', ).then((data) => {
        this.bookings = data.data.reverse();
      })
    }
  },
  mounted() {
    this.getBookings(this.year, this.month,this.brand);
  },

};
</script>