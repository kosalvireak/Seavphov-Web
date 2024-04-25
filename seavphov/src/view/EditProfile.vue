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

      <form style="width: 100%" v-on:submit.prevent="Save()" class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="picture" class="form-label">Profile Image</label>
            <input
              type="file"
              class="form-control"
              id="picture"
              name="picture"
              @change="handleImageChange"
            />
          </div>
          <div class="d-flex justify-content-center">
            <div
              class="d-flex align-items-center justify-content-center border border-bdbdbd rounded-circle"
              style="width: 144px; height: 144px"
            >
              <img
                v-if="user.picture"
                :src="user.picture"
                alt="preview_image"
                class="img-fluid h-100 w-100 cover_image b-1 rounded-circle"
                style="object-fit: cover"
              />
              <div v-else>
                <Loader v-if="uploadingBook" />
                <p class="text-center" v-else>Your image will preview here</p>
              </div>
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
          <div class="mb-3">
            <label for="phone" class="form-label">Phone number</label>
            <input
              type="text"
              class="form-control"
              id="phone"
              v-model="user.phone"
            />
          </div>
        </div>
        <div class="col-12 col-md-6">
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
          <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input
              type="text"
              class="form-control"
              id="location"
              v-model="user.location"
            />
          </div>
          <button type="submit" class="col-12 btn btn-primary mt-2">
            Save
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
        picture: "",
        phone: "",
        instagram: "",
        facebook: "",
        twitter: "",
        telegram: "",
        location: "",
      },
      formData: new FormData(),
      uploadingBook: false,
    };
  },
  methods: {
    async Save() {
      this.formData.append("_method", "put");
      this.formData.append("name", this.user.name);
      this.formData.append("email", this.user.email);
      this.formData.append("picture", this.user.picture);
      this.formData.append("phone", this.user.phone);
      this.formData.append("instagram", this.user.instagram);
      this.formData.append("facebook", this.user.facebook);
      this.formData.append("twitter", this.user.twitter);
      this.formData.append("telegram", this.user.telegram);
      this.formData.append("location", this.user.location);
      await this.$store.dispatch("modifyUserProfile", this.formData);
      this.$router.push({ path: "/profile" });
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
              this.user.picture = url;
              this.formData.append("picture", url);
              this.uploadingBook = false;
              console.log("EditProfile this.user.picture", this.user.picture);
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
  async mounted() {
    const response = await this.$store.dispatch("fetchUserProfile");
    this.user.name = response.name;
    this.user.email = response.email;
    this.user.picture = response.picture;
    this.user.phone = response.phone;
    this.user.facebook = response.facebook;
    this.user.instagram = response.instagram;
    this.user.location = response.location;
    this.user.twitter = response.twitter;
    this.user.telegram = response.telegram;
    this.user.location = response.location;
  },
};
</script>

<style scoped>
.border-bdbdbd {
  border: 1px !important;
  border-style: solid !important;
  border-color: #bdbdbd !important;
}
.cover_image {
  object-fit: cover;
}
</style>