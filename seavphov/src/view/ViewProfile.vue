<template>
  <div class="Profile box h-100 w-100">
    <div v-if="isLogin" class="container-sm box b-1 p-0">
      <UserMainProfile
        :fromProfile="false"
        :user="User"
        :loading="isLoadingProfile"
      />
      <div
        class="flex book_options rounded-7 cursor-pointer book_option_child_selected fw-bold"
      >
        <a class="text-black">Home</a>
      </div>
      <div>
        <RenderBook :books="Books" :loading="isLoading" />
      </div>
    </div>
    <div
      v-else
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <NoLoggin />
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
    };
  },
  async mounted() {
    this.getBooks();
    this.isLoadingProfile = true;
    const username = this.$route.params.username;
    const response = await this.$store.dispatch(
      "fetchOtherUserProfile",
      username
    );
    console.log("response", response);
    this.User.uuid = response.uuid;
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
      this.isLoading = true;
      this.Books = await this.$store.dispatch("fetchBookByWithAuth");
      this.isLoading = false;
    },
  },
  computed: {
    isLogin() {
      return this.$store.getters.isLogin;
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
  border-bottom: 1px solid rgb(125, 125, 125);
}
.book_option_child:hover {
  background-color: #9fb97fb0;
  border-bottom: 3px black;
  transition: 0.3s;
}

.book_option_child_selected {
  border-bottom: 1px solid black;
  background-color: #9fb97f;
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