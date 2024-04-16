<template>
  <div class="mb-3">
    <a
      @click="
        () => {
          this.$router.push('/profile');
        }
      "
      class="text-gray"
    >
      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to profile
    </a>

    <div
      v-if="isLogin"
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <h4 class="my-4 text-gray fw-bold">Your are editing your profile</h4>

      <form style="width: 100%" v-on:submit.prevent="AddBook()" class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="images" class="form-label">Profile Image</label>
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
            class="my-3 mt-3 d-flex align-items-center justify-content-center border border-bdbdbd rounded-circle"
            style="width: 152px; height: 152px"
          >
            <img
              v-if="user.images"
              :src="user.images"
              alt="preview_image"
              class="img-fluid h-100 w-100 cover_image b-1 rounded-circle"
              style="object-fit: cover"
            />
            <div v-else>
              <Loader v-if="uploadingBook" />
              <p class="text-center" v-else>Your image will preview here</p>
            </div>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              v-model="user.name"
              required
            />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              v-model="user.email"
              required
            />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="phone" class="form-label">Phone number</label>
            <input
              type="text"
              class="form-control"
              id="phone"
              v-model="user.phone"
              required
            />
          </div>
          <div class="mb-3">
            <label for="instagram" class="form-label">Instagram link</label>
            <input
              type="text"
              class="form-control"
              id="instagram"
              v-model="user.instagram"
            />
          </div>
          <div class="mb-3">
            <label for="facebook" class="form-label">Facebook link</label>
            <input
              type="text"
              class="form-control"
              id="facebook"
              v-model="user.facebook"
            />
          </div>
          <div class="mb-3">
            <label for="twitter" class="form-label">Twitter link</label>
            <input
              type="text"
              class="form-control"
              id="twitter"
              v-model="user.twitter"
            />
          </div>
          <div class="mb-3">
            <label for="telegram" class="form-label">Telegram link</label>
            <input
              type="text"
              class="form-control"
              id="telegram"
              v-model="user.telegram"
            />
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-1">Save</button>
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
  name: "EditProfile",
  components: { Loader, NoLoggin },
  data() {
    return {
      toast: useToast(),
      user: {
        name: "",
        email: "",
        images: "",
        phone: "",
        instagram: "",
        facebook: "",
        twitter: "",
        telegram: "",
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
  async mounted() {},
};
</script>

<style>
.border-bdbdbd {
  border: 1px !important;
  border-style: solid !important;
  border-color: #bdbdbd !important;
}
.cover_image {
  object-fit: cover;
}
</style>