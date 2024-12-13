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
    <div class="NotificationContent w-96 flex-center flex-column">
      <div v-if="isLoading" class="notification-list loader flex-center">
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
      items: [
        {
          user: [
            {
              name: "AA",
              picture:
                "https://pbs.twimg.com/profile_images/685700874434314240/80T5j3HF_400x400.jpg",
            },
          ],
          text: "saved your book",
          book: [
            {
              title: "The Khmer Book of First Words",
              images:
                "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2F61rHvi9IaCS._SY466_.jpg?alt=media&token=3a309d3c-1299-4469-8241-d9ec981aed32",
            },
          ],
          book_id: 46,
          date: 200,
        },
        {
          user: [
            {
              name: "aaa",
              picture:
                "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2Fmaxresdefault%20(2).jpg?alt=media&token=1d50149b-d21b-4166-a378-934ef0a89fa7",
            },
          ],
          text: "saved your book",
          book: [
            {
              title: "The Khmer Book of First Words",
              images:
                "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2F61rHvi9IaCS._SY466_.jpg?alt=media&token=3a309d3c-1299-4469-8241-d9ec981aed32",
            },
          ],
          book_id: 46,
          date: 83,
        },
        {
          user: [
            {
              name: "apple",
              picture:
                "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2Fimages.jpg?alt=media&token=c8f85394-c41b-4bb8-a85c-db7ace65469b",
            },
          ],
          text: "saved your book",
          book: [
            {
              title: "The Khmer Book of First Words",
              images:
                "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2F61rHvi9IaCS._SY466_.jpg?alt=media&token=3a309d3c-1299-4469-8241-d9ec981aed32",
            },
          ],
          book_id: 46,
          date: 197,
        },
      ],
      isLoading: false,
    };
  },
  methods: {
    async getNotification() {
      // this.isLoading = true;
      // this.items = await this.$store.dispatch("getSavedBooksNotification");
      // console.log("this.items", this.items.length);
      // this.isLoading = false;
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
        if (newAuthor == true) {
          this.getNotification();
        }
      },
    },
  },
  async mounted() {
    this.getNotification();
  },
};
</script>

<style  scoped></style>