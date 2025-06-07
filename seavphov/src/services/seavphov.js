import { useToast } from "vue-toastification";
import { signInMethods } from "../utils/requireSignin";

export default class Seavphov {
  static logoUrl =
    "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2FSeavphov%20Logo-2-min.png?alt=media&token=9766ac82-0403-4c08-ab32-43bb61e27b0e";
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
