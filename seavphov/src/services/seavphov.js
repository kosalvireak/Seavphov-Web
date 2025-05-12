import { useToast } from "vue-toastification";
import { signInMethods } from "../utils/requireSignin";

export default class Seavphov {
  static logoUrl =
    "https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/Seavphov%20Logo-2.png";
  static maxRelatedBook = 5;
  static defaultCopProfile =
    "https://static.vecteezy.com/system/resources/previews/054/453/530/non_2x/proactive-community-engagement-icon-vector.jpg";
  static defaultCopBanner =
    "https://charitysmith.org/wp-content/uploads/2023/09/community.webp";
  static maxPaginateCop = 6;

  static maxPaginateBook = 10;

  static toast = useToast();

  static requireSignInGuard(isLogin) {
    return signInMethods.requireSignInGuard(isLogin);
  }

  static closeRequiredSignInPopup() {
    signInMethods.closeRequiredSignInPopup();
  }
}
