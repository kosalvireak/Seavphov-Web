<template>
  <div>
    <div class="NotificationDropdown w-96">
      <p
        class="h4 flex-center mb-0"
        style="height: 50px; border-bottom: 1px solid gray"
      >
        Notification
      </p>
    </div>
    <div
      class="NotificationContent min-h-60 max-h-96 w-96 mb-2 flex-center flex-column justify-content-start overflow-x-hidden overflow-y-auto"
    >
      <div v-if="isLoading" class="flex-center min-h-60">
        <Loader :size="20" />
      </div>
      <template v-else>
        <template v-if="items.length > 0">
          <NotificationItem v-for="item in items" :key="item" :item="item" />

          <p
            v-if="shouldShowLoadMore && !isLoadingMore"
            @click.prevent="loadMore()"
            class="text-center bg-gray-100 hover:bg-gray-300 p-2 clickable rounded-lg text-sm w-100"
          >
            Load more
          </p>

          <div v-if="isLoadingMore" class="flex-center min-h-32">
            <Loader :size="20" />
          </div>
        </template>

        <div v-else class="notification-list min-h-60 loader flex-center">
          <p>Your notification is empty!</p>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import NotificationController from "../../controllers/NotificationController";
import NotificationItem from "./NotificationItem.vue";
export default {
  name: "NotificationDropdown",
  components: { NotificationItem },
  data() {
    return {
      items: [],
      isLoading: false,
      isLoadingMore: false,
      last_page: 1,
      current_page: 1,
      total: 6, // for hide if length less then paginate
    };
  },
  methods: {
    async getNotifications() {
      let params = new URLSearchParams();
      params.append("page", this.current_page);
      const response = await NotificationController.getNotifications(params);
      this.items = this.items.concat(response.items);
      this.current_page = response.pagination.current_page;
      this.last_page = response.pagination.last_page;
      this.total = response.pagination.total;
    },
    async load() {
      this.isLoading = true;
      await this.getNotifications();
      this.isLoading = false;
    },
    async loadMore() {
      this.isLoadingMore = true;
      this.current_page += 1;
      await this.getNotifications();
      this.isLoadingMore = false;
    },
  },
  computed: {
    shouldShowLoadMore() {
      return this.current_page < this.last_page;
    },
  },
  async mounted() {
    await this.load();
  },
};
</script>

<style scoped></style>
