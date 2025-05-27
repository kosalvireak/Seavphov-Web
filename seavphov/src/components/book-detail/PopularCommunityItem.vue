<template>
  <section class="CommunityItem col-span-12 md:col-span-6 card">
    <div class="m-0 p-2 relative flex flex-col lg:flex-row">
      <div class="flex-shrink-0 flex-center">
        <router-link
          :to="`/community/${community.route}`"
          class="flex-center bg-success-subtle hover-zoom p-3"
        >
          <FwbAvatar :img="community.profile" rounded size="xl" />
        </router-link>
      </div>

      <div
        class="flex-grow-1 flex-center lg:items-start flex-col p-2 space-y-2"
      >
        <router-link :to="`/community/${community.route}`">
          <p class="h4 font-bold ellipsis-2 mb-0">
            {{ community.name }}
          </p>
        </router-link>

        <Badge :type="visibilityColor" size="sm" class="mr-0">{{
          visibilityText
        }}</Badge>

        <p v-if="community.description" class="ellipsis-2">
          {{ community.description }}
        </p>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "PopularCommunityItem",
  props: {
    community: Object,
  },
  computed: {
    visibilityColor() {
      return this.community.private ? "red" : "green";
    },
    visibilityText() {
      return this.community.private ? "Private" : "Public";
    },
    memberText() {
      return this.community.me > 1 ? "member" : "members";
    },
  },
};
</script>

<style></style>
