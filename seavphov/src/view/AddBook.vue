<template>
  <div class="mb-3">
    <a
      @click="
        () => {
          this.$router.push('/home');
        }
      "
      class="text-gray"
    >
      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to home
    </a>

    <div
      v-if="isLogin"
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <h4 class="my-4 text-gray fw-bold">Your are adding a new book.</h4>

      <form style="width: 100%" v-on:submit.prevent="AddBook()" class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="title"
              v-model="book.title"
              required
            />
          </div>
          <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input
              type="text"
              class="form-control"
              id="author"
              v-model="book.author"
              required
            />
          </div>
          <div class="mb-3">
            <label for="descriptions" class="form-label">Descriptions</label>
            <input
              type="text"
              class="form-control"
              id="descriptions"
              v-model="book.descriptions"
              required
            />
          </div>
          <div class="input-group mb-3" style="margin-top: 2rem">
            <label
              class="input-group-text"
              for="condition"
              style="height: 40px; width: 100px"
              >Condition</label
            >
            <select
              class="form-select"
              id="condition"
              v-model="book.condition"
              required
            >
              <option value="As-new" selected>As-new</option>
              <option value="Good">Good</option>
              <option value="Well-worn">Well-worn</option>
            </select>
          </div>

          <div class="input-group mb-3" style="margin-top: 2rem">
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
              required
            >
              <option value="Fiction" selected>Fiction</option>
              <option value="Novel">Novel</option>
              <option value="Text-Book">Text-Book</option>
              <option value="History">History</option>
              <option value="Science">Science</option>
              <option value="Fantasy">Fantasy</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="images" class="form-label">Book Image</label>
            <input
              type="file"
              class="form-control"
              id="images"
              name="images"
              @change="handleImageChange"
              required
            />
          </div>
          <div
            class="my-3 mt-3 d-flex align-items-center justify-content-center border border-bdbdbd rounded-7"
            style="width: 100%; height: 242px"
          >
            <img
              v-if="book.images"
              :src="book.images"
              alt="preview_image"
              class="img-fluid h-100"
              style="object-fit: cover"
            />
            <div v-else>
              <Loader v-if="uploadingBook" />
              <p class="text-center" v-else>Your image will preview here</p>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-1">Add Book</button>
          <div></div>
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
import { storage } from "../firebase";
import { ref, uploadBytes, getDownloadURL } from "firebase/storage";
import Loader from "../components/Loader.vue";
import NoLoggin from "../components/NoLoggin.vue";
import { useToast } from "vue-toastification";
export default {
  name: "AddBook",
  components: { Loader, NoLoggin },
  data() {
    return {
      toast: useToast(),
      book: {
        title: "",
        author: "",
        images: "",
        descriptions: "",
        condition: "GOOD",
        categories: "NOVEL",
      },
      formData: new FormData(),
      uploadingBook: false,
    };
  },
  methods: {
    async AddBook() {
      this.formData.append("title", this.book.title);
      this.formData.append("author", this.book.author);
      this.formData.append("categories", this.book.categories);
      this.formData.append("condition", this.book.condition);
      this.formData.append("descriptions", this.book.descriptions);
      this.formData.append("availability", 1);
      await this.$store.dispatch("createBook", this.formData);
      if (this.$store.state.newBookId) {
        this.$router.push({ path: `/home/${this.$store.state.newBookId}` });
      }
    },
    async handleImageChange(event) {
      this.uploadingBook = true;
      try {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
          const storageRef = ref(storage, `folder/${selectedFile.name}`);
          const imageUpload = await uploadBytes(storageRef, selectedFile);
          getDownloadURL(ref(storage, imageUpload.metadata.fullPath)).then(
            (url) => {
              this.book.images = url;
              this.formData.append("images", url);
              this.uploadingBook = false;
            }
          );
        }
      } catch (error) {
        this.toast.error(error);
      }
    },
  },
  computed: {
    isLogin() {
      return this.$store.getters.isLogin;
    },
  },
};
</script>

<style>
.border-bdbdbd {
  border: 1px !important;
  border-style: solid !important;
  border-color: #bdbdbd !important;
}
</style>