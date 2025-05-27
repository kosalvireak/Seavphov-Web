<template>
  <div
    class="NotificationItem w-100 py-2 hover:bg-gray-200 transition duration-300 ease-in-out position-relative flex-center justify-content-start flex-row"
  >
    <div class="min-w-2 h-2 mx-2">
      <p
        v-if="!notification.hasRead"
        class="bg-blue-600 rounded-full min-w-2 h-2"
      ></p>
    </div>
    <div
      class="notification-item flex-center flex-row !justify-start w-100 text-black space-x-2"
      @click="markAsRead"
    >
      <FwbAvatar :img="notification.user_picture" rounded size="md" />
      <div
        class="d-flex flex-column justify-content-center space-y-2 text-sm w-62"
      >
        <p class="text-wrap">
          <b>{{ notification.user_name }}</b> {{ notification.body }}
        </p>
        <p class="text-gray-400">
          {{ formatDifferentDate(notification.date) }}
        </p>
      </div>
      <!-- <div class="min-w-10 w-10 h-16 flex-center">
        <img
          :src="item.object_image"
          alt="Feature image"
          class="justify-self-end image-fluid"
        />
      </div> -->
    </div>
    <NotificationAction
      :notification="notification"
      @toggle-read="toggleRead()"
      @delete="$emit('delete', $event)"
      class="position-absolute top-50% right-2 justify-self-end notification-action"
    />
  </div>
</template>

<script>
import NotificationController from "../../controllers/NotificationController";
import NotificationAction from "./NotificationAction.vue";
export default {
  name: "NotificationItem",
  components: { NotificationAction },
  props: {
    item: Object,
  },
  data() {
    return {
      notification: this.item,
    };
  },
  methods: {
    toggleRead() {
      this.notification.hasRead = !this.notification.hasRead;
    },
    async markAsRead() {
      const response = await NotificationController.markAsRead(
        this.notification.id,
      );
      if (response) {
        window.open(this.notification.url);
      }
    },
  },
};
</script>

<style scoped>
p {
  margin: 0px;
}
.notification-action {
  display: none;
}

.NotificationItem:hover > .notification-action {
  display: flex;
}
</style>
