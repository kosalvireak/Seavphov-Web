<template>
  <div class="DiscussionItemDropdown">
    <Dropdown
      id="discussion-dropdown"
      id_content="discussion-dropdown_content"
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
            <p :class="dropdownItemClass" @click="editDiscussion()">
              <span>Edit</span>
            </p>
          </li>
          <li>
            <p :class="dropdownItemClass" @click="deleteDiscussion()">
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
