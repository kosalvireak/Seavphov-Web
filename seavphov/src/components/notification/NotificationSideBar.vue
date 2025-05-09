<template>
  <section class="NotificationSideBar">
    <div ref="overlay" class="overlay" id="overlay" @click="closeSidebar()">
      <div ref="sidebar" class="w-96 sidebar" id="sidebar" @click.stop>
        <div class="sidebar-header flex justify-center position-relative">
          <p class="h4 flex-center mb-0">Notification</p>
          <button
            class="close-btn w-8 h-8 hover:bg-gray-200 rounded-lg position-absolute top-50% right-4"
            @click="closeSidebar()"
          >
            <i class="fa fa-times fa-xl" aria-hidden="true"></i>
          </button>
        </div>
        <div class="sidebar-content h-full">
          <NotificationList v-if="modelValue" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import NotificationList from "./NotificationList.vue";
import { FwbSidebar } from "flowbite-vue";
export default {
  name: "NotificationSideBar",
  components: { FwbSidebar, NotificationList },
  props: {
    modelValue: Boolean,
  },
  watch: {
    modelValue: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.openSidebar();
        } else {
          this.closeSidebar();
        }
      },
    },
  },
  methods: {
    openSidebar() {
      this.$refs.overlay?.classList.add("active");
      this.$refs.sidebar?.classList.add("active");
    },
    closeSidebar() {
      this.$refs.sidebar?.classList.remove("active");
      setTimeout(() => {
        this.$refs.overlay?.classList.remove("active");
      }, 300);
      this.emitClose();
    },
    emitClose() {
      this.$emit("update:modelValue", false);
    },
  },
};
</script>

<style scoped>
/* Overlay styles */
.overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.5);
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
  z-index: 1000;
}

.overlay.active {
  opacity: 1;
  pointer-events: auto;
}

/* Sidebar styles */
.sidebar {
  position: fixed;
  top: 0;
  right: 0;
  height: 100%;
  max-width: 100%;
  background-color: var(--background-color);
  box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
  transform: translateX(100%);
  transition: transform 0.3s ease;
}

.sidebar.active {
  transform: translateX(0);
}

.sidebar-header {
  display: flex;
  padding: 1rem;
  border-bottom: 1px solid #ddd;
}

.sidebar-content {
  padding: 1rem 0rem;
}
</style>