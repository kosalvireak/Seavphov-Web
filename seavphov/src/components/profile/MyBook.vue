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
          <h5 class="font-bold ellipsis-2"></h5>
          <p class="h5 ellipsis-2 pr-10">
            {{ book.title }}
          </p>
          <p class="ellipsis-2 text-base">
            {{ book.descriptions }}
          </p>
          <p><span class="font-bold">Author:</span>{{ book.author }}</p>
          <p><span class="font-bold">Condition: </span>{{ book.condition }}</p>
          <p><span class="font-bold">Category: </span>{{ book.categories }}</p>
          <Badge :type="buttonColor" size="sm" class="w-fit">{{
            buttonText
          }}</Badge>
          <Badge v-if="book.has_pdf" type="red" size="sm" class="w-fit"
            >PDF</Badge
          >
        </div>
      </div>
    </div>
    <MyBookDropdown
      :id="book.id"
      :key="book.id"
      :book="book"
      class="absolute right-4 top-4"
      @delete-book="$emit('deleteBook', book.id)"
      @change-availability="ChangeAvailability()"
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
