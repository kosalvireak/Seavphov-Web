<template>
  <div class="Profile box" style="height: 100%">
    <div v-if="this.$store.state.isLogin" class="container-sm box b-1 p-0">
      <UserMainProfile />
      <div class="flex book_options">
        <div
          class="flex book_option_child rounded-7"
          :class="{ 'book_option_child_selected fw-bold': isMyBooksPage }"
        >
          <a class="text-black" @click="toggleMyBooksPage('mybooks')"
            >My Books</a
          >
        </div>
        <div
          class="flex book_option_child rounded-7"
          :class="{ 'book_option_child_selected fw-bold': !isMyBooksPage }"
        >
          <a class="text-black" @click="toggleMyBooksPage('savedbooks')"
            >Saved Books</a
          >
        </div>
      </div>
      <div>
        <RenderBook :books="isMyBooksPage ? myBooks : savedBooks" />
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
  name: "Profile",
  components: { UserMainProfile, RenderBook, NoLoggin },
  data() {
    return {
      isMyBooksPage: true,
      myBooks: [],
      savedBooks: [],
    };
  },
  mounted() {
    this.getBooks();
  },
  methods: {
    toggleMyBooksPage(page) {
      if (page == "mybooks") {
        this.isMyBooksPage = true;
      } else {
        this.isMyBooksPage = false;
      }
    },
    async getBooks() {
      this.myBooks = await this.$store.dispatch("fetchBookByWithAuth");
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

@media only screen and (max-width: 576px) {
  .book_options {
    flex-direction: column;
    width: 500px;
    height: 100px;
    margin-top: 0px;
  }

  .book_option_child {
    width: 100%;
    height: 50px;
  }
}
</style>