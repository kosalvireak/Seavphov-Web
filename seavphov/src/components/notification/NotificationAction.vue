<template>
  <section class="NotificationAction">
    <Dropdown
      id="notification-dropdown"
      id_content="notification-dropdown_content"
      placement="bottom-end"
    >
      <template #button>
        <div
          class="w-8 h-8 flex-center bg-gray-300 rounded-full text-sp-primary"
        >
          <i class="fa fa-ellipsis fa-xl" aria-hidden="true"></i>
        </div>
      </template>
      <template #content>
        <ul class="py-1 mt-0">
          <li>
            <p :class="dropdownItemClass" @click.prevent="markAsRead()">
              Mark as read
            </p>
          </li>
          <li>
            <p :class="dropdownItemClass" @click.prevent="deleteNotification()">
              Delete
            </p>
          </li>
        </ul>
      </template>
    </Dropdown>
  </section>
</template>

<script>
export default {
  name: "NotificationAction",
  props: {
    notification: Object,
  },
  data() {
    return {};
  },
  methods: {
    async markAsRead() {},
    async deleteNotification() {},
  },
};
</script>

<style>
</style>