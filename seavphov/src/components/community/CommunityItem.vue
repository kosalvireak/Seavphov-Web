<template>
  <section class="CommunityItem card">
    <div class="row container-xl m-0 p-2 relative">
      <router-link
        :to="`/community/${community.route}`"
        class="col-md-3 flex-center bg-success-subtle hover-zoom rounded-7 p-3"
      >
        <img
          :src="community.profile"
          class="w-24 lg:w-40 rounded-full object-contain"
          alt="book_image"
        />
      </router-link>
      <div class="col-md-9">
        <div class="d-flex justify-content-between p-2">
          <div class="space-y-4">
            <h5 class="card-title font-bold truncate-2-lines">
              {{ community.name }}
            </h5>
            <p class="card-text truncate-2-lines text-base">
              {{ community.description }}
            </p>
            <FwbButton :color="buttonColor" class="px-2 text-xs w-fit">{{
              buttonText
            }}</FwbButton>
            <p class="text-gray-400 text-sm">
              <i class="fa fa-info-circle mr-1" aria-hidden="true"></i
              >{{ infoText }}
            </p>
          </div>
          <!-- <MyBookDropdown
            :id="book.id"
            :key="book.id"
            :book="book"
            class="absolute right-4"
            @change="ChangeAvailability()"
          /> -->
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "CommunityItem",
  props: {
    community: Object,
  },
  computed: {
    buttonColor() {
      return this.community.private ? "red" : "green";
    },
    buttonText() {
      return this.community.private ? "Private" : "Public";
    },
    infoText() {
      return this.community.private
        ? "You need to request for approval from community admin"
        : "You can join anytime";
    },
  },
};
</script>

<style>
</style>