<template>
  <section class="AddDiscussionContainer">
    <div
      v-if="!isLogin"
      class="w-100 h-24 flex-center flex-column border rounded-lg justify-content-evenly"
    >
      <p class="mb-0">Log in to add a discussion!</p>

      <LoadingButton
        @click="toRouteName('signup')"
        color="green"
        class="m-0 px-2 text-xs w-fit"
        >Log in</LoadingButton
      >
    </div>
    <AddDiscussionForm
      v-else
      @on-add-discussion="$emit('onAddDiscussion', $event)"
    />
  </section>
</template>

<script>
import AddDiscussionForm from "./AddDiscussionForm.vue";
export default {
  components: { AddDiscussionForm },
  name: "AddDiscussionContainer",
};
</script>

<style></style>
