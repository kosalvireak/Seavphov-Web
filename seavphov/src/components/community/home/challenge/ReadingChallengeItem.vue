<template>
  <section class="ReadingChallengeItem container-xl card p-4">
    <p class="h4">{{ item.book_title }}</p>
    <p class="h5">By: {{ item.book_author }}</p>
    <div class="flex flex-col md:flex-row gap-4">
      <div
        class="w-full md:w-1/3 flex-center book-info hover-zoom bg-gray-100 rounded-lg"
      >
        <div
          class="flex-center sp-img-md clickable"
          @click="toRouteName('reading-challenge-detail', item.id)"
        >
          <img :src="item.book_image" alt="" class="img-fluid object-cover" />
        </div>
      </div>
      <div class="w-full md:w-2/3 h-full member-progress">
        <div class="flex flex-col space-y-2">
          <p>{{ item.description }}</p>
          <p>
            <b> Schedule:</b> {{ formatDate(item.start_date) }} <b> to</b>
            {{ formatDate(item.end_date) }}
          </p>

          <p>
            <b class="pr-1">Remaining days:</b>
            <span :class="isOverDue() ? 'text-red-500 font-bold' : ''">
              {{ getRemainingDateDisplay() }}
            </span>
          </p>

          <p><b>Total members:</b> {{ item.total_member }}</p>
          <p><b>Challenge Owner:</b> Kosalvireak</p>
          <!-- <ReadingMemberList /> -->
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
    item: Object,
    required: true,
  },
  data() {
    return {};
  },
  methods: {
    isOverDue() {
      return this.getFutureDifferentDays(this.item.end_date) < 0;
    },

    getRemainingDateDisplay() {
      const different = this.getFutureDifferentDays(this.item.end_date);
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