<template>
  <section>
    <button
      type="button"
      class="flex text-sm rounded-full md:me-0"
      :id="id"
      aria-expanded="false"
      :data-dropdown-toggle="id2"
      data-dropdown-placement="bottom"
    >
      <slot name="button"> </slot>
    </button>
    <div
      class="z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
      :class="cssContent"
      :id="id2"
    >
      <slot name="content"> </slot>
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
    id2: {
      type: String,
      default: "dropdown-toggle",
    },
    cssContent: String,
  },
};
</script>

<style>
</style>