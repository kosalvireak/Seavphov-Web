<template>
  <div class="DiscussionItemDropdown">
    <FwbDropdown align-to-end close-inside>
      <template #trigger>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg clickable">
          <i class="fas fa-ellipsis-v fa-lg"></i>
        </div>
      </template>
      <nav :class="fwbDropdownNavCss">
        <p :class="fwbDropdownItemCss" @click="editDiscussion()">Edit</p>
        <p :class="fwbDropdownItemCss" @click="deleteDiscussion()">Delete</p>
      </nav>
    </FwbDropdown>
  </div>
</template>

<script>
import DiscussionController from "../../controllers/DiscussionController";
export default {
  name: "DiscussionItemDropdown",
  data() {
    return {
      isDeleting: false,
      isEditing: false,
    };
  },
  props: {
    id: Number,
  },
  methods: {
    async deleteDiscussion() {
      this.isDeleting = true;
      await DiscussionController.deleteDiscussion(this.id);
      this.$emit("onDeleteDiscussion", this.id);
      this.isDeleting = false;
    },
    async editDiscussion() {
      this.$emit("onEditDiscussion");
    },
  },
};
</script>
