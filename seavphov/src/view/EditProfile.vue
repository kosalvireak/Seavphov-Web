<template>
  <div class="EditProfile w-100 mb-4 mt-8 container-sm">
    <BackRoute />
    <div
      v-if="isLogin"
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <h4 class="mb-4 text-gray fw-bold">Edit profile</h4>
      <div v-if="isLoading" class="flex-center h-96">
        <Loader :size="40" />
      </div>
      <form v-else style="width: 100%" v-on:submit.prevent="Save()" class="row">
        <div class="mb-4">
          <p>Cover image</p>
          <ImageUpload @image-uploaded="onUploadCover" />
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <p>Profile image</p>
            <ImageUpload @image-uploaded="onUploadPicture" />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Name"
              id="name"
              v-model="user.name"
              wrapperClass="bg-white h-3rem"
              required
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="email"
              label="Email"
              id="email"
              v-model="user.email"
              wrapperClass="bg-white h-3rem"
              required
            />
            <p class="text-gray-400 text-sm mt-1 mb-0">
              <i class="fa fa-info-circle mr-1" aria-hidden="true"></i>Your
              email will not visible to any user in platform.
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Phone number"
              id="phone"
              v-model="user.phone"
              wrapperClass="bg-white h-3rem"
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Bio"
              id="bio"
              v-model="user.bio"
              wrapperClass="bg-white h-3rem"
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Instagram link"
              id="instagram"
              v-model="user.instagram"
              wrapperClass="bg-white h-3rem"
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Facebook link"
              id="facebook"
              v-model="user.facebook"
              wrapperClass="bg-white h-3rem"
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Twitter link"
              id="twitter"
              v-model="user.twitter"
              wrapperClass="bg-white h-3rem"
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Telegram link"
              id="telegram"
              v-model="user.telegram"
              wrapperClass="bg-white h-3rem"
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Location"
              id="location"
              v-model="user.location"
              wrapperClass="bg-white h-3rem"
            />
            <p class="text-gray-400 text-sm mt-1 mb-0">
              <i class="fa fa-info-circle mr-1" aria-hidden="true"></i>Empty
              field will not visible to any user in platform.
            </p>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
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
import NoLoggin from "../components/NoLoggin.vue";
import { MDBInput } from "mdb-vue-ui-kit";
export default {
  name: "EditProfile",
  components: { NoLoggin, MDBInput },
  data() {
    return {
      isLoading: false,
      user: {
        name: "",
        email: "",
        picture: "",
        cover: "",
        bio: "",
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
      this.isLoading = true;
      this.formData.append("_method", "put");
      this.formData.append("name", this.user.name);
      this.formData.append("email", this.user.email);
      this.formData.append("picture", this.user.picture);
      this.formData.append("cover", this.user.cover);
      this.formData.append("bio", this.user.bio);
      this.formData.append("phone", this.user.phone);
      this.formData.append("instagram", this.user.instagram);
      this.formData.append("facebook", this.user.facebook);
      this.formData.append("twitter", this.user.twitter);
      this.formData.append("telegram", this.user.telegram);
      this.formData.append("location", this.user.location);
      await this.$store.dispatch("modifyUserProfile", this.formData);
      this.toRouteName("profile");
    },
    async onUploadPicture(url) {
      this.user.picture = url;
      this.formData.append("picture", url);
    },
    async onUploadCover(url) {
      this.user.cover = url;
      this.formData.append("cover", url);
    },
  },
  async mounted() {
    this.isLoading = true;
    const response = await this.$store.dispatch("fetchUserProfile");
    this.user.name = response.name;
    this.user.email = response.email;
    this.user.picture = response.picture;
    this.user.cover = response.cover;
    this.user.bio = response.bio;
    this.user.phone = response.phone;
    this.user.facebook = response.facebook;
    this.user.instagram = response.instagram;
    this.user.location = response.location;
    this.user.twitter = response.twitter;
    this.user.telegram = response.telegram;
    this.user.location = response.location;
    this.isLoading = false;
  },
};
</script>

<style scoped>
.cover_image {
  object-fit: cover;
}

.custom-file-upload {
  display: inline-block;
  padding: 2px 7px;
  cursor: pointer;
  color: #4f4f4f;
  background-color: #fff;
  border-radius: 5px;
  position: absolute;
  margin: 2px 0px 0px 1px;
}

.btn {
  background-color: #5c836e;
  color: #fff;
}
</style>
