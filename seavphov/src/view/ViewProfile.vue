<template>
  <div class="Profile box h-100 w-100 mt-8">
    <div class="container-sm box b-1 p-0">
      <UserMainProfile
        :fromProfile="false"
        :user="User"
        :loading="isLoadingProfile"
      />
      <div
        v-if="!isLoading"
        class="flex book_options p-2 rounded-7 clickable book_option_child_selected fw-bold"
      >
        <a class="text-black">Books</a>
      </div>
      <div>
        <RenderBook :books="Books" :loading="isLoading" />
      </div>
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import UserMainProfile from "../components/profile/UserMainProfile.vue";
import NoLoggin from "../components/NoLoggin.vue";
import BookController from "../controllers/BookController";
import ProfileController from "../controllers/ProfileController";
export default {
  name: "ViewProfile",
  components: { UserMainProfile, RenderBook, NoLoggin },
  data() {
    return {
      isBooksPage: true,
      Books: [],
      isLoading: false,
      isLoadingProfile: false,
      User: {},
    };
  },
  async mounted() {
    const uuid = this.$route.params.uuid;
    this.fetchOtherUserProfile(uuid);
    this.getBooks(uuid);
  },
  methods: {
    async getBooks(uuid) {
      let filters = { uuid: null };
      filters.uuid = uuid;
      this.isLoading = true;
      this.Books = await BookController.fetchBooksWithFilter(filters);
      this.isLoading = false;
    },

    async fetchOtherUserProfile(uuid) {
      this.isLoadingProfile = true;
      this.User = await ProfileController.fetchOtherUserProfile(uuid);
      this.isLoadingProfile = false;
    },
  },
};
</script>

<style scoped>
.flex {
  display: flex;
  align-items: center;
  justify-content: center;
}

.book_options {
  justify-content: center;
  flex-direction: row;
  height: 50px;
  padding: 0px;
  margin-top: -54px;
}

.book_option_child {
  width: 50%;
  height: 50px;
  text-align: center;
}

.book_option_child:hover {
  background-color: #467e60 !important;
  transition: 0.3s;
  opacity: 70%;
}

.book_option_child_selected {
  background-color: #467e60 !important;
}

a:link {
  text-decoration: none;
}

a:hover {
  color: darkgray;
}

@media only screen and (max-width: 991.98px) {
  .book_options {
    margin-top: 0px;
  }
}
</style>
