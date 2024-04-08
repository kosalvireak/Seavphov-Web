import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import { useToast } from "vue-toastification"
import axios from "axios"
import VueCookies from 'vue-cookies';


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
        // start backend
        filteredFetchBook: [],
        book: {},
        newBookId: null,
        // end backend
    },

    getters: {
        // start backend
        booksByCategory: (state) => (category) => {
            return state.fetchBooks.filter(book => book.categories == category);
        },
        // end backend
    },

    actions: {
        // start backend
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
            try {
                const response = await axios.get(backend_url + `/api/books?${params.toString()}`); // Add params to URL
                if (response.data.success) {
                    this.state.filteredFetchBook = response.data.message.data;
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
        async createBook({ commit }, formData) {
            try {
                const response = await axios.post(backend_url + "/api/books/", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
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
                if (response.data.success) {
                    toast.success(response.data.message);
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
                    VueCookies.set('user', user);
                    this.state.loginUser.name = VueCookies.get('user').name;
                    this.state.loginUser.email = VueCookies.get('user').email;
                    this.state.loginUser.api_token = VueCookies.get('user').api_token;
                    toast.success(responseData.message);
                }
            } catch (error) {
                console.error("Error register user:", error);
                toast.error(error.response.data.message);
            }
        },
        // end backend
    },
})

export default store