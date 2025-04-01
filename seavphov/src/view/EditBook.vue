<template>
  <div class="AddBook w-100  mt-8 container-xl">
    <BackRoute />

    <div
      v-if="true"
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <p class="h3 ">Edit book</p>

      <form
        style="width: 100%"
        v-on:submit.prevent="modifyBook()"
        class="row flex-center"
      >
        <div class="col-12 col-md-6 space-y-4">
          <div class="">
            <ImageUpload
              v-if="book.images"
              @image-uploaded="onUploadBookImage"
              :initialImage="book.images"
            />
          </div>
          <div class="">
            <MDBInput
              type="text"
              label="Title"
              id="title"
              class="h-3rem"
              v-model="book.title"
              wrapperClass="bg-white "
              required
            />
          </div>
          <div class="">
            <MDBInput
              type="text"
              label="Author"
              id="author"
              v-model="book.author"
              wrapperClass="bg-white "
              required
            />
          </div>
          <div class="">
            <MDBInput
              type="text"
              label="Descriptions"
              id="descriptions"
              v-model="book.descriptions"
              wrapperClass="bg-white "
              required
            />
          </div>
          <div class="input-group ">
            <label
              class="input-group-text"
              for="condition"
              style="height: 40px; width: 100px"
              >Condition</label
            >
            <select class="form-select" id="condition" v-model="book.condition">
              <option value="As-new">As-new</option>
              <option value="Good">Good</option>
              <option value="Well-worn">Well-worn</option>
            </select>
          </div>

          <div class="input-group ">
            <label
              class="input-group-text"
              for="categories"
              style="height: 40px; width: 100px"
              >Categories</label
            >
            <select
              class="form-select"
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
                color="blue"
            />

            <ImageUpload id="pdf-url" @image-uploaded="handlePDFChange" />
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-8">
          <LoadingButton type="submit" text="Save" :isLoading="isLoading" />
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
  name: "EditBook",
  components: { NoLoggin, MDBInput },
  data() {
    return {
      paramsId: this.$route.params.id,
      book: {
        id: "",
        title: "",
        author: "",
        images: "",
        descriptions: "",
        condition: "Good",
        categories: "Novel",
        has_pdf: false,
        pdf_url: "",
      },
      isLoading: false,
      author: {},
      formData: new FormData(),
      uploadingBook: false,
    };
  },
  methods: {
    async modifyBook() {
      this.isLoading = true;
      this.formData.append("_method", "put");
      this.formData.append("title", this.book.title);
      this.formData.append("id", this.paramsId);
      this.formData.append("author", this.book.author);
      this.formData.append("categories", this.book.categories);
      this.formData.append("condition", this.book.condition);
      this.formData.append("descriptions", this.book.descriptions);
      this.formData.append("availability", 1);
      this.formData.append("has_pdf", this.book.has_pdf);
      await BookController.modifyBook(this.formData);
      this.$router.push({ path: `/book/${this.paramsId}` });
      this.isLoading = false;
    },
    async onUploadBookImage(url) {
      this.book.images = url;
      this.formData.append("images", url);
    },
    handlePDFChange(url) {
      this.formData.append("pdf_url", url);
    },
    async getBook(id) {
      const response = await BookController.getMyBook(id);
      this.book.id = response.id;
      this.book.title = response.title;
      this.book.author = response.author;
      this.book.images = response.images;
      this.book.descriptions = response.descriptions;
      this.book.condition = response.condition;
      this.book.categories = response.categories;
      this.book.has_pdf = response.has_pdf;
      this.book.pdf_url = response.pdf_url;

      this.formData.append("images", response.images);
      this.formData.append("pdf_url", response.pdf_url);
    },
  },
  async mounted() {
    this.getBook(this.paramsId);
  },
};
</script>

<style scoped>
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
</style>
