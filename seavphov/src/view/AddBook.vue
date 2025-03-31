<template>
  <div class="AddBook w-100 mb-4 container-xl mt-8">
    <BackRoute />
    <div
      v-if="true"
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <p class="h3">Add book</p>

      <form style="width: 100%" v-on:submit.prevent="AddBook()" class="row">
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Title"
              id="title"
              v-model="book.title"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Author"
              id="author"
              v-model="book.author"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Descriptions"
              id="descriptions"
              v-model="book.descriptions"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="input-group mb-4">
            <label
              class="input-group-text h-3rem"
              for="condition"
              style="height: 40px; width: 100px"
              >Condition</label
            >
            <select
              class="form-select h-3rem"
              id="condition"
              v-model="book.condition"
            >
              <option value="As-new">As-new</option>
              <option value="Good">Good</option>
              <option value="Well-worn">Well-worn</option>
            </select>
          </div>

          <div class="input-group mb-4">
            <label
              class="input-group-text h-3rem"
              for="categories"
              style="width: 100px"
              >Categories</label
            >
            <select
              class="form-select h-3rem"
              id="categories"
              v-model="book.categories"
            >
              <option value="Fiction">Fiction</option>
              <option value="Novel">Novel</option>
              <option value="Text-Book">Text-Book</option>
              <option value="History">History</option>
              <option value="Science">Science</option>
              <option value="Fantasy">Fantasy</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <ImageUpload @image-uploaded="handleImageChange" />
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <LoadingButton :isLoading="isLoading" text="Add" type="submit" />
        </div>
      </form>
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
import { MDBInput } from "mdb-vue-ui-kit";
import NoLoggin from "../components/NoLoggin.vue";
import BookController from "../controllers/BookController";
export default {
  name: "AddBook",
  components: { NoLoggin, MDBInput },
  data() {
    return {
      book: {
        title: "",
        author: "",
        images: "",
        descriptions: "",
        condition: "Good",
        categories: "Novel",
      },
      isLoading: false,
      formData: new FormData(),
      uploadingBook: false,
    };
  },
  methods: {
    async AddBook() {
      this.isLoading = true;
      this.formData.append("title", this.book.title);
      this.formData.append("author", this.book.author);
      this.formData.append("categories", this.book.categories);
      this.formData.append("condition", this.book.condition);
      this.formData.append("descriptions", this.book.descriptions);
      this.formData.append("availability", 1);
      const response = await BookController.addBook(this.formData);
      this.$router.push({ path: `/book/${response}` });
      this.isLoading = false;
    },
    handleImageChange(url) {
      this.book.images = url;
      this.formData.append("images", url);
    },
  },
};
</script>

<style scoped>
.border-bdbdbd {
  border: 1px !important;
  border-style: solid !important;
  border-color: #bdbdbd !important;
}
.custom-file-upload {
  display: inline-block;
  padding: 4px 12px;
  cursor: pointer;
  color: #4f4f4f;
  background-color: #fff;
  border-radius: 5px;
  position: absolute;
  margin: 2px 0px 0px 1px;
}

.form-control {
  padding: 0.375rem 0.75rem !important;
}

.logo_img {
  width: 150px;
  height: auto;
}
</style>
