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
    checkedProducts: [],
    productSupplyList: [],
    selectedProductSupply: [],
    brandList: [],
    unitList: [],

    
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
        .put(`/category/${category.records[0].id}`, category)
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
    deleteCategory({ commit }, id) {
        return axiosClient.delete(`/category/${id}`)
          .then(response => {
            commit('filterCategory', id); // Assuming you have a mutation to remove the item from the state
          });
      },
    // Product
    getProductList({commit}) {
      return axiosClient.get('/product').then((res) => {
        commit("setProductList", res.data);
      });
    },
    saveProduct({commit}, product) {
      return axiosClient.post("/product", product).then((res) => {
          commit("setProductList", res.data);
          commit("setCheckProductList", res.data.product_ids);
          return res;
        });
    },
    updateProduct({ commit }, product) {
      return axiosClient
        .put(`/product/${product.records[0].id}`, product)
        .then((res) => {
          commit("setProductList", res.data);
          return res;
        });
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
    deleteProduct({ commit }, id) {
      return axiosClient.delete(`/product/${id}`)
        .then(response => {
          commit('filterSupply', id); // Assuming you have a mutation to remove the item from the state
        });
    },
    //  Supply
    getSupplyList({commit}) {
      return axiosClient.get('/supply').then((res) => {
        commit("setSupplyList", res.data);
      });
    },
    saveSupply({commit}, supply) {
      console.log(supply);
      return axiosClient.post("/supply", supply).then((res) => {
          commit("setSupplyList", res.data);
          return res;
        });
    },
    updateSupply({ commit }, supply) {
      return axiosClient
        .put(`/supply/${supply.records[0].id}`, supply)
        .then((res) => {
          commit("setSupplyList", res.data);
          return res;
        });
    },
    editSupply({ commit }, id) {
      return axiosClient
        .get(`/supply/${id}`)
        .then((res) => {
          commit("setSelectedSupply", res.data);
          return res;
        })
        .catch((err) => {
          throw err;
        });
    },
    // Brand
     getBrandList({commit}) {
      return axiosClient.get('/brand').then((res) => {
        commit("setBrandList", res.data);
      });
    },
    // Unit
    getUnitList({commit}) {
      return axiosClient.get('/unit').then((res) => {
        commit("setUnitList", res.data);
      });
    },
    // Notification
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
    // User Mutation
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
    // Category Mutation
    setCategoryList: (state, categories) => {
      state.categoryList = categories.data;
    },
    setSelectedCategory: (state, category) => {
      state.selectedCategory = category.current;
    },
    filterCategory(state, id) {
      state.categoryList = state.categoryList.filter(item => item.id !== id);
    },
    // Product Mutation
    setProductList: (state, products) => {
      state.productList = products.data;
    },
    setSelectedProduct: (state, product) => {
      state.selectedProduct = product.current[0];
    },
    filterProduct(state, id) {
      state.productList = state.productList.filter(item => item.id !== id);
    },
    setCheckProductList: (state, products) => {
      state.checkedProducts = products;
    },
    // Product Supply
    setSupplyList: (state, supplies) => {
      state.productSupplyList = supplies.data;
    },
    setSelectedSupply: (state, supply) => {
      state.selectedProductSupply = supply.current[0];
    },
    filterSupply(state, id) {
      state.productSupplyList = state.selectedProductSupply.filter(item => item.id !== id);
    },
    // Brand
    setBrandList: (state, brands) => {
      state.brandList = brands.data;
    },
    // Unit
    setUnitList: (state, units) => {
      state.unitList = units.data;
    },
    
    
  },
  getters: {},
  modules: {},

});

export default store;

// [
//     { id: 1, label: 'Tablet'},
//     { id: 2, label: 'Capsule'},
//     { id: 3, label: 'Liquid (mL)'},
//     { id: 4, label: 'Drops'},
//     { id: 5, label: 'Injection (mL)'},
//     { id: 6, label: 'Aerosol'},
//     { id: 7, label: 'Cream'},
//     { id: 8, label: 'Ointment'},
//     { id: 9, label: 'Lotion'},
//     { id: 10, label: 'Suppository'},
//     { id: 11, label: 'Syrup'},
//     { id: 12, label: 'Powder (g or mg)'},
//     { id: 13, label: 'Suspension (mL)'},
//     { id: 14, label: 'Inhaler'},
//     { id: 15, label: 'Dermal Patch'},
//     { id: 16, label: 'Nebulizer Solution'},
//     { id: 17, label: 'Vial'},
//     { id: 18, label: 'Dental Paste'},
//     { id: 19, label: 'Dental Gel'},
//     { id: 20, label: 'Eye Ointment'},
//     { id: 21, label: 'Nasal Spray'},
//     { id: 22, label: 'Dropper Bottle'},
//     { id: 23, label: 'Oral Solution'},
//     { id: 24, label: 'Dial-a-Dose Syringe'}

//   ],