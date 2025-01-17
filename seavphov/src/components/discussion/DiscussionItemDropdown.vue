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
            <p :class="dropdownItemCss" @click="deleteDiscussion()">Delete</p>
          </li>
        </ul>
      </template>
    </Dropdown>
  </div>
</template>

<script>
export default {
  name: "DiscussionItemDropdown",
  data() {
    return {
      dropdownItemCss:
        "block px-4 py-2 mb-0 w-100 text-sm text-center text-gray-700 hover:bg-gray-200 clickable",
    };
  },
  props: {
    id: Number,
  },
  methods: {
    async deleteDiscussion() {
      this.isDeleting = true;
      const response = await this.$store.dispatch("deleteDiscussion", this.id);
      this.$router.go(0);
      this.isDeleting = false;
    },
  },
};
</script>
