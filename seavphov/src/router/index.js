import { createRouter, createWebHistory } from "vue-router";
import Home from "../view/Home.vue";
import BookDetail from "../view/BookDetail.vue";
import Login from "../view/Login.vue";
import Signup from "../view/Signup.vue";
import Profile from "../view/Profile.vue";
import SearchResult from "../view/SearchResult.vue";
import AddBook from "../view/AddBook.vue";
import EditBook from "../view/EditBook.vue";
import EditProfile from "../view/EditProfile.vue";
import ViewProfile from "../view/ViewProfile.vue";
import UsersList from "../view/admin/UsersList.vue";
import BannersList from "../view/admin/BannersList.vue";
import BooksList from "../view/admin/BooksList.vue";
import ForgotPassword from "../view/ForgotPassword.vue";
import { getCookie } from "../utils/cookieUtils.js";
import store from "../utils/store.js";
import UserLayout from "../layout/UserLayout.vue";
import AuthLayout from "../layout/AuthLayout.vue";
import AdminLayout from "../layout/AdminLayout.vue";
import DashboardOverview from "../view/admin/DashboardOverview.vue";
import Discussion from "../view/Discussion.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      redirect: { path: "/home" },
      component: Home,
    },
    {
      path: "/auth",
      name: "auth",
      component: AuthLayout,
      children: [
        {
          path: "/login",
          name: "login",
          component: Login,
        },
        {
          path: "/signup",
          name: "signup",
          component: Signup,
        },
        {
          path: "/forgot-password",
          name: "forgot-password",
          component: ForgotPassword,
        },
      ],
    },
    {
      path: "/admin",
      name: "admin",
      component: AdminLayout,
      meta: { requiredAdminAuth: true },
      children: [
        {
          path: "",
          name: "admin.dashboard",
          component: DashboardOverview,
          meta: { requiredAdminAuth: true },
        },
        {
          path: "users",
          name: "admin.users",
          component: UsersList,
          meta: { requiredAdminAuth: true },
        },
        {
          path: "books",
          name: "admin.books",
          component: BooksList,
          meta: { requiredAdminAuth: true },
        },
        {
          path: "banners",
          name: "admin.banners",
          component: BannersList,
          meta: { requiredAdminAuth: true },
        },
      ],
    },
    {
      path: "/",
      name: "user",
      component: UserLayout,
      children: [
        {
          path: "/profile",
          name: "profile",
          component: Profile,
          meta: { requiresCookie: true },
        },
        {
          path: "/profile/:uuid",
          name: "user-profile",
          component: ViewProfile,
        },
        {
          path: "/edit-profile",
          name: "edit-profile",
          component: EditProfile,
          meta: { requiresCookie: true },
        },
        {
          path: "/home",
          name: "home",
          component: Home,
        },
        {
          path: "/search",
          name: "search",
          component: SearchResult,
        },
        {
          path: "/book/new",
          name: "add-book",
          component: AddBook,
          meta: { requiresCookie: true },
        },
        {
          path: "/book/edit/:id",
          name: "edit-book",
          component: EditBook,
          meta: { requiresCookie: true },
        },
        {
          path: "/book/:id",
          name: "book-detail",
          component: BookDetail,
        },
        {
          path: "/discussion",
          name: "discussion",
          component: Discussion,
        },
      ],
    },
    {
      path: "/:pathMatch(.*)*",
      redirect: "/home",
    },
  ],
});

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresCookie) {
    if (await getCookie()) {
      next();
    } else {
      next("/login");
    }
  } else if (to.meta.requiredAdminAuth) {
    const auth = await store.dispatch("adminGetAuth");
    if (auth === true) {
      next();
    } else {
      next("/home");
    }
  } else {
    next();
  }
});

export default router;
