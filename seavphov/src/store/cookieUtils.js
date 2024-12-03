
import VueCookies from 'vue-cookies';
import CryptoJS from "crypto-js";

const secretKey = import.meta.env.VITE_secretKey;


export function setCookie(user) {
    var encryptedData = CryptoJS.AES.encrypt(JSON.stringify(user), secretKey).toString();
    VueCookies.set('seavphov', encryptedData);
}


export function getCookie() {
    var user = VueCookies.get('seavphov');
    if (user) {
        var bytes = CryptoJS.AES.decrypt(user, secretKey);
        var decryptedData = JSON.parse(bytes.toString(CryptoJS.enc.Utf8));
        return decryptedData;
    } else {
        return null;
    }
}

export function removeCookie() {
    VueCookies.remove('seavphov');
}
