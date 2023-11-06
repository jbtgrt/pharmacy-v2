import { createStore } from "vuex";
import axiosClient from "../axios.js";

const store = createStore({
  state: {
    refresh: true,
    notification: {
      show: false,
      type: 'success',
      message: ''
    },
    user: {
      data: [],
      role: sessionStorage.getItem("ROLE"),
      token: sessionStorage.getItem("TOKEN"),
    },
    userList: [],
    selectedUser: [],
    categoryList: [],
    selectedCategory: [],
    productList: [],
    selectedProduct: [],
    
  },
  actions: {
    register({commit}, user) {
      return axiosClient.post('/register', user)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token);
          return data;
        })
    },
    login({commit}, user) {
      return axiosClient.post('/login', user)
        .then(({data}) => {
          commit('setUser', data.user[0]);
          commit('setToken', data.token);
          return data;
        })
    },
    logout({commit}) {
      return axiosClient.post('/logout')
        .then(response => {
          commit('logout');
          return response;
        })
    },
    getUser({commit}) {
      return axiosClient.get('/auth-user')
      .then(res => {
        commit('setUser', res.data);
      });
    },
    getUserList({commit}) {
      return axiosClient.get('/user').then((res) => {
        commit("setUserList", res.data);
      });
    },
    saveUser({commit}, user) {
      let response;
      if(user.id){
        response = axiosClient
          .put(`/user/${user.id}`, user)
          .then((res) => {
            commit("setUserList", res.data);
              return res;
          });
      } else {
        response = axiosClient.post("/user", user).then((res) => {
          commit("setUserList", res.data);
          return res;
        });
      }
      return response;
    },
    editUser({ commit }, id) {
      return axiosClient
        .get(`/user/${id}`)
        .then((res) => {
          commit("setSelectedUser", res.data);
          return res;
        })
        .catch((err) => {
          throw err;
        });
    },
    lockUser({}, user) {
      return axiosClient
        .put(`/lock/${user.id}`, user)
        .catch((err) => {
          throw err;
        });
    },
    saveProfile({}, profile) {
      return axiosClient
          .put(`/profile/${profile.id}`, profile)
          .then((res) => {
            return res;
        })
    },
    changePassword({}, info) {
       return axiosClient
          .put(`/change-password/${info.id}`, info)
          .then((res) => {
            return res;
        })
    },
    // Category
    getCategoryList({commit}) {
      return axiosClient.get('/category').then((res) => {
        commit("setCategoryList", res.data);
      });
    },
    saveCategory({commit}, category) {
      return axiosClient.post("/category", category).then((res) => {
        commit("setCategoryList", res.data);
        return res;
      });
    },
    updateCategory({ commit }, category) {
      return axiosClient
        .put(`/category/${category.services[0].id}`, category)
        .then((res) => {
          commit("setCategoryList", res.data);
          return res;
        });
    },
    editCategory({ commit }, id) {
      return axiosClient
        .get(`/category/${id}`)
        .then((res) => {
          commit("setSelectedCategory", res.data);
          return res;
        })
        .catch((err) => {
          throw err;
        });
    },
    // Product
    getProductList({commit}) {
      return axiosClient.get('/product').then((res) => {
        commit("setProductList", res.data);
      });
    },
    saveProduct({commit}, product) {
      let response;
      if(product.id){
        response = axiosClient
          .put(`/product/${product.id}`, product)
          .then((res) => {
            commit("setProductList", res.data);
              return res;
          });
      } else {
        response = axiosClient.post("/product", product).then((res) => {
          commit("setUserList", res.data);
          return res;
        });
      }
      return response;
    },
    editProduct({ commit }, id) {
      return axiosClient
        .get(`/product/${id}`)
        .then((res) => {
          commit("setSelectedProduct", res.data);
          return res;
        })
        .catch((err) => {
          throw err;
        });
    },
    sendNotification({}) {
       return axiosClient
          .post(`/send-sms`)
          .then((res) => {
            return res;
        })
    },
    
  },
  mutations: {
    stopRefresh: (state) => {
      state.refresh = false;
    },
    notify: (state, {message, type}) => {
      state.notification.show = true;
      state.notification.type = type;
      state.notification.message = message;
      setTimeout(() => {
        state.notification.show = false;
      }, 3000)
    },
    logout: (state) => {
      state.user.token = null;
      state.user.data = {};
      sessionStorage.removeItem("TOKEN");
    },
    setRole: (state, role) => {
      state.user.role = role;
    },
    setUser: (state, user) => {
      state.user.data = user;
      sessionStorage.setItem('ROLE', user.role.toLowerCase());
      state.user.data.full_name = `${user.first_name} ${user.last_name}`;
    },
    setToken: (state, token) => {
      state.user.token = token;
      sessionStorage.setItem('TOKEN', token);
    },
    setUserList: (state, users) => {
      state.userList = users.data;
    },
    setSelectedUser: (state, user) => {
      state.selectedUser = user.current_user[0];
    },
    setCategoryList: (state, categories) => {
      state.categoryList = categories;
    },
    setSelectedCategory: (state, category) => {
      state.selectedCategory = category.current;
    },
    setProductList: (state, categories) => {
      state.productList = categories;
    },
    setSelectedProduct: (state, category) => {
      state.selectedCategory = category;
    },
    
    
  },
  getters: {},
  modules: {},

});

export default store;
