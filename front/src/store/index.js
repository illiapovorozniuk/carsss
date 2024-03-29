import {createStore} from "vuex";
import axiosClient from "../axios.js";

const store = createStore({
    state: {
        user: {
            data: JSON.parse(sessionStorage.getItem('USER')),
            token: sessionStorage.getItem('TOKEN'),
        },
        statistics: null
    },
    getters: {},
    actions: {
        logout({commit}){
            return axiosClient.post('/logout')
                .then((response)=>{
                    commit('logout');
                    return response;
                })
        },
        register({commit}, user) {
            return axiosClient.post('/register',user).then(({data})=>{
                commit('setUser',data)
                return data;
            })
        },
        login({commit}, user) {
            return axiosClient.post('/login',user).then(({data})=>{
                commit('setUser',data)
                return data;
            })
        },
        statistics({commit}, filterParams) {
            return axiosClient.post('/statisticsforthemonth',filterParams).then(({data})=>{
                commit('setStatistics',data)
                return data;
            })
        }
    },
    mutations: {
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem('USER');
            sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, userData)=>{
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem('USER',  JSON.stringify({name: userData.user}));
            sessionStorage.setItem('TOKEN', userData.token);
        },
        setStatistics: (state, statisticsData)=>{
            state.statistics = statisticsData;

        }

    },
    modules: {},
});

export default store;
