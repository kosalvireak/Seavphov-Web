<template>
  <div class="Book card m-3 my-2 border-start-1 shadow-5-strong">
    <router-link
      :to="`/book/${book.id}`"
      class="d-flex justify-content-center h-50 bg-seavphov-light bg-image hover-zoom"
      style="height: 13rem"
    >
      <img
        :src="book.images"
        class="card-img-top img-fluid rounded"
        alt="<%=book.title %>"
        style="object-fit: contain"
      />
    </router-link>
    <div class="card-body p-0 m-0" style="height: 8rem">
      <div class="ellipsis-container h-50">
        <h6 class="ellipsis p-3 pb-0 m-0 fw-bold">
          {{ book.title }}
        </h6>
      </div>
      <p class="p-0 px-3 m-0 h-20 Condition">Condition: {{ book.condition }}</p>
      <div
        class="d-flex flex-row justify-content-end align-items-center h-20 px-3 Availability"
      >
        <button
          type="button"
          class="btn btn-success d-flex align-items-center justify-content-center w-auto p-0 px-3"
          v-if="book.availability"
          data-mdb-ripple-init
          style="font-size: x-small; height: 2rem"
        >
          Avaliable
        </button>
        <button
          type="button"
          class="btn btn-danger align-items-center justify-content-center w-auto p-0 px-2"
          style="font-size: x-small; height: 2rem"
          data-mdb-ripple-init
          v-else
        >
          Not Avaliable
        </button>
        <input type="text" name="id" value="<%=book.id%>" class="d-none" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Book",
  props: { book: Object },
};
</script>

<style scoped>
.Book {
  height: 304px;
  width: 180px;
}
@media (max-width: 768px) {
  .Book {
    height: 16rem;
    width: 10rem;
    margin: 0.5rem !important;
  }
  .Condition {
    display: none;
  }
  .Availability {
    height: 50% !important;
  }
}
</style>