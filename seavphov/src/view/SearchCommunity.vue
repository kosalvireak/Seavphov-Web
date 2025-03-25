<template>
  <section class="Community">
    <HomeNavigation selectedTab="search-community" />
    <div
      class="mt-8 container-xl grid grid-cols-12 w-100 min-h-screen gap-8 w-100"
    >
      <div
        class="Filter w-100 card col-span-12 lg:col-span-3 space-y-4 p-2 !h-fit"
      >
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
              value="all"
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
          <p v-else class="h6">Result: {{ communities?.length }} Community</p>
        </div>
        <button
          @click="toRouteName('create-community')"
          class="bg-sp-primary text-white p-2 rounded-lg"
        >
          Create Community
        </button>
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
            <div
              v-if="total > maxPaginateCop"
              class="d-flex align-items-center justify-content-center pagination h-3rem mt-4"
            >
              <p
                @click="previous()"
                :disabled="isDisabledPrev"
                :class="{ '!cursor-not-allowed': isDisabledPrev }"
              >
                &laquo;
              </p>
              <p
                v-for="page in last_page"
                :key="page"
                :class="[
                  page == current_page ? 'active' : '',
                  { '!cursor-not-allowed': isLoading },
                ]"
                @click="changePage(page)"
              >
                {{ page }}
              </p>
              <p
                @click="next()"
                :disabled="isDisabledNext"
                :class="{ '!cursor-not-allowed': isDisabledNext }"
              >
                &raquo;
              </p>
            </div>
          </div>
          <CommunitySearchEmptyState v-else />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import CommunitySearchEmptyState from "../components/community/CommunitySearchEmptyState.vue";
import { FwbRadio } from "flowbite-vue";
import { MDBInput } from "mdb-vue-ui-kit";
import CommunityItem from "../components/community/CommunityItem.vue";
import CommunityController from "../controllers/CommunityController";
export default {
  name: "SearchCommunity",
  components: { CommunityItem, MDBInput, FwbRadio, CommunitySearchEmptyState },
  data() {
    return {
      name: "",
      visibility: "all",
      communities: [],
      isLoading: false,
      response: null,
      last_page: 5,
      current_page: 1,
      total: 6, // for hide if length less then paginate
    };
  },
  methods: {
    async fetchCommunity(page) {
      this.isLoading = true;
      let params = new URLSearchParams();
      params.append("name", this.name);
      params.append("visibility", this.visibility);
      params.append("page", page);
      this.response =
        await CommunityController.fetchCommunityWithFilter(params); // response is the pagination object
      this.communities = this.response.data;
      this.current_page = this.response.current_page;
      this.last_page = this.response.last_page;
      this.total = this.response.total;
      this.isLoading = false;
    },
    previous() {
      if (this.isDisabledPrev) return;
      this.current_page--;
    },
    next() {
      if (this.isDisabledNext) return;
      this.current_page++;
    },

    changePage(page) {
      this.current_page = page;
    },
  },
  computed: {
    isDisabledNext() {
      return this.current_page == this.last_page;
    },
    isDisabledPrev() {
      return this.current_page == 1;
    },
    isEmpty() {
      return this.communities.length == 0;
    },
  },
  watch: {
    visibility() {
      this.fetchCommunity();
    },
    current_page(newVal) {
      this.fetchCommunity(newVal);
    },
  },
  async mounted() {
    this.fetchCommunity();
  },
};
</script>

<style scoped>
.pagination {
  display: inline-block;
}

.pagination p {
  color: black;
  padding: 0.5rem 1rem;
  text-decoration: none;
  cursor: pointer;
}

.pagination p.active {
  background-color: #5c836e;
  color: white;
  border-radius: 5px;
}

.pagination p:hover:not(.active) {
  background-color: rgba(56, 151, 83, 0.388);
  border-radius: 5px;
}
</style>
