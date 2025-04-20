<template>
  <div class="ReviewItemDropdown absolute right-2 top-0">
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
          <li class="flex-center">
            <p :class="dropdownItemClass" @click="deleteReview(id)">
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
import ReviewController from "../../controllers/ReviewController";
export default {
  name: "ReviewItemDropdown",
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
    async deleteReview(id) {
      this.isDeleting = true;
      const response = await ReviewController.deleteReview(id);
      if (response) {
        this.$emit("onRemoveReview", id);
      }
      this.isDeleting = false;
    },
  },
};
</script>

<style></style>
