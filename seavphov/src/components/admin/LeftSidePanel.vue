<template>
  <section
    class="LeftSidePanel w-100 h-100 d-flex flex-column align-items-start shadow-5"
  >
    <ul class="w-100">
      <div class="text-sm flex-center py-3">
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
      <li class="text-sm pt-4 pb-2" @click="toRoute('admin')">
        <i class="fa fa-table fa-xl"></i>
        <p>Dashboard</p>
      </li>
      <li class="text-sm pt-4 pb-2" @click="toRoute('admin.users')">
        <i class="fa fa-users fa-xl"></i>
        <p>Users</p>
      </li>
      <li class="text-sm pt-4 pb-2" @click="toRoute('admin.books')">
        <i class="fa fa-book fa-xl"></i>
        <p>Books</p>
      </li>
      <li class="text-sm pt-4 pb-2" @click="toRoute('admin.banners')">
        <i class="fa fa-th-large fa-xl"></i>
        <p>Banners</p>
      </li>
    </ul>
    <p class="mt-auto cursor-pointer" @click="emitCollab">
      <i v-if="isCollab" class="fa fa-arrow-left fa-xl ms-3 mt-auto"></i>
      <i v-else class="fa fa-arrow-right fa-xl ms-3 mt-auto"></i>
    </p>
  </section>
</template>

<script>
export default {
  name: "LeftSidePanel",
  data() {
    return {
      isCollab: false,
    };
  },
  methods: {
    toRoute(route) {
      this.$router.push({ name: route });
    },
    emitCollab() {
      this.$emit("collabClick", this.isCollab);
      this.isCollab = !this.isCollab;
    },
  },
};
</script>

<style lang="css" scoped>
.LeftSidePanel {
  min-width: 82px !important;
  transition-delay: 1s;
}
li {
  width: inherit;
  color: black !important;
  font-size: small;
  padding: 15px;
  cursor: pointer;
  display: flex;
  align-items: baseline;
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
p {
  width: fit-content;
  height: 20px;
}
</style>