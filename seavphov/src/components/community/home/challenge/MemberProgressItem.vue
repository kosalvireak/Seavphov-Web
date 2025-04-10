<template>
  <section class="MemberProgressItem w-full">
    <div class="flex w-full space-x-2">
      <a :href="`/profile/${item.uuid}`" target="_blank" class="clickable">
        <FwbAvatar :img="item.profile" rounded size="md" />
      </a>
      <FwbProgress
        class="w-full"
        :label="item.name"
        :progress="item.progress"
        label-position="outside"
        label-progress
        size="md"
      />
    </div>
  </section>
</template>

<script>
import { FwbProgress } from "flowbite-vue";
export default {
  name: "MemberProgressItem",
  components: { FwbProgress },
  data() {
    return {
      item: {
        profile:
          "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2Fseavphov_logo.png?alt=media&token=550a1b65-e64b-4b88-8663-d65ec49c4813",
        uuid: "12",
        name: "Seavphov",
        progress: 50,
      },
    };
  },
};
</script>

<style>
</style>