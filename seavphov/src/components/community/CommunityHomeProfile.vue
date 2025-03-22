<template>
  <section
    class="ProfileInfo card col-span-12 lg:col-span-3 flex flex-center py-6 space-y-2"
  >
    <div
      class="Profile hover-zoom w-24 h-24 lg:w-40 lg:h-40 flex-center rounded-full border-2 border-gray-300 overflow-hidden"
    >
      <img
        :src="community.profile"
        class="w-full h-full object-cover"
        alt="profile"
      />
    </div>

    <p class="h4 font-bold truncate-2-lines">{{ community.name }}</p>

    <p v-if="community.description" class="truncate-2-lines">
      {{ community.description }}
    </p>

    <div v-if="!permissionObject.isCopMember">
      <LoadingButton
        v-if="isLogin"
        @click="onClickRequestToJoin()"
        color="primary"
        text="Request to Join"
        type="button"
        class="text-center"
      />
      <LoadingButton
        v-else
        @click="onClickLoginToJoin()"
        color="primary"
        text="Login to Join"
        type="button"
        class="text-center"
      />
    </div>

    <FwbButton :color="visibilityColor" class="px-2 text-xs">{{
      visibilityText
    }}</FwbButton>

    <p>Created on: {{ formatDate(community.created_at) }}</p>
  </section>
</template>

<script>
export default {
  name: "CommunityHomeProfile",
  props: {
    permissionObject: {
      type: Object,
      required: true,
    },
    community: Object,
  },
  computed: {
    visibilityColor() {
      return this.community.private ? "red" : "green";
    },
    visibilityText() {
      return this.community.private ? "Private" : "Public";
    },
  },
  methods: {
    onClickLoginToJoin() {
      console.log("onClickLoginToJoin");
      this.toRouteName("login");
    },
    onClickRequestToJoin() {
      console.log("onClickRequestToJoin");
    },
  },
};
</script>

<style>
</style>