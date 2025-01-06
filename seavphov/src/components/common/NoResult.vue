<template>
  <div class="NoResult h-100 w-100">
    <div class="h-10 d-flex align-items-center justify-content-end m-1">
      <h6 class="p-0 m-0 fw-bold font-75">Result: 0 Book</h6>
    </div>
    <div
      class="h-auto d-flex flex-column justify-content-center align-items-center m-5"
    >
      <img
        src="/img/notfound.png"
        alt="not found"
        class="w-25 img-fluid mb-3 rounded rounded-7"
      />
      <h3>No books found...!</h3>
    </div>
  </div>
</template>

<script>
export default {
  name: "NoResult",
};
</script>

<style></style>
