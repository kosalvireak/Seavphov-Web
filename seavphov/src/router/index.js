import { createRouter, createWebHistory } from 'vue-router'
import Home from "../view/Home.vue"
import BookDetail from "../view/BookDetail.vue"
import Login from "../view/Login.vue"
import Signup from "../view/Signup.vue"
import Profile from "../view/Profile.vue"
import SearchResult from "../view/SearchResult.vue"
import AddBook from "../view/AddBook.vue"
import EditBook from "../view/EditBook.vue"
import EditProfile from "../view/EditProfile.vue"
import ViewProfile from "../view/ViewProfile.vue"
import Dashboard from '../view/admin/Dashboard.vue'
import { getCookie } from "../store/cookieUtils.js"


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            redirect: { path: "/home" },
            component: Home,
        },
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
            path: "/profile",
            name: "profile",
            component: Profile,
            meta: { requiresCookie: true }
        },
        
        {
            path: "/profile/:username",
            name: "user-profile",
            component: ViewProfile,
            // meta: { requiresCookie: true }
        },
        {
            path: "/edit-profile",
            name: "edit-profile",
            component: EditProfile,
            meta: { requiresCookie: true }
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
            name: "newbook",
            component: AddBook,
            meta: { requiresCookie: true }
        },
        {
            path: "/book/edit/:id",
            name: "editbook",
            component: EditBook,
            meta: { requiresCookie: true }
        },
        {
            path: '/book/:id',
            name: 'book-detail',
            component: BookDetail,
        },
        {
            path: '/admin/dashboard',
            name: 'admin',
            component: Dashboard,
        },
        {
            path: "/:pathMatch(.*)*",
            redirect: '/home'
        }
    ],
})


router.beforeEach((to, from, next) => {
    // Check if the route requires a cookie
    if (to.meta.requiresCookie) {
      // Check if the cookie exists
      if (getCookie()) {
        // Cookie exists, proceed to the route
        next();
      } else {
        // Cookie doesn't exist, redirect to another route
        next('/login'); // Redirect to login page or any other route
      }
    } else {
      // Route doesn't require a cookie, proceed as usual
      next();
    }
  });


export default router
