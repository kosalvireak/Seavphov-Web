<template>
  <section class="EditReadingChallenge">
    <FwbDropdown align-to-end close-inside>
      <template #trigger>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg">
          <i class="fas fa-ellipsis-v fa-xl"></i>
        </div>
      </template>
      <nav :class="fwbDropdownNavCss">
        <p :class="fwbDropdownItemCss" @click="isShowModal = true">Edit</p>
        <p :class="fwbDropdownItemCss" @click="deleteChallenge">Delete</p>
      </nav>
    </FwbDropdown>

    <FwbModal
      v-if="isShowModal"
      size="xl"
      @close="isShowModal = false"
      class="EditReadingChallengePopup"
    >
      <template #header>
        <span class="text-lg">Update Reading Challenge</span>
      </template>

      <template #body>
        <div>
          <form
            v-on:submit.prevent="editReadingChallenge()"
            class="flex flex-col space-y-4 w-full text-start"
          >
            <p>Book image</p>
            <ImageUpload
              id="book"
              @image-uploaded="onUploadImage"
              :initialImage="challenge.book_image"
            />
            <MDBInput
              type="text"
              label="Book title"
              id="title"
              v-model="challenge.book_title"
              wrapperClass="bg-white h-3rem"
              required
            />
            <MDBInput
              type="text"
              label="Book author"
              id="author"
              v-model="challenge.book_author"
              wrapperClass="bg-white h-3rem"
              required
            />
            <MDBInput
              type="text"
              label="Challenge description"
              id="description"
              v-model="challenge.description"
              wrapperClass="bg-white h-3rem"
              required
            />
            <div class="flex flex-col">
              <label for="start_date">Start date</label>
              <input
                type="date"
                class="border-gray-400 rounded"
                id="start_date"
                v-model="challenge.start_date"
                required
              />
            </div>
            <div class="flex flex-col">
              <label for="end_date">End date</label>
              <input
                class="border-gray-400 rounded"
                type="date"
                id="end_date"
                :min="challenge.start_date"
                v-model="challenge.end_date"
                :disabled="hasStartDate"
                required
              />
            </div>
            <div>Total: {{ getDateDuration() }}</div>

            <div class="flex-center my-4">
              <LoadingButton :isLoading="isLoading" text="Done" type="submit" />
            </div>
          </form>
        </div>
      </template>
    </FwbModal>
  </section>
</template>

<script>
import ReadingChallengeController from "../../../../controllers/ReadingChallengeController";
import { MDBInput } from "mdb-vue-ui-kit";
export default {
  name: "EditReadingChallenge",
  components: { MDBInput },
  props: {
    propsChallenge: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      challenge: this.propsChallenge,
      isShowModal: false,
      isLoading: false,
      formData: new FormData(),
      id: this.$route.params.id,
      today: new Date().toISOString().split("T")[0],
    };
  },
  computed: {
    hasStartDate() {
      return this.challenge.start_date == "";
    },
  },
  methods: {
    async editReadingChallenge() {
      this.isLoading = true;
      this.setValueToFormAttribute(
        this.formData,
        "book_image",
        this.challenge.book_image,
      );
      this.formData.append("start_date", this.challenge.start_date);
      this.formData.append("end_date", this.challenge.end_date);
      this.formData.append("book_title", this.challenge.book_title);
      this.formData.append("book_author", this.challenge.book_author);
      this.formData.append("description", this.challenge.description);

      const success = await ReadingChallengeController.editReadingChallenge(
        this.formData,
        this.$route.params.id,
      );
      if (success) {
        this.isShowModal = false;
      }
      this.isLoading = false;
    },
    async deleteChallenge() {
      const success = await ReadingChallengeController.deleteChallenge(
        this.$route.params.id,
      );
      if (success) {
        this.$router.push({ name: "community" }).then(() => {
          window.location.reload();
        });
      }
    },
    getDateDuration() {
      if (this.challenge.start_date == "" || this.challenge.end_date == "")
        return "";
      const different =
        new Date(this.challenge.end_date) - new Date(this.challenge.start_date);
      return this.formatDifferentDays(different);
    },
    onUploadImage(url) {
      this.challenge.book_image = url;
    },
  },
};
</script>

<style scoped>
:deep(.p-6) {
  /* padding: 0.75rem 0rem 0.75rem 0.75rem !important; */
}
</style>
