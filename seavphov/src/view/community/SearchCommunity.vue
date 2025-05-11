<template>
  <section class="Community">
    <HomeNavigation selectedTab="search-community" />
    <div
      class="Search-Community-Container mt-8 grid grid-cols-12 w-100 min-h-screen gap-8 w-100"
    >
      <div
        class="Filter w-100 card col-span-12 md:col-span-3 space-y-4 p-2 !h-fit"
      >
        <p class="h4">Search & Filter</p>
        <form
          class="Search-Form w-100 p-0 rounded-lg d-flex flex-col space-y-4"
          v-on:submit.prevent="searchCommunity()"
        >
          <FwbInput
            v-model="name"
            placeholder="Search community"
            size="md"
            class="w-100"
            wrapper-class="w-100"
          >
            <template #prefix>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                />
              </svg>
            </template>
            <template #suffix>
              <LoadingButton class="my-2">Search</LoadingButton>
            </template>
          </FwbInput>
          <div class="visibility-filter">
            <p class="h6 mb-0">Visibility</p>
            <FwbRadio
              class="clickable"
              label="All"
              name="visibility-all"
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
          <div v-if="isLogin" class="role-filter">
            <p class="h6 mb-0">Role</p>
            <FwbRadio
              class="clickable"
              label="All"
              name="all"
              v-model="role"
              value="all"
            />
            <FwbRadio
              class="clickable"
              label="Admin"
              name="admin"
              v-model="role"
              value="admin"
            />
            <FwbRadio
              class="clickable"
              label="Member"
              name="member"
              v-model="role"
              value="member"
            />
          </div>
        </form>
        <div class="flex-center !justify-between h-12">
          <div>
            <p v-if="isLoading" class="h6 mb-0">Fetching...</p>
            <p v-else class="h6 mb-0">Total: {{ total }} Communities</p>
          </div>

          <FwbButton
            v-if="!isDefaultFilter"
            @click="resetFilter()"
            color="yellow"
            >Reset</FwbButton
          >
        </div>
        <LoadingButton
          @click="toRouteName('create-community')"
          class="rounded-lg"
        >
          Create Community
        </LoadingButton>
      </div>

      <div class="Content col-span-12 md:col-span-9">
        <div v-if="isLoading" class="w-100 h-100 flex-center flex-row">
          <Loader :size="40" />
        </div>
        <div v-else>
          <SearchEmptyState v-if="isEmpty" text="community" />
          <div v-else class="space-y-8">
            <CommunityItem
              v-for="cop in communities"
              :key="cop.id"
              :community="cop"
            />
            <div
              v-if="total > maxPaginateCop"
              class="d-flex align-items-center justify-content-center pagination h-3rem mt-4"
            >
              <button
                @click="previous()"
                :disabled="isDisabledPrev"
                :class="{ '!cursor-not-allowed': isDisabledPrev }"
              >
                &laquo;
              </button>
              <button
                v-for="page in last_page"
                :key="page"
                :class="[
                  page == current_page ? 'active' : '',
                  { '!cursor-not-allowed': isLoading },
                ]"
                @click="changePage(page)"
              >
                {{ page }}
              </button>
              <button
                @click="next()"
                :disabled="isDisabledNext"
                :class="{ '!cursor-not-allowed': isDisabledNext }"
              >
                &raquo;
              </button>
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
import CommunityItem from "../../components/community/CommunityItem.vue";
import CommunityController from "../../controllers/CommunityController";
export default {
  name: "SearchCommunity",
  components: { CommunityItem, MDBInput, FwbRadio },
  data() {
    return {
      maxPaginateCop: Seavphov.maxPaginateCop,
      name: "",
      visibility: "all",
      role: "all",
      communities: [],
      isLoading: false,
      last_page: 5,
      current_page: 1,
      total: 0, // for hide if length less then paginate
    };
  },
  methods: {
    async searchCommunity(page) {
      this.isLoading = true;
      let params = new URLSearchParams();
      params.append("name", this.name);
      params.append("visibility", this.visibility);
      params.append("role", this.role);
      params.append("page", page);
      const response = await CommunityController.searchCommunity(params); // response is the pagination object
      if (response) {
        this.communities = response.data;
        this.current_page = response.current_page;
        this.last_page = response.last_page;
        this.total = response.total;
      }
      this.isLoading = false;
    },
    resetFilter() {
      this.name = "";
      this.visibility = "all";
      this.role = "all";
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
    isDefaultFilter() {
      return this.name == "" && this.visibility == "all" && this.role == "all";
    },
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
      this.searchCommunity();
    },
    role() {
      this.searchCommunity();
    },
    current_page(newVal) {
      this.searchCommunity(newVal);
    },
  },
  async mounted() {
    await this.searchCommunity();
  },
};
</script>

<style scoped>
.Search-Form > div {
  width: 100%;
}
</style>
