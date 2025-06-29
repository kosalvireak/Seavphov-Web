import { createStore } from "vuex";
import { useToast } from "vue-toastification";
import { getData, deleteData, postForm } from "./apiUtils.js";
import router from "../router/index.js";
import { setCookie, getCookie, removeCookie } from "../services/cookie.js";

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
    async setCookieAndRedirectToHome({ dispatch }, responseData) {
      const user = {
        name: responseData.name,
        email: responseData.email,
        api_token: responseData.api_token,
        uuid: responseData.uuid,
        picture: responseData.picture,
      };
      setCookie(user);
      dispatch("setUserFromCookies");
      router.push("/home");
    },
    async adminDeleteBook({ }, id) {
      try {
        const response = await getData(`/api/admin/books/delete/${id}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminDeleteBanner({ }, id) {
      try {
        const response = await getData(`/api/admin/banners/${id}`, true);
        if (response.data.success) {
          toast.success(response.data.message);
        }
      } catch (error) {
        toast.error(error.response.data.message);
      }
    },
    async adminAddBanner({ }, formData) {
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
    async likeReview({ }, reviewId) {
      return await getData(`/api/review/like/${reviewId}`, true);
    },
    async dislikeReview({ }, reviewId) {
      return getData(`/api/review/dislike/${reviewId}`, true);
    },
    async likeDiscussion({ }, discussionId) {
      return await getData(`/api/discussions/like/${discussionId}`, true);
    },
    async dislikeDiscussion({ }, discussionId) {
      return await getData(`/api/discussions/dislike/${discussionId}`, true);
    },
    async likeComment({ }, commentId) {
      return await getData(`/api/comment/like/${commentId}`, true);
    },
    async dislikeComment({ }, commentId) {
      return await getData(`/api/comment/dislike/${commentId}`, true);
    },
  },
});

export default store;
