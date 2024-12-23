<template>
  <section class="ReviewItem container w-100">
    <div class="d-flex justify-content-center">
      <img
        class="sp-logo-sm"
        src="https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2F1268992.jpg?alt=media&token=c863c8cd-f68c-4a87-b345-0e0014e29240"
      />
      <p>Kosalvireak</p>
    </div>
    <div class="d-flex justify-content-center align-items-end w-100">
      <div class="border border-gray-100 rounded-lg">This book is great</div>
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