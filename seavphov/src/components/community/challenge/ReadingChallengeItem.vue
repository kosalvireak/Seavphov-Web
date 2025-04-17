<template>
  <section class="ReadingChallengeItem container-xl card p-4">
    <p class="h4">{{ challenge.book_title }}</p>
    <p class="h5">By: {{ challenge.book_author }}</p>
    <div class="flex flex-col md:flex-row gap-4">
      <div
        class="w-full md:w-1/3 flex-center book-info hover-zoom bg-gray-100 rounded-lg"
      >
        <div
          class="flex-center sp-img-md clickable"
          @click="toRouteName('reading-challenge-detail', challenge.id)"
        >
          <img
            :src="challenge.book_image"
            alt=""
            class="img-fluid object-cover"
          />
        </div>
      </div>
      <div class="w-full md:w-2/3 h-full member-progress">
        <div class="flex flex-col space-y-2">
          <p>{{ challenge.description }}</p>
          <p>
            <b> Schedule:</b> {{ formatDate(challenge.start_date) }} <b> to</b>
            {{ formatDate(challenge.end_date) }}
          </p>

          <p>
            <b class="pr-1">Remaining days:</b>
            <span :class="isOverDue() ? 'text-red-500 font-bold' : ''">
              {{ getRemainingDateDisplay() }}
            </span>
          </p>

          <p><b>Total members:</b> {{ challenge.total_member }}</p>
          <p><b>Challenge Owner:</b></p>
          <!-- <ReadingMemberList /> -->
          <router-link
            :to="`/profile/${challenge.owner[0].uuid}`"
            class="bg-gray-100 rounded-pill w-fit p-2"
          >
            <div class="flex-center space-x-2">
              <FwbAvatar :img="challenge.owner[0].picture" rounded size="md" />
              <p>{{ challenge.owner[0].name }}</p>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import ReadingMemberList from "./ReadingMemberList.vue";
export default {
  components: { ReadingMemberList },
  name: "ReadingChallengeItem",
  props: {
    challenge: Object,
    required: true,
  },
  data() {
    return {};
  },
  methods: {
    isOverDue() {
      return this.getFutureDifferentDays(this.challenge.end_date) < 0;
    },
    getRemainingDateDisplay() {
      const different = this.getFutureDifferentDays(this.challenge.end_date);
      if (different < 0) {
        return "Expired";
      } else if (different == 0) {
        return "Today";
      } else {
        return Math.floor(different) + " days left";
      }
    },
  },
};
</script>

<style>
</style>