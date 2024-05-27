<template>
  <div>
    <div class="notification-ui_dd-header">
      <h5
        class="d-flex align-items-center justify-content-center fw-bold"
        style="height: 50px; border-bottom: 1px solid gray"
      >
        Notification
      </h5>
    </div>
    <div class="notification-ui_dd-content d-flex-center flex-column">
      <div v-if="isLoading" class="notification-list loader d-flex-center">
        <Loader :size="20" />
      </div>
      <div v-else>
        <div v-if="items.length > 0">
          <div v-for="item in items" :key="item">
            <router-link
              class="notification-list text-black"
              :to="`/book/${item.book_id}`"
            >
              <div class="notification-list_img">
                <img
                  :src="item.user[0].picture"
                  alt="user"
                  class="notification_img"
                />
              </div>
              <div class="notification-list_detail">
                <p>
                  <b>{{ item.user[0].name }}</b> {{ item.text }}
                </p>
                <p>
                  <small>{{ getDateDisplay(item.date) }}</small>
                </p>
              </div>
              <div class="notification-list_feature-img">
                <img
                  :src="item.book[0].images"
                  alt="Feature image"
                  class="book_img"
                />
              </div>
            </router-link>
          </div>
        </div>
        <div v-else class="notification-list loader d-flex-center">
          Your notification is empty
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loader from "./Loader.vue";
export default {
  name: "NotificationDropdown",
  components: { Loader },
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
      this.isLoading = true;
      this.items = await this.$store.dispatch("getSavedBooksNotification");
      console.log("this.items", this.items.length);
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

<style  scoped>
.cd__main {
  display: block !important;
}

.notification-ui a:after {
  display: none;
}

.notification-ui_icon {
  position: relative;
}

.notification-ui_icon .unread-notification {
  display: inline-block;
  height: 7px;
  width: 7px;
  border-radius: 7px;
  background-color: #66bb6a;
  position: absolute;
  top: 7px;
  left: 12px;
}

@media (min-width: 900px) {
  .notification-ui_icon .unread-notification {
    left: 20px;
  }
}

.notification-ui_dd {
  padding: 0;
  border-radius: 10px;
  -webkit-box-shadow: 0 5px 20px -3px rgba(0, 0, 0, 0.16);
  box-shadow: 0 5px 20px -3px rgba(0, 0, 0, 0.16);
  border: 0;
  max-width: 400px;
}

@media (min-width: 900px) {
  .notification-ui_dd {
    min-width: 400px;
    position: absolute;
    left: -192px;
    top: 70px;
  }
}

.notification-ui_dd .notification-ui_dd-header {
  border-bottom: 1px solid #ddd;
  padding: 15px;
}

.notification-ui_dd .notification-ui_dd-header h3 {
  margin-bottom: 0;
}

.notification-ui_dd-content {
  max-height: 500px;
  overflow: auto;
  /* min-height: 397px; */
  min-width: 203px;
}

.notification-list {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  padding: 20px 0;
  margin: 0 25px;
  border-bottom: 1px solid #ddd;
}

.notification-list--unread {
  position: relative;
}

.notification-list--unread:before {
  content: "";
  position: absolute;
  top: 0;
  left: -25px;
  height: calc(100% + 1px);
  border-left: 2px solid #29b6f6;
}

.notification-list_img img {
  height: 48px;
  width: 48px;
  border-radius: 50px;
  margin-right: 20px;
}

.notification-list_detail p {
  width: 211px;
  margin-bottom: 5px;
  line-height: 1.2;
}

.white-mode {
  text-decoration: none;
  padding: 17px 40px;
  background-color: yellow;
  border-radius: 3px;
  color: black;
  transition: 0.35s ease-in-out;
  position: fixed;
  left: 15px;
  bottom: 15px;
}
.loader {
  width: 87%;
  height: 101px;
  justify-content: center;
}

.notification_img {
  height: 38px;
  width: 38px;
  object-fit: cover;
}
.book_img {
  height: 60px;
  width: 38px;
  object-fit: cover;
  margin-left: 20px;
}
</style>