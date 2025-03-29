<template>
  <FwbModal v-if="isShowModal" @close="closeModal" class="AddDiscussionPopup">
    <template #header>
      <div class="flex items-center text-lg">
        <img
          class="sp-logo-sm rounded-full mr-2"
          :src="$store.state.user.picture"
        />Edit discussion
      </div>
    </template>
    <template #body>
      <form>
        <div class="w-100 space-y-4">
          <MDBTextarea
            label="Discussion's body"
            rows="1"
            v-model="discussion.body"
            required
          />
          <ImageUpload
            @image-uploaded="handleImageChange"
            :initialImage="discussion.image"
          />
        </div>
      </form>
    </template>
    <template #footer>
      <div class="flex justify-end">
        <LoadingButton
          @click="editDiscussion()"
          :isLoading="isLoading"
          :disabled="disableSave"
          text="Done"
          type="submit"
        />
      </div>
    </template>
  </FwbModal>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
import DiscussionController from "../../controllers/DiscussionController";
export default {
  name: "EditDiscussionPopup",
  components: { MDBTextarea },
  data() {
    return {
      isLoading: false,
      isShowModal: true,
      formData: new FormData(),
      discussion: {},
      originalDiscussion: {},
    };
  },
  props: {
    discussionProp: Object,
  },
  created() {
    this.discussion = JSON.parse(JSON.stringify(this.discussionProp)); // deep copy;
    this.originalDiscussion = JSON.parse(JSON.stringify(this.discussionProp));
    this.formData.append("image", this.discussion.image);
  },
  computed: {
    disableSave() {
      return this.isEqual(this.discussion, this.originalDiscussion);
    },
  },
  methods: {
    async editDiscussion() {
      this.isLoading = true;

      this.formData.append("_method", "put");
      this.formData.append("body", this.discussion.body);
      const response = await DiscussionController.editDiscussion(
        this.formData,
        this.discussion.id
      );
      this.$emit("onDoneEdit", response);
      this.closeModal();
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
      this.$emit("onClose");
    },
  },
};
</script>

<style>
</style>