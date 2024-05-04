<template>
  <section
    class="LeftSidePanel w-100 h-100 d-flex-center flex-row align-items-start"
  >
    <ul class="w-100">
      <div class="text-lg d-flex-center py-3">
        <a
          class="navbar-brand"
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
            style="height: 60px"
        /></a>
      </div>
      <li class="text-lg">
        <i class="fa fa-table fa-xl ms-3"></i
        ><router-link :to="{ name: 'admin' }">Dashboard</router-link>
      </li>
      <li class="text-lg">
        <i class="fa fa-users fa-xl ms-3"></i>
        <router-link :to="{ name: 'admin.users' }">Users</router-link>
      </li>
      <li class="text-lg">
        <i class="fa fa-book fa-xl ms-3"></i>
        <router-link :to="{ name: 'admin.books' }">Books</router-link>
      </li>
    </ul>
  </section>
</template>

<script>
export default {
  name: "LeftSidePanel",
};
</script>

<style lang="css" scoped>
li {
  color: black !important;
  font-size: larger;
  padding: 15px;
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