<template>
  <div class="MyBook card my-4">
    <div class="row container-sm m-0 p-2 relative">
      <router-link
        :to="`/book/${book.id}`"
        class="col-md-3 flex-center bg-success-subtle hover-zoom rounded-7 p-2"
      >
        <img
          :src="book.images"
          class="card-img img-fluid m-2 book_image p-1 rounded-7"
          alt="book_image"
          style="object-fit: contain"
        />
      </router-link>
      <div class="col-md-9">
        <div class="d-flex justify-content-between p-2">
          <div class="space-y-4">
            <h5 class="card-title fw-bold truncate-2-lines">
              {{ book.title }}
            </h5>
            <p class="card-text truncate-2-lines">
              {{ book.descriptions }}
            </p>
            <p class="card-text"></p>
            <ul class="space-y-2">
              <li><span class="fw-bold">Author:</span>{{ book.author }}</li>
              <li>
                <span class="fw-bold">Condition: </span>{{ book.condition }}
              </li>
              <li>
                <span class="fw-bold">Category: </span>{{ book.categories }}
              </li>
              <FwbButton :color="buttonColor" class="mt-2 px-2 text-xs w-fit">{{
                buttonText
              }}</FwbButton>
            </ul>
          </div>
          <MyBookDropdown
            :id="book.id"
            :key="book.id"
            :book="book"
            class="absolute right-4"
            @change="ChangeAvailability()"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MyBookDropdown from "./MyBookDropdown.vue";
export default {
  name: "MyBook",
  components: {
    MyBookDropdown,
  },
  props: { book: Object },
  methods: {
    ChangeAvailability() {
      this.book.availability = !this.book.availability;
    },
  },
  computed: {
    buttonColor() {
      return this.book.availability ? "green" : "red";
    },
    buttonText() {
      return this.book.availability ? "AVAILABLE" : "NOT AVAILABLE";
    },
  },
};
</script>

<style scoped>
.dropdown-menu {
  min-width: 75px !important;
}

.dropdown-toggle {
  width: 75px !important;
}

.truncate-2-lines {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  /* Number of lines to show */
  -webkit-box-orient: vertical;
}

.MyBook {
  min-height: 16rem;
}

.book_image {
  height: 14rem;
  width: 14rem;
}

@media (max-width: 768px) {
  .book_image {
    height: 12rem;
    width: 12rem;
  }
}

.custom-dropdown {
  background-color: #9db673;
}
</style>
