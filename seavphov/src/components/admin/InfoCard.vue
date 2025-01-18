<template>
  <fwb-card @click="toRouteName(routeName)" class="clickable w-44 h-40">
    <div class="p-4">
      <h5
        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
      >
        {{ title }}
      </h5>
      <p class="text-2xl text-gray-700 dark:text-gray-400 mb-0">
        <i :class="icon" class="mr-2" aria-hidden="true"></i>
        {{ number }}
      </p>
    </div>
  </fwb-card>
</template>

<script>
import { FwbCard } from "flowbite-vue";
export default {
  name: "DataBanner",
  components: { FwbCard },
  props: {
    title: String,
    number: Number,
    icon: String,
    routeName: String,
  },
};
</script>

<style>
.DataBanner {
  width: 18rem;
  height: 9rem;
  background-color: white;
}
</style>
