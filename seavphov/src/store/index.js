import { createStore } from 'vuex'
import { useToast } from "vue-toastification"
import router from '../router';
import axiosInstance from '../../axiosInstance';

import { setCookie, getCookie ,removeCookie} from './cookieUtils';

const backend_url = import.meta.env.VITE_BACKEND_URL;
const toast = useToast();

const store = createStore({
    state: {
        user: {
            email: null ,
            name: "Not logged in",
            api_token: null,
            picture: "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png",
        },
        filteredFetchBook: [],
        book: {},
        newBookId: null,
    },
    mutations:{
        SET_USER (state, userData){
            state.user = userData;
        }
    },
    getters: {
        booksByCategory: (state) => (category) => {
            return state.fetchBooks.filter(book => book.categories == category);
        },
        isLogin: () => {
            // console.log("isLogin",getCookie() == null ? false : true);
            return getCookie() == null ? false : true;
        },
    },

    actions: {
        setUserFromCookies({ commit }) {
            if(getCookie()){
                const {name,email,api_token,picture} = getCookie();
                commit('SET_USER', { name, email,api_token,picture});
            }
        },
        async logoutUser({commit}){
            localStorage.removeItem("reloaded");
            removeCookie();
            const name = "Not logged in";
            const email = null;
            const api_token = null;
            const picture = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
            commit('SET_USER', { name, email,api_token,picture});
        },
        async registerUser({ dispatch }, signupData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/user/register", signupData, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                const responseData = await response.data;
                if (responseData.success) {
                    const user = {
                        name: responseData.data.name,
                        email: responseData.data.email,
                        api_token: responseData.data.api_token,
                    }
                    setCookie(user);
                    dispatch('setUserFromCookies');
                    toast.success(responseData.message);
                    router.push({ path: '/home' }) 
                }
            } catch (error) {
                console.error("Error register user:", error);
                toast.error(error.response.data.message);
            }
        },
        async loginUser({ dispatch }, loginData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/user/login", loginData, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                const responseData = await response.data;
                if (responseData.success) {
                    console.log("user",responseData.data);
                    const user = {
                        name: responseData.data.name,
                        email: responseData.data.email,
                        api_token: responseData.data.api_token,
                        picture: responseData.data.picture,
                    }
                    setCookie(user);
                    dispatch('setUserFromCookies');
                    toast.success(responseData.message);
                    router.push({ path: '/home' }) 
                }
            } catch (error) {
                console.error("Error login user:", error);
                toast.error(error.response.data.message);
            }
        },
        async fetchUserProfile(){
            try {
                const response = await axiosInstance.get(backend_url + "/api/profile", {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                })
                if (response.data.success) {
                    return response.data.message;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async fetchOtherUserProfile({},username){
            try {
                const response = await axiosInstance.get(backend_url + "/api/user/" + username, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                })

                if (response.data.success) {
                    return response.data.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async modifyUserProfile({dispatch}, formData){
            try {
                const response = await axiosInstance.post(backend_url + "/api/profile", formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });
                if(response.data.success){
                    const responseData   = response.data.data;
                    const user = {
                        name: responseData.name,
                        email: responseData.email,
                        api_token: responseData.api_token,
                        picture: responseData.picture,
                    }
                    setCookie(user);
                    dispatch('setUserFromCookies');
                    toast.success(response.data.message);
                }
            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },
        async fetchBooksWithFilter({},filters) {
            const params = new URLSearchParams();
            if (filters.title) {
                params.append('title', filters.title);
            }
            if (filters.author) {
                params.append('author', filters.author);
            }
            if (filters.categories) {
                params.append('categories', filters.categories);
            }
            if (filters.owner_id) {
                params.append('owner_id', filters.owner_id);
            }
            if (filters.uuid) {
                params.append('uuid', filters.uuid);
            }
            try {
                const response = await axiosInstance.get(backend_url + `/api/books?${params.toString()}`); // Add params to URL
                if (response.data.success) {
                    return response.data.message.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async fetchBookById({},id) {
            try {
                const response = await axiosInstance.get(backend_url + "/api/books/" + id)
                if (response.data.success) {
                    return [response.data.book, response.data.author];
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async fetchMyBooks() {
            try {
                const response = await axiosInstance.get(backend_url + "/api/auth/books", {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                })
                if (response.data.success) {
                    return response.data.message;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async fetchSavedBook() {
            try {
                const response = await axiosInstance.get(backend_url + "/api/saved", {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                })
                if (response.data.success) {
                    return response.data.message;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async createBook({},formData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/books/", formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });
                console.log("response", response)
                toast.success(response.data.message);
                this.state.newBookId = response.data.bookId;
            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },
        async modifyBook({},formData) {
            try {
                let id = formData.get("id");
                const response = await axiosInstance.post(backend_url + "/api/books/"+ id, formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });
                console.log("response", response)
                toast.success(response.data.message);
            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },
        async saveBook({},bookId){
            try {
                const response = await axiosInstance.get(backend_url + "/api/saved/"+ bookId, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                   console.log("response.data",response.data)
                   
                   toast.success(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async unSaveBook({},bookId){
            try {
                const response = await axiosInstance.delete(backend_url + "/api/saved/"+ bookId, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                   console.log("response.unSaveBook",response.data)
                   
                   toast.success(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },

    },
})

export default store