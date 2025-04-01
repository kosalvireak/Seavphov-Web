<template>
  <div class="AddBook w-100 container-xl mt-8">
    <BackRoute />
    <div
      v-if="true"
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <p class="h3">Add book</p>

      <form
        style="width: 100%"
        v-on:submit.prevent="AddBook()"
        class="row flex-center"
      >
        <div class="col-12 col-md-6 space-y-4">
          <div class="">
            <ImageUpload id="book-images" @image-uploaded="handleImageChange" />
          </div>
          <div class="">
            <MDBInput
              type="text"
              label="Title"
              id="title"
              v-model="book.title"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="">
            <MDBInput
              type="text"
              label="Author"
              id="author"
              v-model="book.author"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="">
            <MDBInput
              type="text"
              label="Descriptions"
              id="descriptions"
              v-model="book.descriptions"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="input-group">
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

          <div class="input-group">
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
          <div class="pdf-section space-y-4">
            <FwbToggle
              v-model="book.has_pdf"
              label="Has PDF?"
              reverse
              color="yellow"
            />

            <PdfUpload v-if="book.has_pdf" id="pdf-url" @pdf-uploaded="handlePDFChange" />
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-8">
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
import { FwbToggle } from "flowbite-vue";
import { MDBInput } from "mdb-vue-ui-kit";
import NoLoggin from "../components/NoLoggin.vue";
import BookController from "../controllers/BookController";
export default {
  name: "AddBook",
  components: { NoLoggin, MDBInput, FwbToggle },
  data() {
    return {
      book: {
        title: "",
        author: "",
        images: "",
        descriptions: "",
        condition: "Good",
        categories: "Novel",
        has_pdf: false,
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
      this.formData.append("has_pdf", this.book.has_pdf);
      const response = await BookController.addBook(this.formData);
      this.$router.push({ path: `/book/${response}` });
      this.isLoading = false;
    },
    handleImageChange(url) {
      this.book.images = url;
      this.formData.append("images", url);
    },
    handlePDFChange(url) {
      this.formData.append("pdf_url", url);
    },
  },
};
</script>

<style scoped>
</style>
