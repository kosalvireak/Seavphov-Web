<template>
  <a @click="onClickBack()" class="text-gray clickable">
    <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
  </a>
</template>

<script>
export default {
  name: "BackRoute",
  props: {
    route: String,
  },
  methods: {
    onClickBack() {
      if (this.route) {
        this.toRouteName(this.route);
      } else {
        this.backRoute();
      }
    },
  },
};
</script>
