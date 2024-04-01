<template>
  <div class="mb-3">
    <a
      @click="
        () => {
          this.$router.push('/home');
        }
      "
      class="text-gray"
    >
      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to home
    </a>
    <div class="d-flex align-items-center justify-content-center flex-column">
      <h4 class="my-4 text-gray fw-bold">Your are adding a new book.</h4>

      <form style="width: 100%" v-on:submit.prevent="AddBook()" class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="title"
              v-model="book.title"
            />
          </div>
          <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input
              type="text"
              class="form-control"
              id="author"
              v-model="book.author"
            />
          </div>
          <div class="mb-3">
            <label for="descriptions" class="form-label">Descriptions</label>
            <input
              type="text"
              class="form-control"
              id="descriptions"
              v-model="book.descriptions"
            />
          </div>
          <div class="input-group mb-3" style="margin-top: 2rem">
            <label
              class="input-group-text"
              for="condition"
              style="height: 40px; width: 100px"
              >Condition</label
            >
            <select class="form-select" id="condition" v-model="book.condition">
              <option value="AS_NEW" selected>As-new</option>
              <option value="GOOD">Good</option>
              <option value="WELL_WORN">Well-worn</option>
            </select>
          </div>

          <div class="input-group mb-3" style="margin-top: 2rem">
            <label
              class="input-group-text"
              for="categories"
              style="height: 40px; width: 100px"
              >Categories</label
            >
            <select
              class="form-select"
              id="categories"
              v-model="book.categories"
            >
              <option value="FICTION" selected>Fiction</option>
              <option value="NOVEL">Novel</option>
              <option value="TEXT_BOOK">Text-Book</option>
              <option value="HISTORY">History</option>
              <option value="SCIENCE">Science</option>
              <option value="FANTASY">Fantasy</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="images" class="form-label">Book Image</label>
            <input
              type="file"
              class="form-control"
              id="images"
              name="images"
              @change="handleImageChange"
            />
          </div>
          <!-- <div
            class="my-3 mt-3 d-flex align-items-center justify-content-center border border-bdbdbd rounded-7"
            style="width: 100%; height: 242px"
          >
            <img
              v-if="book.images"
              :src="book.images"
              alt="preview_image"
              class="img-fluid h-100"
              style="object-fit: cover"
            />
            <div v-else>
              <p class="text-center">
                Paste a valid image url. <br />
                Your image will preview here
              </p>
            </div>
          </div> -->
          <button type="submit" class="btn btn-primary mt-1">Add Book</button>
          <div></div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddBook",
  data() {
    return {
      book: {
        title: "aaa",
        author: "bbbb",
        images: {},
        descriptions: "cccc",
        condition: "GOOD",
        categories: "NOVEL",
      },
      formData: new FormData(),
    };
  },
  methods: {
    AddBook() {
      this.formData.append("title", this.book.title);
      this.formData.append("author", this.book.author);
      this.formData.append("categories", this.book.categories);
      this.formData.append("condition", this.book.condition);
      this.formData.append("descriptions", this.book.descriptions);
      this.formData.append("availability", 0);
      // for (var key of this.formData.entries()) {
      //   console.log(key[0] + ", " + key[1]);
      // }
      this.$store.dispatch("createBook", this.formData);

      // this.$router.push({ path: `/home/${id}` });
    },
    handleImageChange(event) {
      const selectedFile = event.target.files[0];
      if (selectedFile) {
        // const reader = new FileReader();
        // reader.readAsDataURL(selectedFile);
        // reader.onloadend = () => {
        //   const base64Data = reader.result;
        //   const blob = new Blob([base64Data], { type: selectedFile.type });
        //   this.formData.append("images", blob, selectedFile.name);
        // };
        this.formData.append("images", selectedFile);
        console.log("selectedFile", selectedFile);
      }
    },
  },
};
</script>

<style>
.border-bdbdbd {
  border: 1px !important;
  border-style: solid !important;
  border-color: #bdbdbd !important;
}
</style>