<template>
  <div class="MyBook relative">
    <div class="card-item p-2">
      <router-link
        :to="`/book/${book.id}`"
        class="col-md-3 flex-center hover-zoom rounded-7 p-2"
      >
        <img
          :src="book.images"
          class="book_image img-fluid object-contain"
          alt="book image"
        />
      </router-link>
      <div class="col-md-9">
        <div class="space-y-2">
          <h5 class="font-bold truncate-2-lines"></h5>
          <p class="h5 truncate-2-lines pr-10">
            {{ book.title }}
          </p>
          <p class="truncate-2-lines text-base">
            {{ book.descriptions }}
          </p>
          <p><span class="font-bold">Author:</span>{{ book.author }}</p>
          <p><span class="font-bold">Condition: </span>{{ book.condition }}</p>
          <p><span class="font-bold">Category: </span>{{ book.categories }}</p>
          <FwbButton :color="buttonColor" class="px-2 text-xs w-fit">{{
            buttonText
          }}</FwbButton>
        </div>
      </div>
    </div>
    <MyBookDropdown
      :id="book.id"
      :key="book.id"
      :book="book"
      class="absolute right-4 top-4"
      @change="ChangeAvailability()"
    />
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
