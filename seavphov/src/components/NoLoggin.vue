<template>
  <div
    class="NoLoggin d-flex align-items-center justify-content-center flex-column"
  >
    <div
      class="bg-white p-5 rounded-7 d-flex align-items-center justify-content-center flex-column"
    >
      <img
        src="/img/nologin.jpg?url"
        alt="no_login_image "
        srcset=""
        style="width: 150px; height: 150px"
      />

      <h4 class="mt-4">You don't have permission.</h4>
      <h5 class="mt-3">Please login.</h5>
      <br />
      <a
        @click="
          () => {
            toRouteName('login');
          }
        "
        class="text-gray"
      >
        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
        Login
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: "NoLoggin",
};
</script>

<style scoped></style>
