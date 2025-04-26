<template>
  <div class="CommentItemDropdown absolute right-2 top-0">
    <Dropdown
      id="comment-item-dropdown"
      id_content="comment-item-dropdown_content"
      placement="bottom-end"
    >
      <template #button>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg">
          <i class="fas fa-ellipsis-v fa-xl"></i>
        </div>
      </template>
      <template #content>
        <ul class="py-2 mt-0">
          <li>
            <p :class="dropdownItemClass" @click="onEdit()">Edit</p>
          </li>
          <li>
            <p :class="dropdownItemClass" @click="deleteComment(id)">
              <span v-if="isDeleting">Deleting...</span>

              <span v-else>Delete</span>
            </p>
          </li>
        </ul>
      </template>
    </Dropdown>
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
