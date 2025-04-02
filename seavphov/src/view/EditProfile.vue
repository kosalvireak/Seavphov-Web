<template>
  <div class="EditProfile w-100 mb-4 mt-8 container-xl">
    <BackRoute />
    <div v-if="isLogin" class="flex-center flex-column">
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
import ProfileController from "../controllers/ProfileController";
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
      this.setValueToFormAttribute(this.formData, "picture", url);
    },
    async onUploadCover(url) {
      this.user.cover = url;
      this.setValueToFormAttribute(this.formData, "cover", url);
    },
  },
  async mounted() {
    this.isLoading = true;
    this.user = await ProfileController.getMyProfileInfo();
    this.isLoading = false;
  },
};
</script>

<style scoped></style>
