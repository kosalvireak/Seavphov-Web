<template>
  <section
    class="DiscussionItem container rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Discussion header -->
     
    <a
      :href="`/profile/${data.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100"
    >
      <img class="sp-logo-md rounded-full m-2" :src="data.user[0].picture" />

      <div class="flex-col mt-3">
        <!-- User Name -->
        <p class="m-0 text-sp-dark">{{ data.user[0].name }}</p>

        <!-- Discussion Date -->
        <p class="text-xs text-sp-gray">
        posted on {{ formatDate(data.created_at) }}
      </p>
      </div>
    </a>
    

    <!-- Discussion delete Button -->
    <FwbButton
      v-if="data.delete_able"
      color="red"
      class="absolute right-2 top-0"
      >Delete</FwbButton
    >

    <!-- Discussion Body -->
    <div class="w-100 py-2">
      {{ data.body }}
    </div>
    <div class="w-100 max-h-72 border border-gray-100 rounded-lg flex-center">
      <img :src="data.image" class="max-h-64" alt="discussion image" />
    </div>
    <div class="d-flex justify-content-start space-x-2">
      <div class="flex-center w-fit min-w-16 ring-1 ring-gray-300 rounded-lg">
        <Loader v-if="isLoadingDislike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="voteNotHelpful(review.id)"
        >
          Not Helpful: {{ data.not_helpful_vote }}
        </span>
      </div>
      <div class="flex-center w-fit min-w-16 ring-1 ring-gray-300 rounded-lg">
        <Loader v-if="isLoadingLike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="voteHelpful(review.id)"
        >
          Helpful:
          {{ data.helpful_vote }}
        </span>
      </div>
      <div
        class="flex-center w-fit min-w-16 ring-1 ring-gray-300 rounded-lg hover:bg-gray-200"
      >
        <span
          class="clickable px-2 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="voteHelpful(review.id)"
          ><i class="fa fa-commenting" aria-hidden="true"> </i>:
          {{ data.number_of_comments }}
        </span>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "DiscussionItem",
  props: {
    data: Object,
  },
  // {
  //   "id": 1,
  //   "user": [
  //     {
  //       "name": "Kosal Vireak1",
  //       "picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2F1268992.jpg?alt=media&token=c863c8cd-f68c-4a87-b345-0e0014e29240",
  //       "uuid": "lSZWwmr5L9OvD8v3Xh95YMPRfAPjzo"
  //     }
  //   ],
  //   "body": "Good Logo yet?",
  //   "number_of_comments": 0,
  //   "helpful_vote": 0,
  //   "not_helpful_vote": 0,
  //   "delete_able": false,
  //   "created_at": "2025-01-15T16:25:20.000000Z"
  // }
};
</script>

<style></style>
