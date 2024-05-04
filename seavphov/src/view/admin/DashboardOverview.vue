<template>
  <section class="DashboardOverview p-5 d-flex-center justify-content-start">
    <div v-for="item in items" :key="item">
      <DataBanner :title="item.title" :number="item.number" :icon="item.icon" />
    </div>
  </section>
</template>

<script>
import DataBanner from "../../components/admin/DataBanner.vue";
export default {
  name: "DashboardOverview",
  components: { DataBanner },
  data() {
    return {
      items: [
        {
          title: "Total Users",
          number: "55",
          icon: "fa fa-2xl fa-users",
        },
        {
          title: "Total Books",
          number: "189",
          icon: " fa fa-2xl fa-book",
        },
      ],
    };
  },
};
</script>

<style>
</style>