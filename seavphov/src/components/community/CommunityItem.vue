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
        <p class="h4 font-bold truncate-2-lines mb-0">
          {{ community.name }}
        </p>

        <p v-if="community.description" class="truncate-2-lines">
          Description: {{ community.description }}
        </p>

        <FwbButton :color="visibilityColor" class="px-2 text-xs">{{
          visibilityText
        }}</FwbButton>

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
    infoText() {
      return this.community.private
        ? "You need to request for approval from community admin"
        : "You can join anytime";
    },
  },
};
</script>

<style></style>
