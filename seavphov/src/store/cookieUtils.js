
import VueCookies from 'vue-cookies';

export function setUserCookie(user) {
    console.log("setUserCookie",user);
    VueCookies.set('user', user);
}

export function getUserCookie() {
    return VueCookies.get('user')
}

export function removeUserCookie() {
    VueCookies.remove('user');
}