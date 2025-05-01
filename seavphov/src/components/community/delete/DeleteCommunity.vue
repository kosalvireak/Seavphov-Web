<template>
  <section class="DeleteCommunity card p-4">
    <ul>
      <li>⚠️ This community will be deleted.</li>
      <li>⚠️ All the reading challenges will be deleted.</li>
      <li>⚠️ You cannot undo this action.</li>
    </ul>
    <div class="flex justify-content-end">
      <LoadingButton
        text="Delete"
        class="mt-3 w-fit"
        color="danger"
        :isLoading="isLoading"
        @click="deleteCommunity()"
      />
    </div>
  </section>
</template>

<script>
import CommunityController from "../../../controllers/CommunityController";
export default {
  name: "DeleteCommunity",
  props: {
    route: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      isLoading: false,
    };
  },
  methods: {
    async deleteCommunity() {
      this.isLoading = true;
      const data = await CommunityController.deleteCommunity(this.route);
      if (data) {
        this.toRouteName("search-community");
      }
      this.isLoading = false;
    },
  },
};
</script>

<style></style>
