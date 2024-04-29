<template>
  <div
    id="carouselExampleInterval"
    class="carousel slide w-100 h-100 rounded-7"
    data-bs-ride="carousel"
  >
    <div class="carousel-inner carousel-img">
      <div class="carousel-item active carousel-img" data-bs-interval="5000">
        <img
          src="/img/cover0.jpg"
          class="d-block w-100 rounded-7"
          alt="Wild Landscape"
          style="object-fit: cover; height: 300px"
        />
      </div>
      <div class="carousel-item carousel-img" data-bs-interval="5000">
        <img
          src="/img/cover1.jpg"
          class="d-block w-100 rounded-7"
          alt="Wild Landscape"
          style="object-fit: cover; height: 300px"
        />
      </div>
      <div class="carousel-item carousel-img" data-bs-interval="5000">
        <img
          src="/img/cover2.jpg"
          class="d-block w-100 rounded-7"
          alt="Wild Landscape"
          style="object-fit: cover; height: 300px"
        />
      </div>
      <div class="carousel-item carousel-img" data-bs-interval="5000">
        <img
          src="/img/cover3.jpg"
          class="d-block w-100 rounded-7 carousel-img"
          alt="Wild Landscape"
          style="object-fit: cover; height: 300px"
        />
      </div>
    </div>
    <button
      class="carousel-control-prev carousel-img"
      type="button"
      data-bs-target="#carouselExampleInterval"
      data-bs-slide="prev"
    >
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button
      class="carousel-control-next carousel-img"
      type="button"
      data-bs-target="#carouselExampleInterval"
      data-bs-slide="next"
    >
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.carousel-img {
  height: 300px !important;
  border-radius: 1rem;
}
@media (max-width: 576px) {
  .carousel-img {
    height: 250px !important;
  }
}
#carouselExampleInterval{
  margin-bottom: 50px;
}

</style>