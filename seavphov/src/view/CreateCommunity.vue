<template>
  <section class="CreateCommunity container-xl w-100 mt-8">
    <BackRoute />
    <div class="flex-center flex-col">
      <p class="h3">Create Community</p>
      <form v-on:submit.prevent="Save()" class="row w-100 flex-center">
        <div class="col-12 col-md-6 space-y-6">
          <!-- Profile -->

          <div class="mb-4">
            <p>Community Profile</p>
            <ImageUpload
              @image-uploaded="onUploadProfile"
              :initialImage="community.profile"
            />
            <Info
              text="You can leave Profile as default and Description empty!"
            />
          </div>
          <!-- Name -->
          <MDBInput
            type="text"
            label="Name"
            id="name"
            v-model="community.name"
            wrapperClass="bg-white h-3rem"
            required
          />

          <Info text="Name must be unique" />

          <!-- Description -->
          <MDBInput
            type="text"
            label="Description"
            id="text"
            v-model="community.description"
            wrapperClass="bg-white h-3rem"
          />

          <!-- Visibility -->
          <p>Visibility</p>
          <div class="mt-2">
            <MDBCheckbox :label="visibilityText" v-model="community.private" />
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <LoadingButton type="submit" text="Save" :isLoading="isLoading" />
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import { MDBInput, MDBCheckbox } from "mdb-vue-ui-kit";
import CommunityController from "../controllers/CommunityController";
export default {
  name: "CreateCommunity",
  components: { MDBInput, MDBCheckbox },
  data() {
    return {
      community: {
        name: "",
        description: "",
        private: true,
        profile: this.defaultCopProfile,
      },
      formData: new FormData(),
      isLoading: false,
    };
  },
  mounted() {
    this.formData.append("profile", this.community.profile);
  },
  methods: {
    async Save() {
      this.isLoading = true;
      this.formData.append("name", this.community.name);
      this.formData.append("description", this.community.description);
      this.formData.append("private", this.community.private);
      const cop = await CommunityController.createCommunity(this.formData);
      this.isLoading = false;
      this.toCopHome("community-home", cop.route);
    },
    async onUploadBanner(url) {
      this.community.banner = url;
      this.formData.append("banner", url);
    },
    async onUploadProfile(url) {
      this.community.profile = url;
      this.formData.append("profile", url);
    },
  },
  computed: {
    visibilityText() {
      return this.community.private ? "Private" : "Public";
    },
  },
};
</script>

<style>
</style>