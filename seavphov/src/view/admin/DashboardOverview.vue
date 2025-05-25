<template>
  <section
    class="DashboardOverview d-flex flex-wrap justify-content-start gap-4"
  >
    <InfoCard
      v-for="item in items"
      :key="item"
      :title="item.title"
      :number="item.number"
      :icon="item.icon"
      :routeName="item.routeName"
    />
  </section>
</template>

<script>
import InfoCard from "../../components/admin/InfoCard.vue";
import AdminController from "../../controllers/admin/AdminController.js";
export default {
  name: "DashboardOverview",
  components: { InfoCard },
  data() {
    return {
      items: [
        {
          title: "Users",
          number: null,
          icon: "fa fa-xl fa-user",
          routeName: "admin.users",
        },
        {
          title: "Books",
          number: null,
          icon: " fa fa-xl fa-book",
          routeName: "admin.books",
        },
        {
          title: "Communities",
          number: null,
          icon: " fa fa-xl fa-users",
          routeName: "admin.communities",
        },
        {
          title: "Banners",
          number: null,
          icon: " fa fa-xl fa-window-maximize",
          routeName: "admin.banners",
        },
        {
          title: "Discussions",
          number: null,
          icon: " fa fa-xl fa-comments",
          routeName: "discussion",
        },
      ],
    };
  },
  methods: {
    async adminGetOverviewData() {
      const response = await AdminController.adminGetOverviewData();
      this.items[0].number = response.totalUsers;
      this.items[1].number = response.totalBooks;
      this.items[2].number = response.totalCommunity;
      this.items[3].number = response.totalBanners;
      this.items[4].number = response.totalDiscussions;
    },
  },
  mounted() {
    this.adminGetOverviewData();
  },
};
</script>

<style></style>
