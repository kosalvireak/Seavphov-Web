<template>
  <section class="Community">
    <HomeNavigation selectedTab="community" />
    <div class="mt-8 container-xl grid grid-cols-12 w-100 min-h-screen gap-8">
      <div class="Filter card col-span-12 lg:col-span-3 space-y-4 p-2 !h-fit">
        <p class="h4">Search & Filter</p>
        <form
          class="w-100 p-0 rounded-lg d-flex flex-col space-y-4"
          v-on:submit.prevent="fetchCommunity()"
        >
          <div class="d-flex flex-row">
            <MDBInput
              type="text"
              label="Search community"
              id="name"
              v-model="name"
              wrapperClass="bg-white h-3rem w-100"
            />
            <button
              type="submit"
              class="w-20 p-2.5 text-sm font-medium text-white bg-seavphov rounded border"
            >
              <i class="fa fa-magnifying-glass"></i>
            </button>
          </div>
          <div>
            <p class="h6">Visibility</p>
            <FwbRadio
              class="clickable"
              label="All"
              name="all"
              v-model="visibility"
              value="null"
            />
            <FwbRadio
              class="clickable"
              label="Private"
              name="private"
              v-model="visibility"
              value="private"
            />
            <FwbRadio
              class="clickable"
              label="Public"
              name="public"
              v-model="visibility"
              value="public"
            />
          </div>
        </form>
        <div class="d-flex align-items-center justify-content-end">
          <p v-if="isLoading" class="h6">Fetching...</p>
          <p v-else class="h6">Result: {{ communities.length }} Community</p>
        </div>
      </div>
      <div class="Content col-span-12 lg:col-span-9">
        <div v-if="isLoading" class="w-100 h-100 flex-center flex-row">
          <Loader :size="40" />
        </div>
        <div v-else>
          <div v-if="!isEmpty" class="space-y-8">
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
    </div>
  </section>
</template>

<script>
import { FwbRadio } from "flowbite-vue";
import { MDBInput } from "mdb-vue-ui-kit";
import CommunityItem from "../components/community/CommunityItem.vue";
import CommunityController from "../controllers/CommunityController";
export default {
  name: "Community",
  components: { CommunityItem, MDBInput, FwbRadio },
  data() {
    return {
      name: "",
      visibility: null,
      communities: [],
      isLoading: false,
    };
  },
  methods: {
    async fetchCommunity() {
      this.isLoading = true;
      let params = new URLSearchParams();
      params.append("name", this.name);
      params.append("visibility", this.visibility);
      const response = await CommunityController.fetchCommunityWithFilter(
        params
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
  watch: {
    visibility: {
      immediate: true,
      handler() {
        this.fetchCommunity();
      },
    },
  },
  async mounted() {
    this.fetchCommunity();
  },
};
</script>

<style></style>
