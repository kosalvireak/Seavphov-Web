<template>
  <section class="NotFound">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
      <div class="mx-auto max-w-screen-sm flex-center flex-col">
        <h1
          class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-sp-primary"
        >
          404
        </h1>
        <p
          class="mb-4 text-3xl tracking-tight font-bold text-sp-primary md:text-4xl"
        >
          Something's missing.
        </p>
        <p class="mb-4 text-lg font-light text-dark">
          Sorry, we can't find that page. You'll find lots to explore on the
          home page.
        </p>
        <LoadingButton @click="toRouteName('home')" color="yellow">
          Back to Homepage
        </LoadingButton>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "NotFound",
};
</script>

<style></style>
