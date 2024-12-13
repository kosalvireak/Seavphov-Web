<template>
  <div class="NotificationItem w-100 my-2">
    <router-link
      class="notification-list text-black"
      :to="`/book/${item.book_id}`"
    >
      <div class="grid grid-cols-12 items-center px-2">
        <img
          :src="item.user[0].picture"
          alt="user"
          class="col-span-2 sp-logo-md rounded-pill flex-shrink-0 ring-1 ring-gray-300"
        />
        <div
          class="col-span-8 d-flex flex-column justify-content-center space-y-2"
        >
          <p>
            <b>{{ item.user[0].name }}</b> {{ item.text }}
          </p>
          <p class="text-gray text-sm">
            {{ getDateDisplay(item.date) }}
          </p>
        </div>
        <img
          :src="item.book[0].images"
          alt="Feature image"
          class="col-span-2 h-16 w-10 justify-self-end"
        />
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "NotificationItem",
  props: {
    item: Object,
  },
  methods: {
    getDateDisplay(num) {
      if (num == 0) {
        return "Today";
      } else {
        return num + " days ago";
      }
    },
  },
};
</script>

<style scoped>
p {
  margin: 0px;
}
</style>
