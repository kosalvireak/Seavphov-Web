<template>
  <FwbModal
    v-if="signInState.showPopupRequiredSignIn"
    size="md"
    @close="() => Seavphov.closeRequiredSignInPopup()"
  >
    <template #header>
      <span class="text-lg"> Sign in required </span>
    </template>
    <template #body>
      <div class="flex-center flex-col space-y-2 text-center">
        <p class="h4">
          To continue, please sign in to your account. This helps us keep your
          data safe and provide a personalized experience.
        </p>
      </div>
    </template>
    <template #footer>
      <div class="w-full flex justify-between">
        <LoadingButton
          @click="() => Seavphov.closeRequiredSignInPopup()"
          text="Cancel"
          color="danger"
        />
        <LoadingButton @click="handleClickSignIn()" text="Sign in" />
      </div>
    </template>
  </FwbModal>
</template>

<script>
import { signInState } from "../utils/requireSignin";
import Seavphov from "../services/seavphov";
export default {
  name: "RequireSigninPopup",
  setup() {
    return {
      signInState,
      Seavphov,
    };
  },
  methods: {
    handleClickSignIn() {
      Seavphov.closeRequiredSignInPopup();
      this.toRouteName("signup");
    },
  },
};
</script>

<style></style>
