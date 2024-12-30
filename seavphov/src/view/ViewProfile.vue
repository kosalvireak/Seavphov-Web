<template>
  <div class="Profile box h-100 w-100">
    <div class="container-sm box b-1 p-0">
      <UserMainProfile
        :fromProfile="false"
        :user="User"
        :loading="isLoadingProfile"
      />
      <div
        class="flex book_options p-2 rounded-7 clickable book_option_child_selected fw-bold"
      >
        <a class="text-black">Home</a>
      </div>
      <div>
        <RenderBook :books="Books" :loading="isLoading" />
      </div>
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import UserMainProfile from "../components/UserMainProfile.vue";
import NoLoggin from "../components/NoLoggin.vue";
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
      filters: { uuid: null },
    };
  },
  async mounted() {
    this.isLoadingProfile = true;
    this.isLoading = true;
    const uuid = this.$route.params.uuid;
    const response = await this.$store.dispatch("fetchOtherUserProfile", uuid);
    this.User.uuid = response.uuid;
    this.filters.uuid = response.uuid;
    this.getBooks();
    this.User.name = response.name;
    this.User.picture = response.picture;
    this.User.phone = response.phone;
    this.User.facebook = response.facebook;
    this.User.instagram = response.instagram;
    this.User.location = response.location;
    this.User.twitter = response.twitter;
    this.User.telegram = response.telegram;
    this.User.location = response.location;
    this.isLoadingProfile = false;
  },
  methods: {
    async getBooks() {
      this.Books = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters
      );
      this.isLoading = false;
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