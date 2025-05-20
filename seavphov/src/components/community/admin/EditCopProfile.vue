<template>
  <section class="EditCopProfile card p-4">
    <div class="flex-center flex-column">
      <p class="h3">Edit Community Profile</p>
      <div v-if="isLoading" class="flex-center h-96">
        <Loader :size="40" />
      </div>
      <form
        v-else
        v-on:submit.prevent="Save()"
        class="row flex-center align-items-start space-y-4"
      >
        <div>
          <p>Banner image</p>
          <ImageUpload
            id="banner"
            @image-uploaded="onUploadBanner"
            :initialImage="cop.banner"
            :filled="true"
          />
        </div>
        <div class="col-12 col-md-6 space-y-4">
          <div>
            <p>Profile image</p>
            <ImageUpload
              id="profile"
              @image-uploaded="onUploadProfile"
              :initialImage="cop.profile"
            />
          </div>
        </div>
        <div class="col-12 col-md-6 space-y-4">
          <div>
            <MDBInput
              type="text"
              label="Name"
              id="name"
              v-model="cop.name"
              wrapperClass="bg-white h-3rem"
              :maxlength="50"
              counter
              required
            />

            <Info text="Only letters, numbers, and spaces are allowed." />
          </div>
          <div>
            <MDBTextarea
              type="text"
              label="Description"
              id="description"
              v-model="cop.description"
              wrapperClass="pt-2"
              required
            />
          </div>

          <div>
            <!-- Visibility -->
            <p>Visibility</p>
            <div class="mt-2">
              <FwbButton
                type="button"
                @click="cop.private = !cop.private"
                :color="visibilityColor"
                class="px-2 text-xs"
                >{{ visibilityText }}</FwbButton
              >
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-8">
          <LoadingButton
            type="submit"
            text="Save"
            :isLoading="isLoadingEdit"
            :disabled="disableSave"
          />
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import { MDBTextarea, MDBInput } from "mdb-vue-ui-kit";
import CommunityController from "../../../controllers/CommunityController";
export default {
  name: "EditCopProfile",
  components: { MDBInput, MDBTextarea },
  props: {
    route: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      isLoading: false,
      isLoadingEdit: false,
      cop: {},
      originalCop: {},
      formData: new FormData(),
    };
  },
  methods: {
    async Save() {
      this.isLoadingEdit = true;
      this.formData.append("_method", "put");
      this.formData.append("name", this.cop.name);
      this.formData.append("description", this.cop.description);
      this.formData.append("private", this.cop.private);
      await CommunityController.editCommunity(this.formData, this.route);
      this.isLoadingEdit = false;
    },
    async onUploadProfile(url) {
      this.cop.profile = url;
      this.setValueToFormAttribute(this.formData, "profile", url);
    },
    async onUploadBanner(url) {
      this.cop.banner = url;
      this.setValueToFormAttribute(this.formData, "banner", url);
    },
  },
  async mounted() {
    this.isLoading = true;
    this.cop = await CommunityController.getCommunityByRoute(this.route);
    this.originalCop = JSON.parse(JSON.stringify(this.cop));
    this.isLoading = false;
  },
  computed: {
    visibilityText() {
      return this.cop.private ? "Private" : "Public";
    },
    visibilityColor() {
      return this.cop.private ? "red" : "green";
    },
    disableSave() {
      return this.isEqual(this.cop, this.originalCop);
    },
  },
};
</script>

<style></style>
