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
          <div class="space-y-2">
            <p class="h4 font-bold truncate-2-lines">
              {{ community.name }}
            </p>

            <p v-if="community.description" class="truncate-2-lines">
              {{ community.description }}
            </p>

            <FwbButton :color="buttonColor" class="px-2 text-xs">{{
              buttonText
            }}</FwbButton>

            <Info :text="infoText" />
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

<style></style>
