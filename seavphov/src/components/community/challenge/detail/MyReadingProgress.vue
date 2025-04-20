<template>
  <section
    class="MyReadingProgress card p-4 ring-1 ring-gray-300 position-relative"
  >
    <p class="h5">My Reading Progress</p>
    <div class="ProgressInfo">
      <p><b>Started On:</b>{{ formatDate(myProgress.created_at) }}</p>
      <Progress
        class="w-full"
        :progress="myProgress.progress"
        label="Progress"
        label-position="outside"
        label-progress
        size="md"
      />
    </div>
    <Dropdown
      id="reading-progress-dropdown"
      id_content="reading-progress-dropdown_content"
      placement="bottom-end"
      class="position-absolute top-4 end-4"
    >
      <template #button>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg">
          <i class="fas fa-ellipsis-v fa-xl"></i></div
      ></template>
      <template #content>
        <ul class="py-2 mt-0 w-fit">
          <li>
            <p
              :class="dropdownItemClass"
              @click="showUpdateProgressPopup = true"
            >
              Update progress
            </p>
          </li>
          <li>
            <p :class="dropdownItemClass" @click="toRouteName('edit-profile')">
              Withdraw
            </p>
          </li>
        </ul>
      </template>
    </Dropdown>
    <UpdateProgressPopup
      v-if="showUpdateProgressPopup"
      :progress="myProgress"
      @on-close="showUpdateProgressPopup = false"
    />
  </section>
</template>

<script>
import UpdateProgressPopup from "./UpdateProgressPopup.vue";
export default {
  name: "MyReadingProgress",
  components: { UpdateProgressPopup },
  data() {
    return {
      showUpdateProgressPopup: false,
    };
  },
  props: {
    myProgress: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style>
</style>