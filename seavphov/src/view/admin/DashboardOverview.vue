<template>
  <section class="DashboardOverview flex-center justify-content-start">
    <div v-for="item in items" :key="item">
      <InfoCard :title="item.title" :number="item.number" :icon="item.icon" />
    </div>
  </section>
</template>

<script>
import InfoCard from "../../components/admin/InfoCard.vue";
export default {
  name: "DashboardOverview",
  components: { InfoCard },
  data() {
    return {
      items: [
        {
          title: "Total Users",
          number: null,
          icon: "fa fa-2xl fa-users",
        },
        {
          title: "Total Books",
          number: null,
          icon: " fa fa-2xl fa-book",
        },
      ],
    };
  },
  methods: {
    async adminGetOverviewData() {
      [this.items[0].number, this.items[1].number] = await this.$store.dispatch(
        "adminGetOverviewData",
      );
    },
  },
  mounted() {
    this.adminGetOverviewData();
  },
};
</script>

<style></style>
