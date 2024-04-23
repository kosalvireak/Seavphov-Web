import { createStore } from 'vuex'
import { useToast } from "vue-toastification"
import axios from "axios"
import router from '../router';

import { setUserCookie, getUserCookie ,removeUserCookie} from './cookieUtils';

const backend_url = import.meta.env.VITE_BACKEND_URL;
const toast = useToast();

const store = createStore({
    state: {
        loginUser: {
            email:  getUserCookie() ? getUserCookie().email : "",
            name:   getUserCookie() ? getUserCookie().name:"Not logged in",
            api_token:   getUserCookie() ? getUserCookie().api_token : null,
            picture: getUserCookie() ? getUserCookie().picture :"https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png",
        },
        filteredFetchBook: [],
        book: {},
        newBookId: null,
    },
    getters: {
        booksByCategory: (state) => (category) => {
            return state.fetchBooks.filter(book => book.categories == category);
        },
        isLogin: () => {
            // console.log("isLogin",getUserCookie() == null ? false : true);
            return getUserCookie() == null ? false : true;
        },
    },

    actions: {
        async fetchBooksWithFilter({ commit }, filters) {
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
            try {
                const response = await axios.get(backend_url + `/api/books?${params.toString()}`); // Add params to URL
                if (response.data.success) {
                    // this.state.filteredFetchBook = response.data.message.data;
                    return response.data.message.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async fetchBookById({ commit }, id) {
            try {
                const response = await axios.get(backend_url + "/api/books/" + id)
                if (response.data.success) {
                    this.state.book = response.data.message;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async fetchBookByWithAuth({ commit }) {
            try {
                const response = await axios.get(backend_url + "/api/auth/books", {
                    headers: {
                        'Authorization': `Bearer ${this.state.loginUser.api_token}`,
                    },
                })
                if (response.data.success) {
                    return response.data.message;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async createBook({ commit }, formData) {
            try {
                const response = await axios.post(backend_url + "/api/books/", formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.loginUser.api_token}`,
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
        async registerUser({ commit }, signupData) {
            try {
                const response = await axios.post(backend_url + "/api/user/register", signupData, {
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
                    setUserCookie(user);
                    toast.success(responseData.message);
                    router.push('/home');
                }
            } catch (error) {
                console.error("Error register user:", error);
                toast.error(error.response.data.message);
            }
        },
        async logoutUser({commit}){
            removeUserCookie();
        },
        async loginUser({ commit }, loginData) {
            try {
                const response = await axios.post(backend_url + "/api/user/login", loginData, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                const responseData = await response.data;
                if (responseData.success) {
                    console.log("loginUser",responseData.data);
                    const user = {
                        name: responseData.data.name,
                        email: responseData.data.email,
                        api_token: responseData.data.api_token,
                        picture: responseData.data.picture,
                    }
                    setUserCookie(user);
                    toast.success(responseData.message);
                    router.push('/home');
                }
            } catch (error) {
                console.error("Error login user:", error);
                toast.error(error.response.data.message);
            }
        },
        async fetchUserProfile({commit}){
            try {
                const response = await axios.get(backend_url + "/api/profile", {
                    headers: {
                        'Authorization': `Bearer ${this.state.loginUser.api_token}`,
                    },
                })
                if (response.data.success) {
                    return response.data.message;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async modifyUserProfile({commit}, formData){
            try {
                const response = await axios.post(backend_url + "/api/profile", formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.loginUser.api_token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });
                if(response.data.success){
                    console.log("modifyUserProfile",response.data.data)
                    const responseData   = response.data.data;
                    const user = {
                        name: responseData.name,
                        email: responseData.email,
                        api_token: responseData.api_token,
                        picture: responseData.picture,
                    }
                    setUserCookie(user);
                    toast.success(response.data.message);
                }
            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },
    },
})

export default store