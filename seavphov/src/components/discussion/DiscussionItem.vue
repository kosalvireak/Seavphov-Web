<template>
  <section
    v-if="localDiscussion.user"
    class="DiscussionItem container-xl rounded-lg p-2 space-y-3 ring-1 ring-gray-300 relative"
  >
    <!-- Discussion header -->
    <a
      :href="`/profile/${localDiscussion.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100 space-x-2"
    >
      <FwbAvatar :img="localDiscussion.user[0].picture" rounded size="md" />

      <div class="flex-col">
        <!-- User Name -->
        <p class="m-0 text-sp-dark">{{ localDiscussion.user[0].name }}</p>

        <!-- Discussion Date -->
        <p class="text-xs text-sp-gray m-0">
          Posted on {{ formatDate(localDiscussion.created_at) }}
        </p>
      </div>
    </a>

    <EditDiscussionPopup
      v-if="isEditing"
      :discussionProp="localDiscussion"
      @on-close="isEditing = false"
      @on-done-edit="UpdateDiscussion"
    />

    <!-- Discussion delete Button -->
    <DiscussionItemDropdown
      v-if="localDiscussion.delete_able"
      :id="localDiscussion.id"
      @on-delete-discussion="$emit('onDeleteDiscussion', $event)"
      @on-edit-discussion="editDiscussion()"
      class="absolute right-3 top-0"
    />

    <!-- Discussion Body -->
    <div class="DiscussionBody w-100">
      {{ localDiscussion.body }}
      <span
        v-if="localDiscussion.has_more_text"
        @click="toDiscussionDetail()"
        class="text-gray-400 text-sm italic clickable"
        >...see more</span
      >
    </div>
    <div
      v-if="inValidProperty(localDiscussion, 'image')"
      class="w-100 h-100 max-h-96 flex-center"
    >
      <img
        :src="localDiscussion.image"
        class="max-h-96"
        alt="discussion image"
      />
    </div>
    <div class="d-flex justify-content-start space-x-2">
      <Reaction
        :entity="localDiscussion"
        likeMethodName="likeDiscussion"
        dislikeMethodName="dislikeDiscussion"
      >
        <div
          class="flex-center w-fit min-w-16 rounded-lg hover:bg-gray-200 mr-auto text-decoration-none"
        >
          <a :href="`/discussion/${localDiscussion.id}`">
            <span
              class="flex-center clickable px-2 py-1 rounded-lg text-md h-100"
              ><i class="fa fa-commenting fa-xl mr-1" aria-hidden="true"> </i>
              {{ localDiscussion.number_of_comments }}
            </span>
          </a>
        </div>
      </Reaction>
    </div>
  </section>
</template>

<script>
import DiscussionItemDropdown from "./DiscussionItemDropdown.vue";
import EditDiscussionPopup from "./EditDiscussionPopup.vue";
import Reaction from "../common/Reaction.vue";
export default {
  name: "DiscussionItem",
  components: { DiscussionItemDropdown, Reaction, EditDiscussionPopup },
  props: {
    discussion: Object,
  },
  data() {
    return {
      isEditing: false,
      localDiscussion: this.discussion,
    };
  },
  methods: {
    toDiscussionDetail() {
      this.toRouteName("discussion-detail", this.localDiscussion.id);
    },
    editDiscussion() {
      this.isEditing = true;
    },
    UpdateDiscussion(discussion) {
      this.localDiscussion = discussion;
    },
  },
};
</script>

<style></style>
