import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import { useToast } from "vue-toastification"
import axios from "axios"
import VueCookies from 'vue-cookies';
import router from '../router';


const backend_url = import.meta.env.VITE_BACKEND_URL;
const toast = useToast();

const store = createStore({
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],
    state: {
        loginUser: {
            email: VueCookies.get('user') ? VueCookies.get('user').email : "",
            name: VueCookies.get('user') ? VueCookies.get('user').name : "Not logged in",
            api_token: VueCookies.get('user') ? VueCookies.get('user').api_token : "",
            profile: "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png",
        },
        isLogin: false,
        filteredFetchBook: [],
        book: {},
        newBookId: null,
    },
    mutations: {
        logout(state) {
            VueCookies.remove('user');
            this.state.loginUser.name = "Not logged in"
            this.state.loginUser.email = ""
            this.state.loginUser.api_token = ""
            this.state.isLogin = false;
        },
        login(state, user) {
            VueCookies.set('user', user);
            this.state.loginUser.name = VueCookies.get('user').name;
            this.state.loginUser.email = VueCookies.get('user').email;
            this.state.loginUser.api_token = VueCookies.get('user').api_token;
            this.state.isLogin = true;
        },
    },

    getters: {
        booksByCategory: (state) => (category) => {
            return state.fetchBooks.filter(book => book.categories == category);
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
                console.log("fetchBookByWithAuth", response);
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
                    commit("login", user);
                    toast.success(responseData.message);
                    router.push('/home');
                }
            } catch (error) {
                console.error("Error register user:", error);
                toast.error(error.response.data.message);
            }
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
                    const user = {
                        name: responseData.data.name,
                        email: responseData.data.email,
                        api_token: responseData.data.api_token,
                    }
                    commit("login", user);
                    toast.success(responseData.message);
                    router.push('/home');
                }
            } catch (error) {
                console.error("Error login user:", error);
                toast.error(error.response.data.message);
            }
        },
    },
})

export default store