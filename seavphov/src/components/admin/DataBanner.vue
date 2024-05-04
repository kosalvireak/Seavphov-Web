<template>
  <section class="DataBanner shadow-5 rounded-7 d-flex-center m-2">
    <div class="text-black">
      <i :class="icon"></i>
    </div>
    <div class="ms-4 font-Roboto text-black">
      <h2>{{ title }}</h2>
      <h4 class="text-center">{{ number }}</h4>
    </div>
  </section>
</template>

<script>
export default {
  name: "DataBanner",
  props: {
    title: String,
    number: String,
    icon: String,
  },
};
</script>

<style>
.DataBanner {
  width: 20rem;
  height: 10rem;
  background-color: white;
}
</style>