<template>
  <section
    class="CommunityHomeProfile card flex flex-center py-6 px-2 space-y-2 group"
  >
    <!-- Edit community Pencil Icon -->
    <div
      v-if="permissionObject.isCopAdmin"
      class="hidden group-hover:block clickable absolute right-4 top-4"
      @click="toRouteName('community-admin')"
    >
      <i class="fa fa-pencil fa-xl text-gray-800" aria-hidden="true"></i>
    </div>

    <!-- Edit community Pencil Icon -->
    <div
      class="Profile hover-zoom w-24 h-24 lg:w-40 lg:h-40 flex-center rounded-full border-2 border-gray-300 overflow-hidden"
    >
      <FwbAvatar
        :img="community.profile"
        rounded
        size="md lg:xl object-contain"
      />
    </div>

    <p class="h4 font-bold ellipsis-2 text-center">{{ community.name }}</p>

    <Badge :type="visibilityColor" size="sm" class="mr-0">{{
      visibilityText
    }}</Badge>

    <p v-if="community.description" class="text-center font-semibold">
      {{ community.description }}
    </p>

    <p class="text-gray-600">Members: {{ community.member_count }}</p>
    <p v-if="!isNotCopMember" class="font-semibold">Role: {{ roleText }}</p>
    <p class="text-gray-600">
      Created on: {{ formatDate(community.created_at) }}
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
        v-else-if="permissionObject.userInPendingRequest"
        color="primary"
        text="Waiting admin approval"
        type="button"
        class="text-center"
      />

      <!-- Login - Public -> Join -->
      <LoadingButton
        v-else-if="!community.private"
        @click="joinCop()"
        :isLoading="loadingJoinCop"
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

    <LoadingButton
      v-if="permissionObject.isCopMember"
      @click="leaveCommunity()"
      :isLoading="loadingLeaveCommunity"
      color="danger"
      text="Leave Community"
      type="button"
      class="text-center"
    />
  </section>
</template>

<script>
import CopMemberController from "../../../controllers/CopMemberController";
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
      loadingJoinCop: false,
      requestToJoinText: "Request to join",
      loadingLeaveCommunity: false,
      route: this.$route.params.route,
    };
  },
  computed: {
    visibilityColor() {
      return this.community.private ? "red" : "green";
    },
    visibilityText() {
      return this.community.private ? "Private" : "Public";
    },
    roleText() {
      return this.permissionObject.isCopAdmin ? "Admin" : "Member";
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
    async leaveCommunity() {
      this.loadingLeaveCommunity = true;
      const response = await CopMemberController.leaveCommunity(this.route);
      if (response === true) {
        this.reloadPage();
      }
      this.loadingLeaveCommunity = false;
    },
    async requestToJoinCop() {
      this.loadingRequestToJoin = true;
      const response = await CopMemberController.requestToJoinCop(this.route);
      if (response === true) {
        this.permissionObject.userInPendingRequest = true;
      }
      this.loadingRequestToJoin = false;
    },
    async joinCop() {
      this.loadingJoinCop = true;
      const response = await CopMemberController.joinCop(this.route);
      if (response) {
        this.permissionObject.isCopMember = true;
      }
      this.loadingJoinCop = false;
    },
  },
};
</script>

<style></style>
