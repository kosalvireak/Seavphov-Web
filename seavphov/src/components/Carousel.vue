<template>
  <div id="carouselExampleInterval" class="carousel slide w-100 h-500 rounded-7" data-bs-ride="carousel"
    data-bs-interval="5000">
    <div class="carousel-inner carousel-img" style="height: auto;">
      <div v-for="(book, index) in books" :key="index" :class="{ 'carousel-item': true, 'active': index === 0 }">
        <div class="row align-items-start m-2">
          <div class="col">
            <h1 class="mb-0">{{ book.title }}</h1>
            <div class="row my-3 ">
              <div class="col d-flex flex-row">
                <h5 class="me-3">By: {{ book.author }}</h5>
                <h5>Condition: {{ book.condition }}</h5>
              </div>
            </div>
            <div class="description">{{ book.descriptions }}</div>

            <div class="col my-3">
              <router-link :to="`/book/${book.id}`" class="d-flex justify-content-start h-50  hover-zoom"
                style="height: 13rem">
                <button type="button" class="btn">READ MORE</button>
              </router-link>

            </div>
          </div>

          <div class="col">
            <img :src="book.images" class="d-block w-100 rounded-7" alt="Book Cover"
              style="object-fit: contain; width:200px; height: 300px;">
          </div>
        </div>
      </div>
    </div>

    <div class="carousel-indicators d-flex justify-content-center mt-3">
      <button v-for="(book, index) in books" :key="index" type="button" :data-bs-target="'#carouselExampleInterval'"
        :data-bs-slide-to="index" :class="{ 'active': index === 0 }" aria-current="true"
        :aria-label="'Slide ' + (index + 1)"></button>
    </div>

    <!-- <button class="carousel-control-prev carousel-img" type="button" data-bs-target="#carouselExampleInterval"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next carousel-img" type="button" data-bs-target="#carouselExampleInterval"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button> -->
  </div>
</template>

<script>
export default {
  name: "Book",
  props: {
    books: Array, // Change Object to Array for the props
  },
};
</script>


<style scoped>
.carousel-img {
  /* height: 300px !important; */
  border-radius: 1rem;
}

@media (max-width: 576px) {
  .carousel-img {
    height: 250px !important;
  }
}

h1 {
  color: white;
  font-weight: bold;
  max-width: 700px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

h5 {
  color: white;
}

.description {
  color: lightgray;
  max-width: 600px;
  max-height: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 4;
  white-space: normal;
}

.btn {
  color: white;
  background-color: #9db673;
}

.carousel-indicators {
  position: relative !important;
}
</style>