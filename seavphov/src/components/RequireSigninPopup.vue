<template>
  <FwbModal
    v-if="$signinState.showPopupRequiredSignin"
    size="md"
    @close="$signinMethods.closeRequiredSigninPopup()"
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
          @click="$signinMethods.closeRequiredSigninPopup()"
          text="Cancel"
          color="danger"
        />
        <LoadingButton @click="toRouteName('signup')" text="Sign in" />
      </div>
    </template>
  </FwbModal>
</template>

<script>
export default {
  name: "RequireSigninPopup",
};
</script>

<style>
</style>