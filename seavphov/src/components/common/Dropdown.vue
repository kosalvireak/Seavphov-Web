<template>
  <section>
    <button
      type="button"
      class="flex text-sm rounded-full md:me-0"
      :class="cssButton"
      :id="id"
      aria-expanded="false"
      :data-dropdown-toggle="id_content"
      data-dropdown-placement="bottom"
      @click="onToggleDropdown()"
    >
      <slot name="button"> </slot>
    </button>
    <div
      ref="content"
      class="z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
      :class="cssContent"
      :id="id_content"
    >
      <slot name="content" v-if="hiddenContent"> </slot>
    </div>
  </section>
</template>

<script>
export default {
  name: "Dropdown",
  props: {
    id: {
      type: String,
      default: "dropdown",
    },
    id_content: {
      type: String,
      default: "dropdown-toggle",
    },
    cssContent: String,
    cssButton: String,
  },
  data() {
    return {
      hiddenContent: false,
    };
  },
  methods: {
    onToggleDropdown() {
      this.$refs.content.classList.toggle("hidden");
      this.hiddenContent = !this.$refs.content.classList.contains("hidden");
    },
  },
};
</script>

<style>
</style>