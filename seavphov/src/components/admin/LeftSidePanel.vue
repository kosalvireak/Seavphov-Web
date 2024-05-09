<template>
  <section
    class="LeftSidePanel w-100 h-100 d-flex-center flex-row align-items-start shadow-5"
  >
    <ul class="w-100">
      <div class="text-sm d-flex-center py-3">
        <a
          class="navbar-brand cursor-pointer"
          @click="
            () => {
              this.$router.push('/home');
            }
          "
          ><img
            src="/img/book.png"
            alt="book logo"
            srcset=""
            class="img-fluid"
            style="height: 45px"
        /></a>
      </div>
      <li class="text-sm" @click="toRoute('admin')">
        <i class="fa fa-table fa-xl ms-3"></i>Dashboard
      </li>
      <li class="text-sm" @click="toRoute('admin.users')">
        <i class="fa fa-users fa-xl ms-3"></i>
        Users
      </li>
      <li class="text-sm" @click="toRoute('admin.books')">
        <i class="fa fa-book fa-xl ms-3"></i>
        Books
      </li>
      <li class="text-sm" @click="toRoute('admin.banners')">
        <i class="fa fa-th-large fa-xl ms-3"></i>
        Banners
      </li>
    </ul>
  </section>
</template>

<script>
export default {
  name: "LeftSidePanel",
  methods: {
    toRoute(route) {
      this.$router.push({ name: route });
    },
  },
};
</script>

<style lang="css" scoped>
.LeftSidePanel {
  min-width: 82px !important;
}
li {
  color: black !important;
  font-size: small;
  padding: 15px;
  cursor: pointer;
}
li:hover {
  background-color: #37aba39a !important;
  transition: 0.3s;
}
i {
  width: 3rem;
}
a {
  color: black;
}
a:hover {
  color: black;
}
</style>