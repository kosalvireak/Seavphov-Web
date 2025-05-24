<template>
  <section class="CommunityHomeMemberList card p-4">
    <p class="h5">Community Members</p>
    <div v-if="isLoading" class="w-100 h-96 flex-center flex-column">
      <Loader :size="30" />
      <p>Fetching community members</p>
    </div>
    <template v-else>
      <div v-for="member in members" :key="member.id" class="flex flex-row">
        <a :href="`/profile/${members.uuid}`" target="_blank" class="clickable">
          <FwbAvatar :img="members.picture" rounded size="md" />
        </a>
        <div>
          <p class="font-bold">{{ member.name }}</p>
          <p class="text-sp-gray">{{ member.role }}</p>
        </div>
      </div>
    </template>
  </section>
</template>

<script>
import CopMemberController from "../../controllers/CopMemberController";
export default {
  name: "CommunityHomeMemberList",
  props: {
    route: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      isLoading: false,
      members: [],
    };
  },
  async mounted() {
    this.isLoading = true;
    this.members = await CopMemberController.getCommunityMembers(this.route);
    this.isLoading = false;
  },
};
</script>

<style>
</style>