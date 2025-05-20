<template>
  <div class="CommentItemDropdown absolute right-2 top-0">
    <FwbDropdown align-to-end close-inside>
      <template #trigger>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg clickable">
          <i class="fas fa-ellipsis-v fa-lg"></i>
        </div>
      </template>
      <nav :class="fwbDropdownNavCss">
        <p :class="fwbDropdownItemCss" @click="onEdit()">Edit</p>
        <p :class="fwbDropdownItemCss" @click="deleteComment(id)">Delete</p>
      </nav>
    </FwbDropdown>
  </div>
</template>

<script>
import CommentController from "../../controllers/CommentController";
export default {
  name: "CommentItemDropdown",
  data() {
    return {
      isDeleting: false,
    };
  },
  props: {
    id: Number,
  },
  methods: {
    onEdit() {
      this.$emit("onEdit");
    },
    async deleteComment(id) {
      this.isDeleting = true;
      const response = await CommentController.deleteComment(id);
      if (response) {
        this.$emit("onRemove", id);
      }
      this.isDeleting = false;
    },
  },
};
</script>

<style></style>
