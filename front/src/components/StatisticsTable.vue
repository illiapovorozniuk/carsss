<template>
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-white border-b">
            <tr>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Car id</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Registration number</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Brand</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Car slug</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Color</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Free days</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Service days</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Busy days</th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">All days</th>
            </tr>
            </thead>
            <tbody>
            <tr :class="[index%2===0?'bg-gray-100 border-b':'']" v-for="(car_row,index) in tableData">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ car_row.car_id }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.registration_number }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.brand_slug }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.car_slug }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.color }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.schedule.free }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.schedule.service }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.schedule.busy }}</td>
              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ car_row.schedule.days }}</td>

            </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["tableData"],
}
// console.log(this.tableData);
</script>

<style scoped lang="scss">

</style>