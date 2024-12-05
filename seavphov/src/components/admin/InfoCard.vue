<template>
  <fwb-card href="#">
    <div class="p-5">
      <h5
        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
      >
        {{ title }}
      </h5>
      <p class="font-normal text-gray-700 dark:text-gray-400">
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