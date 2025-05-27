<template>
  <section class="DashboardOverview space-y-8">
    <div
      class="w-100 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 w-full"
    >
      <InfoCard
        v-for="item in items"
        :key="item"
        :title="item.title"
        :number="item.number"
        :icon="item.icon"
        :routeName="item.routeName"
      />
    </div>
    <div class="GraphSection w-100 grid grid-cols-1 lg:grid-cols-2">
      <UserTrend />
      <BookTrend />
      <BookCondition />
      <BookCategory />
    </div>
  </section>
</template>

<script>
import BookCondition from "../../components/admin/dashboard/BookCondition.vue";
import BookCategory from "../../components/admin/dashboard/BookCategory.vue";
import BookTrend from "../../components/admin/dashboard/BookTrend.vue";
// Users
import UserTrend from "../../components/admin/dashboard/UserTrend.vue";
import InfoCard from "../../components/admin/InfoCard.vue";
import AdminController from "../../controllers/admin/AdminController.js";
export default {
  name: "DashboardOverview",
  components: { InfoCard, BookTrend, BookCategory, BookCondition, UserTrend },
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
