<template>
  <section class="CommunityHomeMemberList card p-2">
    <FwbAccordion>
      <FwbAccordionPanel>
        <FwbAccordionHeader class="p-1 border-0 bg-white"
          ><p class="h5 mb-0">Community Members</p>
        </FwbAccordionHeader>
        <FwbAccordionContent class="p-1 border-0">
          <div v-if="isLoading" class="w-100 h-44 flex-center flex-column">
            <Loader :size="30" />
          </div>
          <template v-else>
            <a
              v-for="member in members"
              :key="member.id"
              :href="`/profile/${member.uuid}`"
              target="_blank"
              z
              class="clickable flex flex-row space-x-2 hover:bg-gray-200 rounded p-2"
            >
              <FwbAvatar :img="member.picture" rounded size="md" />
              <div>
                <p class="font-bold ellipsis-1">{{ member.name }}</p>
                <p class="text-sp-gray text-sm">{{ member.role }}</p>
              </div>
            </a>
          </template>
        </FwbAccordionContent></FwbAccordionPanel
      >
    </FwbAccordion>
  </section>
</template>

<script>
import {
  FwbAccordion,
  FwbAccordionContent,
  FwbAccordionHeader,
  FwbAccordionPanel,
} from "flowbite-vue";
import CopMemberController from "../../controllers/CopMemberController";
export default {
  name: "CommunityHomeMemberList",
  components: {
    FwbAccordionPanel,
    FwbAccordionHeader,
    FwbAccordionContent,
    FwbAccordion,
  },
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
    this.members = await CopMemberController.getHomeCommunityMembersList(
      this.route,
    );
    this.isLoading = false;
  },
};
</script>

<style></style>
