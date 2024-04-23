
import VueCookies from 'vue-cookies';

export function setCookie(user) {
    console.log("setCookie",user);
    VueCookies.set('user', user);
}

export function getCookie() {
    return VueCookies.get('user')
}

export function removeCookie() {
    VueCookies.remove('user');
}
