<template>
  <section
    class="Community container grid grid-cols-12 w-100 space-y-8 space-x-8 min-h-screen"
  >
    <div class="Filter card col-span-12 lg:col-span-3 mt-8 space-y-4 p-2">
      <p class="text-2xl font-bold">Search & Filter</p>
      <form
        class="w-100 p-0 rounded-lg d-flex flex-row"
        v-on:submit.prevent="fetchCommunity()"
      >
        <MDBInput
          type="text"
          label="Search community"
          id="name"
          v-model="name"
          wrapperClass="bg-white h-3rem w-100"
        />
        <button
          type="submit"
          class="w-20 p-2.5 text-sm font-medium h-full text-white bg-seavphov rounded border"
        >
          <i class="fa fa-magnifying-glass"></i>
        </button>
      </form>
    </div>
    <div class="Content col-span-12 lg:col-span-9">
      <div v-if="isLoading" class="w-100 h-100 flex-center flex-row">
        <Loader :size="40" />
      </div>
      <div v-else>
        <div v-if="!isEmpty" class="space-y-8">
          <div
            class="d-flex align-items-center justify-content-end"
            style="height: 40px"
          >
            <h6 class="p-0 m-0 fw-bold font-75">
              Result: {{ communities.length }} Community
            </h6>
          </div>
          <CommunityItem
            v-for="cop in communities"
            :key="cop.id"
            :community="cop"
          />
        </div>
        <div v-else class="h-full w-100">
          <div
            class="h-auto d-flex flex-column justify-content-center align-items-center m-5"
          >
            <img
              src="/img/notfound.png"
              alt="not found"
              class="w-25 img-fluid mb-3 rounded rounded-7"
            />
            <h3>No community found...!</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
import CommunityItem from "../components/community/CommunityItem.vue";
import CommunityController from "../controllers/CommunityController";
export default {
  name: "Community",
  components: { CommunityItem, MDBInput },
  data() {
    return {
      name: "",
      private: null,
      communities: [],
      isLoading: false,
    };
  },
  methods: {
    async fetchCommunity() {
      this.isLoading = true;
      let formData = {
        name: this.name,
        private: this.private,
      };
      const response = await CommunityController.fetchCommunityWithFilter(
        formData
      ); // response is the pagination object
      this.communities = response.data;
      this.isLoading = false;
    },
  },
  computed: {
    isEmpty() {
      return this.communities.length == 0;
    },
  },
};
</script>

<style>
</style>