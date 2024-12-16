<template>
  <div>
    <div class="NotificationDropdown w-96">
      <h5
        class="d-flex align-items-center justify-content-center fw-bold mb-0"
        style="height: 50px; border-bottom: 1px solid gray"
      >
        Notification
      </h5>
    </div>
    <div
      class="NotificationContent min-h-60 max-h-96 w-96 flex-center flex-column justify-content-start"
    >
      <div v-if="isLoading" class="flex-center min-h-60">
        <Loader :size="20" />
      </div>
      <template v-else>
        <template v-if="items.length > 0">
          <NotificationItem v-for="item in items" :key="item" :item="item" />
        </template>
        <div v-else class="notification-list loader flex-center">
          Your notification is empty
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import NotificationItem from "./NotificationItem.vue";
export default {
  name: "NotificationDropdown",
  components: { NotificationItem },
  props: {
    isShow: Boolean,
  },
  data() {
    return {
      items: [],
      isLoading: false,
    };
  },
  methods: {
    async getNotification() {
      console.log("getNotification");

      this.isLoading = true;
      this.items = await this.$store.dispatch("getSavedBooksNotification");
      this.isLoading = false;
    },
    getDateDisplay(num) {
      if (num == 0) {
        return "Today";
      } else {
        return num + " days ago";
      }
    },
  },

  watch: {
    isShow: {
      handler(oldAuthor, newAuthor) {
        // if (newAuthor == true) {
        //   this.getNotification();
        // }
      },
    },
  },
  async mounted() {
    this.getNotification();
  },
};
</script>

<style  scoped></style>