<template>
  <div class="flex fullheight">
    <div
        :class="isOpen ? 'w-40' : 'w-60'"
        class="flex flex-col min-h-100  p-3 duration-300 bg-gray-800 shadow"
    >

      <div class="space-y-3">
        <div class="flex items-center justify-between">
          <h2 class="text-xl font-bold text-white">Carsss</h2>

          <button @click="isOpen = !isOpen">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6 text-white"
            >
              <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
              />
            </svg>
          </button>
        </div>
        <div class="flex flex-col">

          <div class="hidden md:block">
            <div class="flex flex-col">
              <router-link v-for="item in navigation" :key="item.name" :to="item.to"
                           active-class=""
                           :class="[$route.name=== item.name? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
              >{{ item.name }}
              </router-link>
            </div>
          </div>
        </div>
        <div class="flex-1">
          <ul class="pt-2 pb-4 space-y-1 text-sm">


            <li class="rounded-sm">
              <a
                  @click="logout"
                  class="flex items-center p-2 space-x-3 rounded-md cursor-pointer"
              >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-gray-100"
                >
                  <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"
                  />
                </svg>

                <span class="text-gray-100"> Sign out </span>
              </a>
            </li>
          </ul>
        </div>
      </div>

    </div>
    <div class="container mx-auto">
      <router-view></router-view>
    </div>
  </div>
</template>

<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {Bars3Icon, XMarkIcon} from '@heroicons/vue/24/outline'
import {useStore} from "vuex";
import {computed} from "vue";
import {useRouter} from "vue-router";
import {ref} from "vue";

const isOpen = ref(false);
const store = useStore();
const router = useRouter();

function logout() {
  store.dispatch('logout')
      .then(() => {
        router.push({name: 'Login'})
      });
}

const user = computed(() => store.state.user.data)
const navigation = [
  {name: 'Statistics', to: {name: 'Statistics'}, current: false},
]

</script>


<style lang="scss" scoped>

</style>