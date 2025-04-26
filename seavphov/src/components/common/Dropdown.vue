<template>
  <section class="relative">
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
      class="whitespace-nowrap absolute w-auto z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
      :class="[cssContent, position]"
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
    disabledListener: {
      type: Boolean,
      default: false,
    },
    cssContent: String,
    cssButton: String,
    placement: {
      type: String,
      default: "bottom-center",
      validator: (value) =>
        [
          "top-start",
          "top-center",
          "top-end",
          "bottom-start",
          "bottom-center",
          "bottom-end",
        ].includes(value),
    },
  },
  data() {
    return {
      hiddenContent: false,
    };
  },
  computed: {
    position() {
      const positions = {
        "top-start": "bottom-full left-0 mb-2",
        "top-center": "bottom-full left-1/2 -translate-x-1/2 mb-2",
        "top-end": "bottom-full right-0 mb-2",
        "bottom-start": "top-full left-0 mt-2",
        "bottom-center": "top-full left-1/2 -translate-x-1/2 mt-2",
        "bottom-end": "top-full right-0 mt-2",
      };
      return positions[this.placement];
    },
  },
  methods: {
    onToggleDropdown() {
      if (!this.$refs.content) return;
      this.$refs.content.classList.toggle("hidden");
      this.hiddenContent = !this.$refs.content.classList.contains("hidden");
    },
    closeDropdown(event) {
      if (!this.$refs.content) return;
      if (!this.$el.contains(event.target)) {
        this.$refs.content.classList.add("hidden");
        this.hiddenContent = false;
      }
    },
  },
  mounted() {
    if (!this.disabledListener) {
      document.addEventListener("click", this.closeDropdown);
    }

    // Close dropdown when click dropdown item
    this.$refs.content.addEventListener("click", () => {
      this.hiddenContent = false;
    });
  },
  beforeDestroy() {
    document.removeEventListener("click", this.closeDropdown);
  },
};
</script>
