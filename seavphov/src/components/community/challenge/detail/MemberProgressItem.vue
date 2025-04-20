<template>
  <section class="MemberProgressItem card" :class="cardBackground()">
    <div class="flex align-items-center p-2 rounded-lg space-x-2">
      <p class="h5">{{ index + 1 }}</p>
      <a
        :href="`/profile/${member.uuid}`"
        target="_blank"
        class="clickable w-100"
      >
        <div class="flex w-full space-x-4">
          <FwbAvatar :img="member.picture" rounded size="lg" />
          <Progress
            class="w-full"
            :label="member.name"
            :progress="member.progress"
            label-position="outside"
            label-progress
            size="lg"
          />
        </div>
      </a>
    </div>
  </section>
</template>

<script>
export default {
  name: "MemberProgressItem",
  props: {
    member: {
      type: Object,
      required: true,
    },
    index: {
      type: Number,
      required: true,
    },
  },
  methods: {
    cardBackground() {
      switch (this.index) {
        case 0:
          return "bg-yellow-300";
        case 1:
          return "bg-zinc-300";
        case 2:
          return "bg-orange-700";
        default:
          return "bg-gray-300";
      }
    },
  },
};
</script>

<style>
</style>