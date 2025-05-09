<template>
  <div class="NotificationList h-full overflow-y-auto">
    <div v-if="isLoading" class="flex-center h-96">
      <Loader :size="20" />
    </div>
    <div
      v-else
      class="NotificationContent mb-2 h-full flex-center flex-column justify-content-start overflow-x-hidden overflow-y-auto"
    >
      <template v-if="items.length > 0">
        <NotificationItem
          v-for="item in items"
          :key="item"
          :item="item"
          @delete="deleteNotification"
        />
        <div class="w-100">
          <p
            v-if="shouldShowLoadMore && !isLoadingMore"
            @click.prevent="loadMore()"
            class="text-center bg-gray-100 hover:bg-gray-300 clickable rounded-lg p-2 m-3 text-sm"
          >
            Load more
          </p>
        </div>

        <div v-if="isLoadingMore" class="flex-center min-h-32">
          <Loader :size="20" />
        </div>
      </template>

      <div v-else class="notification-list min-h-60 loader flex-center">
        <p>Your notification is empty!</p>
      </div>
    </div>
  </div>
</template>

<script>
import NotificationController from "../../controllers/NotificationController";
import NotificationItem from "./NotificationItem.vue";
export default {
  name: "NotificationList",
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
    deleteNotification(id) {
      this.items = this.items.filter((item) => item.id !== id);
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

<style scoped>
.NotificationList {
  max-height: calc(100vh - 5rem);
}

.NotificationContent {
  max-height: calc(100vh - 6rem);
}
</style>
