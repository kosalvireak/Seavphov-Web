<template>
  <section>
    <div
      v-if="!isLogin"
      class="w-100 h-24 flex-center flex-column border rounded-lg justify-content-evenly"
    >
      <p class="mb-0">Sign up to add a discussion!</p>

      <FwbButton
        @click="toRouteName('signup')"
        gradient="green"
        class="m-0 px-2 text-xs w-fit"
        >Signup</FwbButton
      >
    </div>
    <AddDiscussionForm v-else @on-add-discussion="onAddDiscussion" />
  </section>
</template>

<script>
import AddDiscussionForm from "./AddDiscussionForm.vue";
export default {
  components: { AddDiscussionForm },
  name: "AddDiscussionContainer",
  methods: {
    onAddDiscussion(response) {
      console.log("AddDiscussionContainer", response);
      this.$emit("onAddDiscussion", response);
    },
  },
};
</script>

<style>
</style>