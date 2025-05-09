import { reactive } from 'vue';

export const signinState = reactive({
    showPopupRequiredSignin: false
});

export const signinMethods = {
    requireSigninGuard(isLogin) {
        if (!isLogin) {
            signinState.showPopupRequiredSignin = true;
            return true
        }
        return false
    },
    closeRequiredSigninPopup() {
        signinState.showPopupRequiredSignin = false;
    }
};

// simply use below code before every method that required signin
// if (this.$signinMethods.requireSigninGuard(this.isLogin)) return;