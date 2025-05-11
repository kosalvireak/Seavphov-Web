fix
<template>
  <div class="SearchResult container-xl w-100 h-100 mb-auto">
    <HomeNavigation />
    <div
      class="Search-Book-Container mt-8 grid grid-cols-12 w-100 min-h-screen gap-8 w-100"
    >
      <div
        class="Filter w-100 card col-span-12 md:col-span-3 space-y-4 p-2 !h-fit"
      >
        <p class="h4">Search & Filter</p>
        <form
          class="Search-Form w-100 p-0 rounded-lg d-flex flex-col space-y-4"
          v-on:submit.prevent="searchBook()"
        >
          <FwbInput
            v-model="title"
            placeholder="Search book"
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
          <div v-for="(options, group) in itemOptions" :key="group">
            <h3 class="text-lg font-semibold mb-2">{{ group }}</h3>
            <div class="flex flex-wrap gap-4">
              <FwbCheckbox
                v-for="option in options"
                :key="option"
                v-model="selectedFlags[group][option]"
                :label="option"
                :value="option"
              />
            </div>
          </div>
        </form>
        <div class="flex-center !justify-end h-12">
          <FwbButton
            v-if="!isDefaultFilter"
            @click="resetFilter()"
            color="yellow"
            >Reset</FwbButton
          >
        </div>
      </div>

      <div class="Content col-span-12 md:col-span-9">
        <div v-if="isLoading" class="w-100 h-100 flex-center flex-row">
          <Loader :size="40" />
        </div>
        <div v-else>
          <div v-if="!isEmpty" class="space-y-8">
            <div>
              <p v-if="isLoading" class="h6 mb-0">Fetching...</p>
              <p v-else class="h6 mb-0">Total: {{ total }} Books</p>
            </div>
            <RenderBook
              :books="books"
              :loading="isLoading"
              :hideHeader="true"
              :hideResult="false"
            />
            <div
              v-if="total > maxPaginateBook"
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

          <SearchEmptyState v-else text="book" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HomeNavigation from "../components/home/HomeNavigation.vue";
import RenderBook from "../components/RenderBook.vue";
import Filter from "../components/Filter.vue";
import BookController from "../controllers/BookController";
export default {
  name: "SearchResult",
  components: { RenderBook, Filter, HomeNavigation },
  data() {
    return {
      maxPaginateBook: Seavphov.maxPaginateBook,
      books: [],
      isLoading: false,
      itemOptions: {
        Category: [
          "Fiction",
          "Novel",
          "Text-Book",
          "History",
          "Science",
          "Fantasy",
        ],
        Condition: ["As-new", "Good", "Well-worn"],
        Availability: ["Available", "Unavailable"],
        HasPdf: ["Yes", "No"],
      },
      selectedFlags: {
        Category: {},
        Condition: {},
        Availability: {},
        HasPdf: {},
      },
      title: "",
      last_page: 5,
      current_page: 1,
      total: 0, // for hide if length less then paginate
      queryParams: this.$route.query.q,
    };
  },
  methods: {
    async searchBook() {
      this.isLoading = true;
      const response = await BookController.searchBook(
        this.getSelectedArrays()
      ); // response is the pagination object
      if (response) {
        this.books = response.data;
        this.current_page = response.current_page;
        this.last_page = response.last_page;
        this.total = response.total;
      }
      this.isLoading = false;
    },
    getSelectedArrays() {
      const result = {};

      for (const group in this.selectedFlags) {
        result[group] = Object.entries(this.selectedFlags[group])
          .filter(([option, isChecked]) => isChecked)
          .map(([option]) => option);
      }
      result["title"] = this.title;
      result["page"] = this.current_page;

      return result;
    },
    resetFilter() {
      Object.keys(this.selectedFlags).forEach((group) => {
        Object.keys(this.selectedFlags[group]).forEach((option) => {
          this.selectedFlags[group][option] = false;
        });
      });
      this.title = "";
      this.searchBook();
    },
    changePage(page) {
      this.current_page = page;
    },
  },
  computed: {
    isDefaultFilter() {
      return (
        !Object.values(this.selectedFlags).some((group) =>
          Object.values(group).some((isChecked) => isChecked)
        ) && !this.title
      );
    },
    isDisabledNext() {
      return this.current_page == this.last_page;
    },
    isDisabledPrev() {
      return this.current_page == 1;
    },
    isEmpty() {
      return this.books.length == 0;
    },
  },
  watch: {
    selectedFlags: {
      handler() {
        this.searchBook();
      },
      deep: true,
    },
    current_page(newVal) {
      this.searchBook(newVal);
    },
    queryParams: {
      handler() {
        this.title = this.$route.query.q;
        this.searchBook();
      },
      deep: true,
    },
  },
  async mounted() {
    this.title = this.$route.query.q;
    await this.searchBook();
  },
};
</script>

<style scoped></style>
