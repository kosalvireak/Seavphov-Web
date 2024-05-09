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
import Users from '../components/admin/Users.vue'
import Banners from '../components/admin/Banners.vue'
import Books from '../components/admin/Books.vue'
import ForgotPassword from '../view/ForgotPassword.vue'
import { getCookie } from "../store/cookieUtils.js"
import store from '../store/index.js'


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
            path: "/forgot-password",
            name: "forgot-password",
            component: ForgotPassword,
        },
        {
            path: "/profile",
            name: "profile",
            component: Profile,
            meta: { requiresCookie: true }
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
            path: '/admin',
            name: 'admin',
            component: Dashboard,
            meta: {  requiredAdminAuth: true},
            children: [
                {
                  path: 'users',
                  name: 'admin.users',
                  component: Users,
                  meta: {  requiredAdminAuth: true},
                },
                {
                    path: 'books',
                    name: 'admin.books',
                    component: Books,
                    meta: {  requiredAdminAuth: true},
                  },
                {
                    path: 'banners',
                    name: 'admin.banners',
                    component: Banners,
                    meta: {  requiredAdminAuth: true},
                  },
              ]
        },
        {
            path: "/:pathMatch(.*)*",
            redirect: '/home'
        }
    ],
})


router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresCookie) {
      if (await getCookie()) {
        next();
      } else {
        next('/login');  
      }
    } else if(to.meta.requiredAdminAuth){
        const auth = await store.dispatch("adminGetAuth")
        if (auth == true) {
            next();
        } else {
            next('/home');  
        }
    } else {
      next();
    }
  });


export default router
