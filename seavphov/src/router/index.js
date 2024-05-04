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
import Books from '../components/admin/Books.vue'
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
              ]
        },
        {
            path: "/:pathMatch(.*)*",
            redirect: '/home'
        }
    ],
})


router.beforeEach((to, from, next) => {
    if (to.meta.requiresCookie) {
      if (getCookie()) {
        next();
      } else {
        next('/login');  
      }
    } else if(to.meta.requiredAdminAuth){
        if (store.dispatch("adminGetAuth")) {
            next();
        } else {
            next('/login');  
        }
    } else {
      next();
    }
  });


export default router
