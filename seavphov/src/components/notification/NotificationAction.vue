<template>
  <section class="NotificationAction">
    <FwbDropdown align-to-end close-inside>
      <template #trigger>
        <div
          class="w-8 h-8 flex-center bg-gray-300 rounded-full text-sp-primary"
        >
          <i class="fa fa-ellipsis fa-xl" aria-hidden="true"></i>
        </div>
      </template>
      <nav :class="fwbDropdownNavCss">
        <p
          :class="fwbDropdownItemCss"
          @click.prevent="toggleRead(notification.id)"
        >
          Mark as {{ notification.hasRead ? "read" : "unread" }}
        </p>
        <p
          :class="fwbDropdownItemCss"
          @click.prevent="deleteNotification(notification.id)"
        >
          Delete
        </p>
      </nav>
    </FwbDropdown>
  </section>
</template>

<script>
import NotificationController from "../../controllers/NotificationController";
export default {
  name: "NotificationAction",
  props: {
    notification: Object,
  },
  methods: {
    async toggleRead(id) {
      await NotificationController.toggleRead(id);
      this.$emit("toggle-read");
    },
    async deleteNotification(id) {
      await NotificationController.deleteNotification(id);
      this.$emit("delete", id);
    },
  },
};
</script>

<style></style>
