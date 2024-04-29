<template>
  <div class="AddBook w-100 mb-4 container-sm">
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
      v-if="true"
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <h4 class="my-4 text-gray fw-bold">Your are adding a new book.</h4>

      <form style="width: 100%" v-on:submit.prevent="AddBook()" class="row">
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Title"
              id="title"
              v-model="book.title"
              wrapperClass="bg-white"
              required
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Author"
              id="author"
              v-model="book.author"
              wrapperClass="bg-white"
              required
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Descriptions"
              id="descriptions"
              v-model="book.descriptions"
              wrapperClass="bg-white"
              required
            />
          </div>
          <div class="input-group mb-4">
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

          <div class="input-group mb-4">
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
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <label for="images" class="form-label custom-file-upload"
              >Book Image</label
            >
            <input
              type="file"
              class="form-control"
              id="images"
              name="images"
              @change="handleImageChange"
            />
          </div>
          <div
            class="my-3 mt-3 d-flex align-items-center justify-content-center border border-bdbdbd rounded-7"
            style="width: 100%; height: 220px"
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
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" class="col-2 btn btn-primary mt-2">
            Add Book
          </button>
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
import { storage } from "../firebase";
import { ref, uploadBytes, getDownloadURL } from "firebase/storage";
import Loader from "../components/Loader.vue";
import NoLoggin from "../components/NoLoggin.vue";
import { useToast } from "vue-toastification";
export default {
  name: "AddBook",
  components: { Loader, NoLoggin, MDBInput },
  data() {
    return {
      toast: useToast(),
      book: {
        title: "",
        author: "",
        images: "",
        descriptions: "",
        condition: "Good",
        categories: "Novel",
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
</style>