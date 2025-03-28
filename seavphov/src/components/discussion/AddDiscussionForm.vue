<template>
  <section
    class="AddDiscussionForm container-xl rounded-lg p-2 ring-1 ring-gray-300"
  >
    <div
      class="d-flex justify-content-start align-items-center text-decoration-none w-100 space-x-2"
    >
      <FwbAvatar :img="$store.state.user.picture" rounded size="md" />
      <div
        @click="showModal"
        class="w-full rounded-lg p-2 hover:bg-gray-300 clickable"
      >
        What's on your mind?
      </div>
    </div>
    <FwbModal v-if="isShowModal" @close="closeModal" class="AddDiscussionPopup">
      <template #header>
        <div class="flex items-center text-lg">
          <img
            class="sp-logo-sm rounded-full mr-2"
            :src="$store.state.user.picture"
          />Create new discussion
        </div>
      </template>
      <template #body>
        <form>
          <div class="w-100 space-y-4">
            <MDBTextarea
              label="What's on your mind?"
              rows="1"
              v-model="discussion.body"
              required
            />
            <ImageUpload @image-uploaded="handleImageChange" />
          </div>
        </form>
      </template>
      <template #footer>
        <div class="flex justify-end">
          <LoadingButton
            @click="createDiscussion()"
            :isLoading="isLoading"
            :disabled="emptyDiscussion"
            text="Post"
            type="submit"
          />
        </div>
      </template>
    </FwbModal>
  </section>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
import DiscussionController from "../../controllers/DiscussionController";
export default {
  name: "AddDiscussionForm",
  components: { MDBTextarea },
  data() {
    return {
      isShowModal: false,
      discussion: {
        body: "",
        image: "null",
      },
      isLoading: false,
      formData: new FormData(),
      uploadingBook: false,
    };
  },
  mounted() {
    this.formData.append("image", this.discussion.image);
  },
  computed: {
    emptyDiscussion() {
      return this.discussion.body === "" || this.discussion.image === "";
    },
  },
  methods: {
    async createDiscussion() {
      this.isLoading = true;
      this.formData.append("body", this.discussion.body);
      const response = await DiscussionController.createDiscussion(
        this.formData
      );
      this.$emit("onAddDiscussion", response);
      this.closeModal();
      this.discussion.body = "";
      this.isLoading = false;
    },
    handleImageChange(url) {
      this.discussion.image = url;
      this.formData.append("image", url);
    },
    showModal() {
      this.isShowModal = true;
    },
    closeModal() {
      this.isShowModal = false;
    },
  },
};
</script>

<style scoped></style>
