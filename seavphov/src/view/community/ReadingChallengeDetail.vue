<template>
  <section class="ReadingChallengeDetail container-xl">
    <div v-if="isLoading" class="h-96 w-100 flex-center">
      <Loader :size="40" />
    </div>
    <template v-else>
      <div class="grid grid-cols-12 gap-4 h-100">
        <div
          class="hover-zoom col-span-12 lg:col-span-4 align-content-center justify-items-center ring-1 ring-gray-300 rounded-2"
        >
          <img
            :src="challenge.book_image"
            class="sp-img-lg object-contain"
            alt="book cover"
          />
        </div>
        <div class="col-span-12 lg:col-span-8 relative">
          <div class="ChallengeInfo flex flex-column space-y-4">
            <p class="h4">{{ challenge.book_title }}</p>
            <p class="h5">By: {{ challenge.book_author }}</p>
            <p><b>Description:</b>{{ challenge.description }}</p>

            <p>
              <b> Schedule:</b> {{ formatDate(challenge.start_date) }}
              <b> to</b>
              {{ formatDate(challenge.end_date) }}
            </p>

            <p>
              <b class="pr-1">Remaining days:</b>
              <span :class="isOverDue() ? 'text-red-500 font-bold' : ''">
                {{ getRemainingDateDisplay() }}
              </span>
            </p>

            <p><b>Challenge Owner:</b></p>
            <router-link
              v-if="challenge.owner"
              :to="`/profile/${challenge.owner[0].uuid}`"
              class="bg-gray-100 rounded-pill w-fit p-2"
            >
              <div class="flex-center space-x-2">
                <FwbAvatar
                  :img="challenge.owner[0].picture"
                  rounded
                  size="md"
                />
                <p>{{ challenge.owner[0].name }}</p>
              </div>
            </router-link>

            <p><b>Total members:</b> {{ challenge.total_member }}</p>
          </div>
        </div>
      </div>
      <div class="MemberInfo mt-4">
        <StartChallengeWidget />
      </div>
    </template>
  </section>
</template>

<script>
import StartChallengeWidget from "../../components/community/challenge/StartChallengeWidget.vue";
import ReadingChallengeController from "../../controllers/ReadingChallengeController";
export default {
  name: "ReadingChallengeDetail",
  components: { StartChallengeWidget },
  data() {
    return {
      route: this.$route.params.route,
      id: this.$route.params.id,
      challenge: {},
      isLoading: false,
    };
  },
  computed: {},
  async mounted() {
    this.isLoading = true;
    this.challenge = await ReadingChallengeController.getReadingChallenge(
      this.route,
      this.id
    );
    this.isLoading = false;
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

<style scoped>
p {
  margin: 0;
}
</style>