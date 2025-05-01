<template>
  <div
    class="loader"
    :style="{
      width: size + 'px',
      height: size + 'px',
      'font-size': size + 'px',
      color: Color,
    }"
  ></div>
</template>

<script>
export default {
  name: "Loader",
  props: {
    size: {
      type: Number || String,
      default: 15,
    },
    Color: {
      type: String,
      default: "#000000",
    },
  },
};
</script>

<style scoped>
.loader {
  aspect-ratio: 2;
  --_g: no-repeat radial-gradient(circle closest-side, #000 90%, #0000);
  background:
    var(--_g) 0% 50%,
    var(--_g) 50% 50%,
    var(--_g) 100% 50%;
  background-size: calc(100% / 3) 50%;
  animation: l3 1s infinite linear;
}
@keyframes l3 {
  20% {
    background-position:
      0% 0%,
      50% 50%,
      100% 50%;
  }
  40% {
    background-position:
      0% 100%,
      50% 0%,
      100% 50%;
  }
  60% {
    background-position:
      0% 50%,
      50% 100%,
      100% 0%;
  }
  80% {
    background-position:
      0% 50%,
      50% 50%,
      100% 100%;
  }
}
</style>
