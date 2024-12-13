import { createStore } from 'vuex'
import { useToast } from "vue-toastification"
import router from '../router/index.js';
import axiosInstance from '../../axiosInstance.js';
import { getData, postJson, postForm } from "./apiUtils.js";

import { setCookie, getCookie, removeCookie } from './cookieUtils.js';

const backend_url = import.meta.env.VITE_BACKEND_URL;
const toast = useToast();

const store = createStore({
    state: {
        user: {
            email: null,
            name: "Not logged in",
            api_token: null,
            uuid: null,
            picture: "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png",
        },
        filteredFetchBook: [],
        book: {},
        newBookId: null,
    },
    mutations: {
        SET_USER(state, userData) {
            state.user = userData;
        }
    },
    getters: {
        booksByCategory: (state) => (category) => {
            return state.fetchBooks.filter(book => book.categories == category);
        },
        isLogin: () => {
            return getCookie() != null;
        },
    },

    actions: {
        setUserFromCookies({ commit }) {
            if (getCookie()) {
                const { name, email, api_token, picture, uuid } = getCookie();
                commit('SET_USER', { name, email, api_token, picture, uuid });
            }
        },
        async logoutUser({ commit }) {
            localStorage.removeItem("reloaded");
            removeCookie();
            const name = "Not logged in";
            const email = null;
            const api_token = null;
            const picture = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
            commit('SET_USER', { name, email, api_token, picture });
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
                        uuid: responseData.data.uuid,
                        picture: responseData.data.picture,
                    }
                    setCookie(user);
                    dispatch('setUserFromCookies');
                    toast.success(responseData.message);
                    this.toRouteName(home)
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
                console.log("responseData", responseData);
                if (responseData.success) {
                    console.log("user", responseData.data);
                    const user = {
                        name: responseData.data.name,
                        email: responseData.data.email,
                        api_token: responseData.data.api_token,
                        picture: responseData.data.picture,
                        uuid: responseData.data.uuid
                    }
                    setCookie(user);
                    dispatch('setUserFromCookies');
                    toast.success(responseData.message);
                    this.toRouteName('home')
                }
            } catch (error) {
                console.error("Error login user:", error);
                toast.error(error.response.data.message);
            }
        },
        async fetchUserProfile() {
            try {
                // const response = await getData("profile")
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
        async fetchOtherUserProfile({ }, uuid) {
            try {
                // const response = await getData("user/" + uuid)
                const response = await axiosInstance.get(backend_url + "/api/user/" + uuid, {
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
        async modifyUserProfile({ dispatch }, formData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/profile", formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });
                if (response.data.success) {
                    const responseData = response.data.data;
                    const user = {
                        name: responseData.name,
                        email: responseData.email,
                        api_token: responseData.api_token,
                        picture: responseData.picture,
                        uuid: responseData.uuid
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
        async fetchBooksWithFilter({ }, filters) {
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
            if (filters.condition) {
                params.append('condition', filters.condition);
            }
            if (filters.owner_id) {
                params.append('owner_id', filters.owner_id);
            }
            if (filters.uuid) {
                params.append('uuid', filters.uuid);
            }
            if (filters.all) {
                params.append('all', true);
            }
            try {
                const response = await getData(`/api/books?${params.toString()}`)
                if (response.data.success) {
                    if (filters.all) {
                        return response.data.message;
                    }
                    return response.data.message.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminGetBooks() {
            try {
                const response = await axiosInstance.get(backend_url + '/api/admin/books', {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                }); // Add params to URL
                if (response.data.success) {
                    return response.data.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminDeleteBook({ }, id) {
            try {
                const response = await axiosInstance.get(backend_url + '/api/admin/books/delete/' + id, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                    toast.success(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminDeleteBanner({ }, id) {
            try {
                const response = await axiosInstance.get(backend_url + '/api/admin/banners/' + id, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                    toast.success(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async changeSelectedBanner({ }, id) {
            try {
                const response = await axiosInstance.get(backend_url + '/api/admin/banners/selected/' + id, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                    toast.success(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminGetBanners() {
            try {
                const response = await axiosInstance.get(backend_url + '/api/admin/banners', {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                    return response.data.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminGetOverviewData() {
            try {
                const response = await getData('/api/admin/overview', true, this.state.user.api_token);
                if (response.data.success) {
                    return response.data.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async getBanner() {
            try {
                const response = await getData('/api/books/banner');
                if (response.data.success) {
                    return response.data.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminGetUsers() {
            try {
                const response = await getData('/api/admin/users', true, this.state.user.api_token)
                if (response.data.success) {
                    return response.data.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminGetAuth() {
            try {
                const response = await getData('/api/admin/auth', true, this.state.user.api_token);
                if (response.data.success) {
                    return response.data.data;
                } else {
                    toast.error(response.data.message);
                    return false;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async adminAddBanner({ }, formData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/admin/banners/", formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });
                toast.success(response.data.message);
                if (response.data.success) {
                    return response.data.success;
                }
            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },
        async fetchBookById({ }, formData) {
            try {
                let id = formData.get("id");
                const response = await axiosInstance.post(backend_url + "/api/books/" + id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                if (response.data.success) {
                    return [response.data.book, response.data.owner];
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async getMyBooks() {
            try {
                const response = await axiosInstance.get(backend_url + "/api/auth/book", {
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
        async getMyBook({ }, id) {
            try {
                const response = await axiosInstance.get(backend_url + "/api/auth/book/" + id, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                })
                if (response.data.success) {
                    return response.data.message;
                } else {
                    toast.error(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.message);
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
        async createBook({ }, formData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/books/", formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
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
        async modifyBook({ }, formData) {
            try {
                let id = formData.get("id");
                const response = await axiosInstance.post(backend_url + "/api/books/" + id, formData, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });
                toast.success(response.data.message);
            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },
        async deleteBook({ }, id) {
            try {
                const response = await axiosInstance.delete(backend_url + "/api/books/" + id, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                toast.success(response.data.message);

            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },
        async saveBook({ }, bookId) {
            try {
                const response = await axiosInstance.get(backend_url + "/api/saved/" + bookId, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                    toast.success(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async getSavedBooksNotification() {
            try {
                const response = await axiosInstance.get(backend_url + "/api/saved/notification", {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                    return response.data.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async unSaveBook({ }, bookId) {
            try {
                const response = await axiosInstance.delete(backend_url + "/api/saved/" + bookId, {
                    headers: {
                        'Authorization': `Bearer ${this.state.user.api_token}`,
                    },
                });
                if (response.data.success) {
                    console.log("response.unSaveBook", response.data)

                    toast.success(response.data.message);
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async sendEmailResetPassword({ }, formData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/reset/send", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                console.log("response", response)
                if (response.data.success) {

                    toast.success(response.data.message);
                }
            } catch (error) {
                console.error("Error sending email", error);
                toast.error(error.response.data.message);
            }
        },
        async resetPassword({ }, formData) {
            try {
                const response = await axiosInstance.post(backend_url + "/api/reset/", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                console.log("response", response)
                if (response.data.success) {
                    toast.success(response.data.message);
                }
            } catch (error) {
                console.error("Error reset password", error);
                toast.error(error.response.data.message);
            }
        },

    },
})


export default store