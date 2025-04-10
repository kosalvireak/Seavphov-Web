<template>
  <section class="ReadingChallengeItem container-xl card p-4">
    <p class="h4">{{ item.book_title }}</p>
    <p class="h5">By: {{ item.book_author }}</p>
    <div class="flex flex-col md:flex-row gap-4">
      <div
        class="w-full md:w-1/3 flex-center book-info hover-zoom bg-gray-100 rounded-lg"
      >
        <div class="flex-center sp-img-md">
          <img :src="item.book_image" alt="" class="img-fluid object-cover" />
        </div>
      </div>
      <div class="w-full md:w-2/3 h-full member-progress">
        <div class="flex flex-col space-y-2">
          <p>{{ item.description }}</p>
          <p>Schedule: {{ item.start_date }} -> {{ item.end_date }}</p>
          <p>Total members: {{ item.total_member }}</p>
          <ReadingMemberList />
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
};
</script>

<style>
</style>