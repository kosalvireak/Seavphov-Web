<template>
  <div class="ReviewItemDropdown absolute right-2 top-0">
    <FwbDropdown align-to-end close-inside>
      <template #trigger>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg clickable">
          <i class="fas fa-ellipsis-v fa-lg"></i>
        </div>
      </template>
      <nav :class="fwbDropdownNavCss">
        <p
          v-if="review.edit_able"
          :class="fwbDropdownItemCss"
          @click="onEdit()"
        >
          Edit
        </p>
        <p
          v-if="review.delete_able"
          :class="fwbDropdownItemCss"
          @click="deleteReview(id)"
        >
          Delete
        </p>
      </nav>
    </FwbDropdown>
  </div>
</template>

<script>
import ReviewController from "../../controllers/ReviewController";
export default {
  name: "ReviewItemDropdown",
  props: {
    id: Number,
    review: Object,
  },
  methods: {
    onEdit() {
      this.$emit("onEdit");
    },
    async deleteReview(id) {
      const response = await ReviewController.deleteReview(id);
      if (response) {
        this.$emit("onRemoveReview", id);
      }
    },
  },
};
</script>

<style></style>
