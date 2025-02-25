<template>
  <section
    class="AddDiscussionForm container rounded-lg p-2 ring-1 ring-gray-300"
  >
    <div
      class="d-flex justify-content-start align-items-center text-decoration-none w-100"
    >
      <img
        class="sp-logo-sm rounded-full mr-2 flex-shrink-0"
        :src="$store.state.user.picture"
      />
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
            <div class="flex-center h-64 ring-1 ring-gray-300 rounded-lg">
              <img
                v-if="discussion.image"
                :src="discussion.image"
                alt="preview_image"
                class="img-fluid h-100"
                style="object-fit: cover"
              />
              <div v-else>
                <Loader v-if="uploadingBook" />
                <div class="text-center" v-else>
                  <p>Drop a file here to upload, click here to browse</p>
                  <input
                    type="file"
                    class="ring-1 ring-gray-300 rounded-lg"
                    id="images"
                    name="images"
                    required
                    @change="handleImageChange"
                  />
                </div>
              </div>
            </div>
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
import { storage } from "../../firebase";
import { ref, uploadBytes, getDownloadURL } from "firebase/storage";
export default {
  name: "AddDiscussionForm",
  components: { MDBTextarea },
  data() {
    return {
      isShowModal: false,
      discussion: {
        body: "",
        image: "",
      },
      isLoading: false,
      formData: new FormData(),
      uploadingBook: false,
    };
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
      const response = await this.$store.dispatch(
        "createDiscussion",
        this.formData,
      );
      this.$emit("onAddDiscussion", response);
      this.closeModal();
      this.isLoading = false;
    },
    async handleImageChange(event) {
      try {
        this.uploadingBook = true;
        const selectedFile = event.target.files[0];
        if (selectedFile) {
          const storageRef = ref(storage, `folder/${selectedFile.name}`);
          const imageUpload = await uploadBytes(storageRef, selectedFile);
          getDownloadURL(ref(storage, imageUpload.metadata.fullPath)).then(
            (url) => {
              this.discussion.image = url;
              this.formData.append("image", url);
              this.uploadingBook = false;
            },
          );
        }
      } catch (error) {
        this.$toast.error(error);
      }
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

<style scoped>
input[type="file"] {
  font-size: 0;
  margin: 0px;
  padding: 0px;
}
::file-selector-button {
  font-size: initial;
}
</style>
