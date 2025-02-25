<template>
  <div class="CommentItemDropdown absolute right-2 top-0">
    <Dropdown
      id="comment-item-dropdown"
      id_content="comment-item-dropdown_content"
      placement="bottom-start"
    >
      <template #button>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg">
          <i class="fas fa-ellipsis-v fa-xl"></i>
        </div>
      </template>
      <template #content>
        <ul class="py-2 mt-0">
          <li>
            <p :class="dropdownItemCss" @click="editBook()">Edit</p>
          </li>
          <li>
            <p :class="dropdownItemCss" @click="deleteComment(id)">Delete</p>
          </li>
        </ul>
      </template>
    </Dropdown>
  </div>
</template>

<script>
export default {
  name: "CommentItemDropdown",
  data() {
    return {
      isDeleting: false,
      dropdownItemCss:
        "block px-4 py-2 mb-0 w-100 text-sm text-center text-gray-700 hover:bg-gray-200 clickable",
    };
  },
  props: {
    id: Number,
  },
  methods: {
    editBook() {
      this.$emit("onEdit");
    },
    async deleteComment(id) {
      this.isDeleting = true;
      const response = await this.$store.dispatch("deleteComment", id);
      if (response) {
        this.$emit("onRemove", id);
      }
      this.isDeleting = false;
    },
  },
};
</script>

<style></style>
