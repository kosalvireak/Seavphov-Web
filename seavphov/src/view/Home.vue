<template>

  <!--Homepage Image -->
  <div class="w-100 h-100">
    <div class="container-sm d-flex-center my-3" style="width: 100%">
      <img
        src="/img/login_background.png"
        class="img-fluid"
        style="max-height: 400px; object-fit: cover; width: 100%"
      />
    </div>

    <!-- Filter -->
    <Filter class="container-sm" />
    <!-- <div class="mt-3 row">
      <PaginatedBook />
    </div> -->
    <div class="mt-3 row" v-if="false">
      <div
        class="d-flex align-item-center justify-content-center col-xl-3 col-md-5 col-sm-12 mt-md-2"
      >
        <div
          class="d-flex align-item-center justify-content-center flex-column w-100 rounded-7 mt-md-5 px-2 bg-seavphov-light"
          style="height: 31rem"
          :class="{ 'h-3rem': toggleFilter }"
        >
          <div
            class="ms-3 d-flex align-items-start justify-content-between"
            :class="{ 'margin-top': toggleFilter }"
            style="display: flex"
          >
            <div class="d-flex align-items-center justify-content-center">
              <h4 class="text-center text-gray fw-bold text-seavphov">
                Filter
              </h4>
            </div>
            <div
              @click="ToggleFilter()"
              class="d-flex justify-content-center me-2"
            >
              <span v-if="toggleFilter"
                ><i class="fas fa-arrow-down fa-xl"></i
              ></span>
              <span v-else><i class="fas fa-arrow-up fa-xl"></i></span>
            </div>
          </div>

          <div :class="{ 'd-none': toggleFilter }">
            <div class="category ms-3">
              <h5 class="fw-bold text-gray">Category</h5>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Categories"
                  value="Fiction"
                  id="Fiction"
                />
                <label class="form-check-label" for="Fiction">Fiction</label>
                <br />
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Categories"
                  value="Novel"
                  id="Novel"
                />
                <label class="form-check-label" for="Novel">Novel</label><br />
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Categories"
                  value="Text-Book"
                  id="Text-Book"
                />
                <label class="form-check-label" for="Text-Book">Text-Book</label
                ><br />
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Categories"
                  value="History"
                  id="History"
                />
                <label class="form-check-label" for="History">History</label
                ><br />
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Categories"
                  value="Science"
                  id="Science"
                />
                <label class="form-check-label" for="Science">Science</label
                ><br />
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Categories"
                  value="Fantasy"
                  id="Fantasy"
                />
                <label class="form-check-label" for="Fantasy">Fantasy</label
                ><br />
              </div>
            </div>
            <div class="condition ms-3">
              <h5 class="fw-bold text-gray">Condition</h5>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Condition"
                  value="As-new"
                  id="As-new"
                />
                <label class="form-check-label" for="As-new">As-new</label>
                <br />
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Condition"
                  value="Good"
                  id="Good"
                />
                <label class="form-check-label" for="Good">Good</label><br />
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="Condition"
                  value="Well-worn"
                  id="Well-worn"
                />
                <label class="form-check-label" for="Well-worn"
                  >Well-worn</label
                >
              </div>
            </div>
            <div class="availability ms-3">
              <h5 class="fw-bold text-gray">Availability</h5>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="Availability"
                  v-model="Availability"
                  value="true"
                  id="Avaliable"
                />
                <label class="form-check-label" for="Avaliable">
                  Avaliable
                </label>
                <br />
                <input
                  class="form-check-input"
                  type="radio"
                  name="Availability"
                  v-model="Availability"
                  value="false"
                  id="NotAvaliable"
                />
                <label class="form-check-label" for="NotAvaliable">
                  Not Avaliable
                </label>
                <br />
              </div>
            </div>
            <button
              class="btn btn-danger mt-2 ms-3"
              @click="clearFilter()"
              style="width: 6rem"
            >
              clear
            </button>
          </div>
        </div>
      </div>
      <div class="col-xl-9 col-md-7 col-sm-12">
        <RenderBook :books="filteredBooks" />
      </div>
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import PaginatedBook from "../components/PaginatedBook.vue";
import Filter from "../components/Filter.vue";
export default {
  name: "Home",
  components: { RenderBook, PaginatedBook, Filter },
  data() {
    return {
      reloaded: false,
    };
  },
  // computed: {
  //   filteredBooks() {
  //     let filteredBooks = this.Books;
  //     // check if any filter array has change
  //     if (
  //       this.Categories.length !== 0 ||
  //       this.Condition.length !== 0 ||
  //       this.Availability !== null
  //     ) {
  //       // filter category
  //       if (this.Categories.length !== 0) {
  //         filteredBooks = filteredBooks.filter((book) =>
  //           this.Categories.includes(book.categories)
  //         );
  //       }
  //       // filter condition
  //       if (this.Condition.length !== 0) {
  //         filteredBooks = filteredBooks.filter((book) =>
  //           this.Condition.includes(book.condition)
  //         );
  //       }
  //       // filter availability
  //       if (this.Availability == "true") {
  //         filteredBooks = filteredBooks.filter(
  //           (book) => book.availability == true
  //         );
  //       } else if (this.Availability == "false") {
  //         filteredBooks = filteredBooks.filter(
  //           (book) => book.availability == false
  //         );
  //       }
  //       return filteredBooks;
  //     } else {
  //       return this.Books;
  //     }
  //   },
  //   fetchBooks() {
  //     return this.$store.state.fetchBooks;
  //   },
  // },
  // methods: {
  //   ToggleFilter() {
  //     this.toggleFilter = !this.toggleFilter;
  //   },
  //   // reset filtered array and reset availability
  //   clearFilter() {
  //     this.Categories = [];
  //     this.Condition = [];
  //     this.Availability = null;
  //   },
  //   onChangePage(currentPage) {
  //     console.log("currentPage", currentPage);
  //   },
  // },
  mounted() {
    if (!localStorage.getItem("reloaded")) {
      location.reload();
      localStorage.setItem("reloaded", true);
    }
  },
};
</script>

<style scoped>
label {
  font-size: 0.9rem;
}
.h-3rem {
  height: 3rem !important;
}
.margin-top {
  margin-top: 20px !important;
}
</style>
