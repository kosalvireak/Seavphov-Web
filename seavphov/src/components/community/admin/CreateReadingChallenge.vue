<template>
  <section class="CreateReadingChallenge card p-4">
    <div class="flex-center flex-column">
      <p class="h3">Create Reading Challenge</p>
    </div>
    <form v-on:submit.prevent="Save()" class="row flex-center text-gray">
      <div class="col-12 col-md-6">
        <div class="mb-4">
          <p>Book image</p>
          <ImageUpload id="book" @image-uploaded="onUploadImage" />
        </div>
      </div>
      <div class="col-12 col-md-6 space-y-4">
        <MDBInput
          type="text"
          label="Book title"
          id="title"
          v-model="readingChallenge.book_title"
          wrapperClass="bg-white h-3rem"
          required
        />
        <MDBInput
          type="text"
          label="Book author"
          id="author"
          v-model="readingChallenge.book_author"
          wrapperClass="bg-white h-3rem"
          required
        />
        <MDBInput
          type="text"
          label="Challenge description"
          id="description"
          v-model="readingChallenge.description"
          wrapperClass="bg-white h-3rem"
          required
        />
        <div class="flex flex-col md:flex-row gap-4">
          <div class="flex flex-col">
            <label for="start_date">Start date</label>
            <input
              type="date"
              id="start_date"
              class="border-gray-400 rounded"
              v-model="readingChallenge.start_date"
              required
            />
          </div>
          <div class="flex flex-col">
            <label for="end_date">End date</label>
            <input
              type="date"
              id="end_date"
              class="border-gray-400 rounded"
              :min="readingChallenge.start_date"
              v-model="readingChallenge.end_date"
              :disabled="hasStartDate"
              required
            />
          </div>
        </div>
        <div>{{ getDateDuration() }}</div>
      </div>
      <div class="flex-center mt-4 !md:mt-0">
        <LoadingButton :isLoading="isLoading" text="Add" type="submit" />
      </div>
    </form>
  </section>
</template>

<script>
import { MDBTextarea, MDBInput } from "mdb-vue-ui-kit";
import ReadingChallengeController from "../../../controllers/ReadingChallengeController";
export default {
  name: "CreateReadingChallenge",
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
      readingChallenge: {
        start_date: "",
        end_date: "",
        book_image: "",
        book_title: "",
        book_author: "",
        description: "",
      },
      formData: new FormData(),
      today: new Date().toISOString().split("T")[0],
    };
  },
  methods: {
    async Save() {
      this.isLoading = true;
      this.formData.append("start_date", this.readingChallenge.start_date);
      this.formData.append("end_date", this.readingChallenge.end_date);
      this.formData.append("book_title", this.readingChallenge.book_title);
      this.formData.append("book_author", this.readingChallenge.book_author);
      this.formData.append("description", this.readingChallenge.description);
      await ReadingChallengeController.addReadingChallenge(
        this.formData,
        this.route,
      );
      this.isLoading = false;
    },
    onUploadImage(url) {
      this.readingChallenge.book_image = url;
      this.setValueToFormAttribute(this.formData, "book_image", url);
    },
    getDateDuration() {
      if (
        this.readingChallenge.start_date == "" ||
        this.readingChallenge.end_date == ""
      )
        return "";
      const different =
        new Date(this.readingChallenge.end_date) -
        new Date(this.readingChallenge.start_date);
      return this.formatDifferentDays(different);
    },
  },
  computed: {
    hasStartDate() {
      return this.readingChallenge.start_date == "";
    },
  },
};
</script>

<style></style>
