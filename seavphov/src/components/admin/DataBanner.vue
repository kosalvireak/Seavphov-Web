<template>
  <section class="DataBanner shadow-5 rounded-7 d-flex-center m-2">
    <div class="text-black">
      <i :class="icon"></i>
    </div>
    <div class="ms-4 text-black">
      <h4 class="font-Roboto">{{ title }}</h4>
      <h4 class="font-Roboto text-center">{{ number }}</h4>
    </div>
  </section>
</template>

<script>
export default {
  name: "DataBanner",
  props: {
    title: String,
    number: Number,
    icon: String,
  },
};
</script>

<style>
.DataBanner {
  width: 18rem;
  height: 9rem;
  background-color: white;
}
</style>