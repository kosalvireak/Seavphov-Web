<template>
  <div class="EditUserProfile w-100 mb-4 mt-8 container-xl">
    <BackRoute />
    <div class="flex-center flex-column">
      <p class="h3">Edit profile</p>
      <div v-if="isLoading" class="flex-center h-96">
        <Loader :size="40" />
      </div>
      <form v-else v-on:submit.prevent="Save()" class="row w-100">
        <div class="mb-4">
          <p>Cover image</p>
          <ImageUpload
            id="cover"
            @image-uploaded="onUploadCover"
            :initialImage="user.cover"
            :filled="true"
          />
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <p>Profile image</p>
            <ImageUpload
              id="profile"
              @image-uploaded="onUploadPicture"
              :initialImage="user.picture"
            />
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
            <Info
              text="Your
              email will not visible to any user in platform."
            />
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
            <Info
              text="Empty
              field or null will not visible to any user in platform."
            />
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <LoadingButton type="submit" text="Save" :isLoading="isSaving" />
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
import UserController from "../controllers/UserController.js";
export default {
  name: "EditProfile",
  components: { MDBInput },
  data() {
    return {
      isLoading: false,
      isSaving: false,
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
    };
  },
  methods: {
    async Save() {
      this.isSaving = true;

      this.createProfileData(this.formData);
      const responseData = await UserController.editProfile(this.formData);
      this.isSaving = false;

      if (responseData) {
        await this.$store.dispatch("setCookieAndRedirectToHome", responseData);
      }

      this.toRouteName("profile");
    },
    createProfileData(formData) {
      formData.append("_method", "put");
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      formData.append("picture", this.user.picture);
      formData.append("cover", this.user.cover);
      formData.append("bio", this.user.bio);
      formData.append("phone", this.user.phone);
      formData.append("instagram", this.user.instagram);
      formData.append("facebook", this.user.facebook);
      formData.append("twitter", this.user.twitter);
      formData.append("telegram", this.user.telegram);
      formData.append("location", this.user.location);
    },
    async onUploadPicture(url) {
      this.user.picture = url;
      this.setValueToFormAttribute(this.formData, "picture", url);
    },
    async onUploadCover(url) {
      this.user.cover = url;
      this.setValueToFormAttribute(this.formData, "cover", url);
    },
  },
  async mounted() {
    this.isLoading = true;
    this.user = await UserController.getProfile();
    this.isLoading = false;
  },
};
</script>

<style scoped></style>
