<template>
  <section class="ReviewItem container w-100 border rounded-lg p-2 space-y-2">
    <a
      class="d-flex justify-content-start align-items-center text-decoration-none cursor-pointer"
    >
      <img
        class="sp-logo-sm rounded-full mr-2"
        src="https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2F1268992.jpg?alt=media&token=c863c8cd-f68c-4a87-b345-0e0014e29240"
      />
      <p class="m-0 text-sp-dark">Kosalvireak</p>
    </a>
    <p class="text-xs text-sp-gray">Reviewed on May 24, 2022</p>
    <div class="w-100 min-h-12 border border-gray-100 rounded-lg p-2">
      This book is great
    </div>

    <div class="d-flex justify-content-end space-x-4">
      <span
        class="cursor-pointer hover:bg-gray-200 px-2 py-1 rounded-lg text-md"
      >
        <i class="fa-regular fa-thumbs-down fa-xl mr-1"></i>12
      </span>
      <span
        class="cursor-pointer hover:bg-gray-200 px-2 py-1 rounded-lg text-md"
      >
        <i class="fa-regular fa-thumbs-up fa-xl mr-1"></i> 3
      </span>
    </div>
  </section>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
export default {
  name: "ReviewItem",
  components: { MDBTextarea },
};
</script>

<style>
</style>