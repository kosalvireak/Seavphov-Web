<template>
  <div
    class="NotificationItem w-100 py-2 hover:bg-gray-200 transition duration-300 ease-in-out"
  >
    <a class="notification-list text-black" :href="routePath">
      <div class="grid grid-cols-12 items-center px-2">
        <img
          :src="item.user_picture"
          alt="user"
          class="col-span-2 sp-logo-md rounded-pill flex-shrink-0 ring-1 ring-gray-300"
        />
        <div
          class="col-span-8 d-flex flex-column justify-content-center space-y-2"
        >
          <p class="text-wrap">
            <b>{{ item.user_name }}</b> {{ item.body }}
          </p>
          <p class="text-gray text-sm">
            {{ formatDifferentDate(item.date) }}
          </p>
        </div>
        <img
          :src="item.object_image"
          alt="Feature image"
          class="col-span-2 h-16 w-10 justify-self-end"
        />
      </div>
    </a>
  </div>
</template>

<script>
export default {
  name: "NotificationItem",
  props: {
    item: Object,
  },
  methods: {
    getDateDisplay(date) {},
  },
  computed: {
    routePath() {
      if (this.item.type == "request-to-join-cop") {
        return `/community/${this.item.object_id}/members#tabs=member-requests`;
      } else if (
        ["approve-cop-join-request", "reject-cop-join-request"].includes(
          this.item.type
        )
      ) {
        return `/community/${this.item.object_id}`;
      } else {
        return `/${this.item.type}/${this.item.object_id}`;
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
