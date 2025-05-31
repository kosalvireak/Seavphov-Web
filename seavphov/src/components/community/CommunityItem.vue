<template>
  <section class="CommunityItem container-xl card">
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
          <p class="h4 font-bold ellipsis-2 mb-0 text-center">
            {{ community.name }}
          </p>
        </router-link>

        <Badge :type="visibilityColor" size="sm" class="mr-0">{{
          visibilityText
        }}</Badge>

        <p v-if="community.description" class="ellipsis-2 text-center">
          {{ community.description }}
        </p>

        <p>
          {{ community.members_count
          }}<span class="pl-1">{{ memberText }}</span>
        </p>

        <Info :text="infoText" :margin="false" :center="true" />
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "CommunityItem",
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
    infoText() {
      return this.community.private
        ? "You need to request for approval from community admin"
        : "You can join anytime";
    },
  },
};
</script>

<style></style>
