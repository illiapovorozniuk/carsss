import { createStore } from "vuex";

const store = createStore({
  state: {
    user: {
      data: { name: "Illia" },
      token: 12,
    },
  },
  getters: {},
  mutations: {},
  modules: {},
});

export default store;
