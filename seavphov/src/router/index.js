import { createRouter, createWebHistory } from "vue-router";
import Home from "../view/Home.vue";
import BookDetail from "../view/BookDetail.vue";
import Login from "../view/auth/Login.vue";
import Signup from "../view/auth/Signup.vue";
import Profile from "../view/Profile.vue";
import SearchResult from "../view/SearchResult.vue";
import AddBook from "../view/AddBook.vue";
import EditBook from "../view/EditBook.vue";
import EditProfile from "../view/EditProfile.vue";
import ViewProfile from "../view/ViewProfile.vue";
import UsersList from "../view/admin/UsersList.vue";
import BannersList from "../view/admin/BannersList.vue";
import BooksList from "../view/admin/BooksList.vue";
import ForgotPassword from "../view/auth/ForgotPassword.vue";
import { getCookie } from "../services/cookie.js";
import store from "../utils/store.js";
import UserLayout from "../layout/UserLayout.vue";
import AuthLayout from "../layout/AuthLayout.vue";
import AdminLayout from "../layout/AdminLayout.vue";
import DashboardOverview from "../view/admin/DashboardOverview.vue";
import Discussion from "../view/Discussion.vue";
import DiscussionDetail from "../view/DiscussionDetail.vue";
import SearchCommunity from "../view/community/SearchCommunity.vue";
import CommunityHome from "../view/community/CommunityHome.vue";
import CreateCommunity from "../view/community/CreateCommunity.vue";
import SendEmail from "../view/auth/SendEmail.vue";
import CommunityLayout from "../layout/CommunityLayout.vue";
import CommunityMembers from "../components/community/members/CommunityMembers.vue";
import NotFound from "../view/auth/NotFound.vue";
import CommunitySettings from "../components/community/home/CommunityAdmin.vue";
import ReadingChallengeDetail from "../view/community/ReadingChallengeDetail.vue";
import AdminController from "../controllers/admin/AdminController.js";
import AboutUs from "../view/AboutUs.vue";
import CommunitiesList from "../view/admin/CommunitiesList.vue";

const appName = import.meta.env.VITE_APP_NAME;

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior(to, from, savedPosition) {
    // always scroll to top
    return { top: 0 }
  },
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
          meta: { title: "Login" },
        },
        {
          path: "/signup",
          name: "signup",
          component: Signup,
          meta: { title: "Signup" },
        },
        {
          path: "/send-mail",
          name: "send-mail",
          component: SendEmail,
        },
        {
          path: "/forgot-password",
          name: "forgot-password",
          component: ForgotPassword,
          meta: { title: "Forgot Password" },
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
          meta: { requiredAdminAuth: true, title: "Admin - Overview" },
        },
        {
          path: "users",
          name: "admin.users",
          component: UsersList,
          meta: { requiredAdminAuth: true, title: "Admin - Users" },
        },
        {
          path: "books",
          name: "admin.books",
          component: BooksList,
          meta: { requiredAdminAuth: true, title: "Admin - Books" },
        },
        {
          path: "communities",
          name: "admin.communities",
          component: CommunitiesList,
          meta: { requiredAdminAuth: true, title: "Admin - Communities" },
        },
        {
          path: "banners",
          name: "admin.banners",
          component: BannersList,
          meta: { requiredAdminAuth: true, title: "Admin - Banners" },
        },
      ],
    },
    {
      path: "/",
      name: "user",
      component: UserLayout,
      children: [
        {
          path: "/not-found",
          name: "not-found",
          component: NotFound,
          meta: { title: "Not Found" },
        },
        {
          path: "/profile",
          name: "profile",
          component: Profile,
          meta: { requiresCookie: true, title: appName + " - Profile" },
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
          meta: { requiresCookie: true, title: appName + " - Profile Setting" },
        },
        {
          path: "/home",
          name: "home",
          component: Home,
        },
        {
          path: "/about-us",
          name: "about-us",
          component: AboutUs,
        },
        {
          path: "/search",
          name: "search",
          component: SearchResult,
          meta: { title: appName + " - Search Book" },
        },
        {
          path: "/book",
          name: "book",
          children: [
            {
              path: "new",
              name: "add-book",
              component: AddBook,
              meta: { requiresCookie: true, title: appName + " - Create Book" },
            },
            {
              path: "edit/:id",
              name: "edit-book",
              component: EditBook,
              meta: { requiresCookie: true, title: appName + " - Edit Book" },
            },
            {
              path: ":id",
              name: "book-detail",
              component: BookDetail,
              meta: { title: appName + " - Book" },
            },
          ],
        },
        {
          path: "/discussion",
          name: "discussion-forum",
          children: [
            {
              path: "",
              name: "discussion",
              component: Discussion,
              meta: { title: appName + " - Discussion" },
            },
            {
              path: ":id",
              name: "discussion-detail",
              component: DiscussionDetail,
              meta: { title: appName + " - Discussion" },
            },
          ],
        },
        {
          path: "/community/:route",
          name: "community",
          component: CommunityLayout,
          children: [
            {
              path: "",
              name: "community-home",
              component: CommunityHome,
              props: true,
              meta: { title: appName + " - Community Home" },
            },
            {
              path: "members",
              name: "community-members",
              component: CommunityMembers,
              props: true,
              meta: {
                requiresCookie: true,
                title: appName + " - Community Members",
              },
            },
            {
              path: "admin",
              name: "community-admin",
              component: CommunitySettings,
              meta: {
                requiresCookie: true,
                title: appName + " - Community Admin",
              },
            },
            {
              path: "reading-challenge/:id",
              name: "reading-challenge-detail",
              component: ReadingChallengeDetail,
              meta: {
                requiresCookie: true,
                title: appName + " - Reading Challenge",
              },
            },
          ],
        },
        {
          path: "/search-community",
          name: "search-community",
          component: SearchCommunity,
          meta: { title: appName + " - Search Community" },
        },
        {
          path: "/create-community",
          name: "create-community",
          component: CreateCommunity,
          meta: { requiresCookie: true, title: "Create Community" },
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
  // Set document Title
  document.title = to.meta.title ? to.meta.title : appName;

  if (to.meta.requiresCookie) {
    if (await getCookie()) {
      next();
    } else {
      next("/login");
    }
  } else if (to.meta.requiredAdminAuth) {
    const auth = await AdminController.adminGetAuth();
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
