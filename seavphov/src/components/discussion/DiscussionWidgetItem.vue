<template>
  <a v-if="discussion.user" :href="`/discussion/${discussion.id}`">
    <section
      class="DiscussionWidgetItem clickable container-xl rounded-lg p-2 space-y-3 ring-1 ring-gray-300 relative"
    >
      <!-- Discussion header -->
      <div
        class="d-flex justify-content-start align-items-center w-100 space-x-2"
      >
        <FwbAvatar :img="discussion.user[0].picture" rounded size="md" />

        <div class="flex-col">
          <!-- User Name -->
          <p class="m-0 text-sp-dark">{{ discussion.user[0].name }}</p>

          <!-- Discussion Date -->
          <p class="text-xs text-sp-gray m-0">
            Posted on {{ formatDate(discussion.created_at) }}
          </p>
        </div>
      </div>

      <!-- Discussion Body -->
      <div class="DiscussionBody w-100 text-decoration-none">
        {{ discussion.body }}
        <span
          v-if="discussion.has_more_text"
          @click="toDiscussionDetail()"
          class="text-gray-400 text-sm italic clickable"
          >...see more</span
        >
      </div>
      <div
        v-if="inValidProperty(discussion, 'image')"
        class="w-100 max-h-44 flex-center"
      >
        <img :src="discussion.image" class="max-h-44" alt="discussion image" />
      </div>
    </section>
  </a>
</template>

<script>
export default {
  name: "DiscussionWidgetItem",
  props: {
    discussion: Object,
  },
};
</script>

<style scoped></style>
