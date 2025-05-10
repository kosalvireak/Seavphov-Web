import { reactive } from "vue";

export const signInState = reactive({
  showPopupRequiredSignIn: false,
});

export const signInMethods = {
  requireSignInGuard(isLogin) {
    if (!isLogin) {
      signInState.showPopupRequiredSignIn = true;
      return true;
    }
    return false;
  },
  closeRequiredSignInPopup() {
    signInState.showPopupRequiredSignIn = false;
  },
};

// simply use below code before every method that required signIn
// if (Seavphov.requireSignInGuard(this.isLogin)) return;
