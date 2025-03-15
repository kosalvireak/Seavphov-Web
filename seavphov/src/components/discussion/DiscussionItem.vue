<template>
  <section
    v-if="discussion.user"
    class="DiscussionItem container-xl rounded-lg p-3 space-y-3 ring-1 ring-gray-300 relative"
  >
    <!-- Discussion header -->
    <a
      :href="`/profile/${discussion.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100"
    >
      <img
        class="sp-logo-md rounded-full mr-2"
        :src="discussion.user[0].picture"
      />

      <div class="flex-col">
        <!-- User Name -->
        <p class="m-0 text-sp-dark">{{ discussion.user[0].name }}</p>

        <!-- Discussion Date -->
        <p class="text-xs text-sp-gray m-0">
          Posted on {{ formatDate(discussion.created_at) }}
        </p>
      </div>
    </a>

    <!-- Discussion delete Button -->
    <DiscussionItemDropdown
      v-if="discussion.delete_able"
      :id="discussion.id"
      @onDelete="onDelete($event)"
      class="absolute right-3 top-0"
    />

    <!-- Discussion Body -->
    <div class="DiscussionBody w-100">
      {{ discussion.body }}
      <span
        v-if="discussion.has_more_text"
        @click="toDiscussionDetail()"
        class="text-gray-400 text-sm italic clickable"
        >...see more</span
      >
    </div>
    <div v-if="discussion.image !== 'null'" class="w-100 max-h-72 flex-center">
      <img :src="discussion.image" class="max-h-64" alt="discussion image" />
    </div>
    <div class="d-flex justify-content-start space-x-2">
      <Reaction
        :entity="discussion"
        likeMethodName="likeDiscussion"
        dislikeMethodName="dislikeDiscussion"
      >
        <div
          class="flex-center w-fit min-w-16 rounded-lg hover:bg-gray-200 mr-auto text-decoration-none"
        >
          <a :href="`/discussion/${discussion.id}`">
            <span
              class="flex-center clickable px-2 py-1 rounded-lg text-md h-100"
              ><i class="fa fa-commenting fa-xl mr-1" aria-hidden="true"> </i>
              {{ discussion.number_of_comments }}
            </span>
          </a>
        </div>
      </Reaction>
    </div>
  </section>
</template>

<script>
import DiscussionItemDropdown from "./DiscussionItemDropdown.vue";
import Reaction from "../common/Reaction.vue";
export default {
  name: "DiscussionItem",
  components: { DiscussionItemDropdown, Reaction },
  props: {
    discussion: Object,
  },
  data() {
    return {
      isDeleting: false,
    };
  },
  methods: {
    onDelete(id) {
      this.$emit("onDelete", id);
    },
  },
};
</script>

<style></style>
