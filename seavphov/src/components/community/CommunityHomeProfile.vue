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

    <!-- Not member or Admin
      - Login 
        - Public -> Join
        - Private -> Request to join
      - Not Login
        - Public and Private -> Login to join
    -->
    <div v-if="isNotCopMember">
      <!-- - Not Login - Public or Private -> Login to join -->
      <LoadingButton
        v-if="!isLogin"
        @click="loginToJoin()"
        color="primary"
        text="Login to Join"
        type="button"
        class="text-center"
      />

      <!-- Login waiting for approval -->
      <LoadingButton
        v-else-if="permissionObject.isPendingRequest"
        color="primary"
        text="Waiting admin approval"
        type="button"
        class="text-center"
      />

      <!-- Login - Public -> Join -->
      <LoadingButton
        v-else-if="!community.private"
        @click="join()"
        color="primary"
        text="Join"
        type="button"
        class="text-center"
      />

      <!-- Login - Private -> Request to join -->
      <LoadingButton
        v-else
        @click="requestToJoinCop()"
        :isLoading="loadingRequestToJoin"
        color="primary"
        :text="requestToJoinText"
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
import CopMemberController from "../../controllers/CopMemberController";
export default {
  name: "CommunityHomeProfile",
  props: {
    permissionObject: {
      type: Object,
      required: true,
    },
    community: Object,
  },
  data() {
    return {
      loadingRequestToJoin: false,
      requestToJoinText: "Request to join",
    };
  },
  computed: {
    visibilityColor() {
      return this.community.private ? "red" : "green";
    },
    visibilityText() {
      return this.community.private ? "Private" : "Public";
    },
    isNotCopMember() {
      return !(
        this.permissionObject.isCopMember || this.permissionObject.isCopAdmin
      );
    },
  },
  methods: {
    loginToJoin() {
      this.toRouteName("login");
    },
    async requestToJoinCop() {
      this.loadingRequestToJoin = true;

      const data = await CopMemberController.requestToJoinCop(
        this.$route.params.route
      );

      if (data.success) {
        this.$toast.success(data.message);
        this.permissionObject.isPendingRequest = true;
      }

      this.loadingRequestToJoin = false;
    },
    join() {
      console.log("join");
    },
  },
};
</script>

<style>
</style>