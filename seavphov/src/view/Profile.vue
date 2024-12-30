<template>
  <div class="Profile container box h-100 w-100">
    <div v-if="isLogin" class="container-sm box b-1 p-0">
      <UserMainProfile
        :fromProfile="true"
        :user="User"
        :loading="isLoadingProfile"
      />
      <div class="flex book_options p-2">
        <div
          class="flex book_option_child rounded-7 clickable"
          :class="{ 'book_option_child_selected fw-bold': isMyBooksPage }"
        >
          <a class="text-black font-75" @click="toggleMyBooksPage('mybooks')"
            >My Books</a
          >
        </div>
        <div
          class="flex book_option_child rounded-7 clickable"
          :class="{ 'book_option_child_selected fw-bold': !isMyBooksPage }"
        >
          <a class="text-black font-75" @click="toggleMyBooksPage('savedbooks')"
            >Saved Books</a
          >
        </div>
      </div>
      <div>
        <RenderBook
          v-if="!isMyBooksPage"
          :books="savedBooks"
          :loading="isLoading"
        />
        <RenderMyBook
          v-else
          :books="myBooks"
          :loading="isLoading"
          @call-get-book-2.once="getBooks()"
        />
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
import RenderBook from "../components/common/RenderBook.vue";
import RenderMyBook from "../components/RenderMyBook.vue";
import UserMainProfile from "../components/profile/UserMainProfile.vue";
import NoLoggin from "../components/common/NoLoggin.vue";
import MyBook from "../components/profile/MyBook.vue";
export default {
  name: "Profile",
  components: { UserMainProfile, RenderBook, NoLoggin, MyBook, RenderMyBook },
  data() {
    return {
      isMyBooksPage: true,
      myBooks: [],
      savedBooks: [],
      isLoading: false,
      isLoadingProfile: false,
      User: {},
    };
  },
  async mounted() {
    this.getBooks();
    this.isLoadingProfile = true;
    this.isLoading = true;
    const response = await this.$store.dispatch("fetchUserProfile");
    this.User.uuid = response.uuid;
    this.User.name = response.name;
    this.User.email = response.email;
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
    async toggleMyBooksPage(page) {
      if (page == "mybooks") {
        this.isMyBooksPage = true;
        await this.getBooks();
      } else if (page == "savedbooks") {
        this.isMyBooksPage = false;
        await this.getSavedBooks();
      }
    },
    async getBooks() {
      this.isLoading = true;
      this.myBooks = await this.$store.dispatch("getMyBooks");
      this.isLoading = false;
    },
    async getSavedBooks() {
      this.isLoading = true;
      this.savedBooks = await this.$store.dispatch("fetchSavedBook");
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
  justify-content: space-between !important;
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

@media only screen and (max-width: 576px) {
  .book_options {
    flex-direction: column;
    width: 100%;
    height: 100px;
    margin-top: 0px;
  }

  .book_option_child {
    width: 100%;
    height: 50px;
  }

  .font-75 {
    font-size: 75%;
  }
}
</style>