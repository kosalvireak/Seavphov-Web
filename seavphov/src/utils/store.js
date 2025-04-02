import { createStore } from "vuex";
import { useToast } from "vue-toastification";
import axiosInstance from "../services/axiosInstance.js";
import { getData, deleteData, postForm } from "./apiUtils.js";
import router from "../router/index.js";

import { setCookie, getCookie, removeCookie } from "../services/cookie.js";

const backend_url = import.meta.env.VITE_BACKEND_URL;
const toast = useToast();

const store = createStore({
  state: {
    user: {
      email: null,
      name: "Not logged in",
      api_token: null,
      uuid: null,
      picture:
        "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png",
    },
  },
  mutations: {
    SET_USER(state, userData) {
      state.user = userData;
    },
  },
  actions: {
    setUserFromCookies({ commit }) {
      if (getCookie()) {
        const { name, email, api_token, picture, uuid } = getCookie();
        commit("SET_USER", { name, email, api_token, picture, uuid });
      }
    },
    async logoutUser({ commit }) {
      removeCookie();
      const name = "Not logged in";
      const email = null;
      const api_token = null;
      const picture =
        "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
      commit("SET_USER", { name, email, api_token, picture });
    },
    async registerUser({ dispatch }, signupData) {
      try {
        const response = await axiosInstance.post(
          backend_url + "/api/user/register",
          signupData,
          {
            headers: {
              "Content-Type": "application/json",
            },
          },
        );
        const responseData = await response.data;
        if (responseData.success) {
          const user = {
            name: responseData.data.name,
            email: responseData.data.email,
            api_token: responseData.data.api_token,
            uuid: responseData.data.uuid,
            picture: responseData.data.picture,
          };
          setCookie(user);
          dispatch("setUserFromCookies");
          toast.success(responseData.message);
          router.push("/home");
        }
      } catch (error) {
        console.error("Error register user:", error);
        toast.error(error.response.data.message);
      }
    },
    async loginUser({ dispatch }, loginData) {
      try {
        const response = await axiosInstance.post(
          backend_url + "/api/user/login",
          loginData,
          {
            headers: {
              "Content-Type": "application/json",
            },
          },
        );
        const responseData = await response.data;
        if (responseData.success) {
          const user = {
            name: responseData.data.name,
            email: responseData.data.email,
            api_token: responseData.data.api_token,
            picture: responseData.data.picture,
            uuid: responseData.data.uuid,
          };
          setCookie(user);
          dispatch("setUserFromCookies");
          toast.success(responseData.message);
          router.push("/home");
        }
      } catch (error) {
        console.error("Error login user:", error);
        toast.error(error.response.data.message);
      }
    },

    async resetPassword({}, formData) {
      try {
        const response = await postForm("/api/reset/", formData, true);
        if (response.data.success) {
          toast.success(response.data.message);
        }
      } catch (error) {
        console.error("Error reset password", error);
        toast.error(error.response.data.message);
      }
    },
    async modifyUserProfile({ dispatch }, formData) {
      try {
        const response = await postForm("/api/profile", formData, true);
        if (response.data.success) {
          const responseData = response.data.data;
          const user = {
            name: responseData.name,
            email: responseData.email,
            api_token: responseData.api_token,
            picture: responseData.picture,
            uuid: responseData.uuid,
          };
          setCookie(user);
          dispatch("setUserFromCookies");
          toast.success(response.data.message);
        }
      } catch (error) {
        console.error("Error adding book:", error);
        toast.error(error.response.data.message);
      }
    },
    async adminGetBooks() {
      try {
        const response = await getData("/api/admin/books", true);
        if (response.data.success) {
          return response.data.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminDeleteBook({}, id) {
      try {
        const response = await getData(`/api/admin/books/delete/${id}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminDeleteBanner({}, id) {
      try {
        const response = await getData(`/api/admin/banners/${id}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async changeSelectedBanner({}, id) {
      try {
        const response = await getData(
          `/api/admin/banners/selected/${id}`,
          true,
        );
        if (response.data.success) {
          toast.success(response.data.message);
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminGetBanners() {
      try {
        const response = await getData("/api/admin/banners", true);
        if (response.data.success) {
          return response.data.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminGetOverviewData() {
      try {
        const response = await getData("/api/admin/overview", true);
        if (response.data.success) {
          return response.data.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminGetUsers() {
      try {
        const response = await getData("/api/admin/users", true);
        if (response.data.success) {
          return response.data.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminGetAuth() {
      try {
        const response = await getData("/api/admin/auth", true);
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
    async adminAddBanner({}, formData) {
      try {
        const response = await postForm("/api/admin/banners/", formData, true);
        toast.success(response.data.message);
        if (response.data.success) {
          return response.data.success;
        }
      } catch (error) {
        console.error("Error adding book:", error);
        toast.error(error.response.data.message);
      }
    },

    async deleteBook({}, id) {
      try {
        const response = await deleteData(`/api/books/${id}`);
        toast.success(response.data.message);
      } catch (error) {
        console.error("Error adding book:", error);
        toast.error(error.response.data.message);
        return false;
      }
    },
    async toggleSaveBook({}, bookId) {
      try {
        const response = await getData(`/api/saved/${bookId}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
          return true;
        }
      } catch (error) {
        toast.error(error.message);
        return false;
      }
    },
    async getNotifications() {
      try {
        const response = await getData("/api/notification", true);
        if (response.data.success) {
          return response.data.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
        return false;
      }
    },
    async sendEmailResetPassword({}, formData) {
      try {
        const response = await postForm("/api/reset/send", formData, true);
        if (response.data.success) {
          toast.success(response.data.message);
        }
      } catch (error) {
        console.error("Error sending email", error);
        toast.error(error.response.data.message);
        return false;
      }
    },
    async likeReview({}, reviewId) {
      try {
        const response = await getData(`/api/review/like/${reviewId}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
          return response.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
        return false;
      }
    },
    async dislikeReview({}, reviewId) {
      try {
        const response = await getData(`/api/review/dislike/${reviewId}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
          return response.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
        return false;
      }
    },

    async likeDiscussion({}, discussionId) {
      try {
        const response = await getData(
          `/api/discussions/like/${discussionId}`,
          true,
        );
        if (response.data.success) {
          toast.success(response.data.message);
          return response.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
        return false;
      }
    },
    async dislikeDiscussion({}, discussionId) {
      try {
        const response = await getData(
          `/api/discussions/dislike/${discussionId}`,
          true,
        );
        if (response.data.success) {
          toast.success(response.data.message);
          return response.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
        return false;
      }
    },
    async likeComment({}, commentId) {
      try {
        const response = await getData(`/api/comment/like/${commentId}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
          return response.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
        return false;
      }
    },
    async dislikeComment({}, commentId) {
      try {
        const response = await getData(
          `/api/comment/dislike/${commentId}`,
          true,
        );
        if (response.data.success) {
          toast.success(response.data.message);
          return response.data;
        }
      } catch (error) {
        toast.error(error.response.data.message);
        return false;
      }
    },
  },
});

export default store;
