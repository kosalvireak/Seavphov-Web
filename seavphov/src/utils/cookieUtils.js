import VueCookies from "vue-cookies";
import CryptoJS from "crypto-js";

const secretKey = import.meta.env.VITE_secretKey;

export function setCookie(user) {
  const encryptedData = CryptoJS.AES.encrypt(
    JSON.stringify(user),
    secretKey,
  ).toString();
  VueCookies.set("seavphov", encryptedData);
}

export function getCookie() {
  const user = VueCookies.get("seavphov");
  if (user) {
    const bytes = CryptoJS.AES.decrypt(user, secretKey);
    const data = JSON.parse(bytes.toString(CryptoJS.enc.Utf8));
    return data;
  } else {
    return null;
  }
}

export function removeCookie() {
  VueCookies.remove("seavphov");
}
