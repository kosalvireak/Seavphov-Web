<template>
  <div class="MyBook card my-4" >
    <div class="row container-sm m-0 p-2">
        <router-link
      :to="`/book/${book.id}`"
      class="col-md-3 d-flex-center bg-success-subtle hover-zoom rounded-7 p-2"
    >
        <img
          :src="book.images"
          class="card-img img-fluid m-2 book_image p-1 rounded-7"
          alt="book_image"
          style="object-fit: contain"
        />
    </router-link>
      <div class="col-md-9">
        <div class="card-body">
          <h5 class="card-title fw-bold truncate-2-lines">{{ book.title }}</h5>
          <p class="card-text truncate-2-lines">
            {{ book.descriptions }}
          </p>
          <p class="card-text">
            <ul>
                <li> <span class="fw-bold">Author:</span>{{ book.author }}</li>
                <li><span class="fw-bold">Condition: </span>{{ book.condition }}</li>
                <li><span class="fw-bold">Category: </span>{{ book.categories }}</li>
                <li v-if="book.availability"><span class="fw-bold">Available:</span> True</li>
                <li v-else><span class="fw-bold">Available: </span>False</li>
                
            </ul>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
export default {
  name: "MyBook",
  props: { book: Object },
};
</script>
  
  <style scoped>
.truncate-2-lines {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2; /* Number of lines to show */
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
</style>