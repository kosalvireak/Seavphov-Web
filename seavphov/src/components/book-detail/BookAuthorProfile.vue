<template>
  <section
    class="BookAuthorProfile space-y-3 ring-1 ring-gray-300 p-6 rounded-2"
  >
    <a
      :href="`/profile/${owner.uuid}`"
      class="d-flex text-decoration-none space-x-3 text-black"
    >
      <img
        :src="owner.picture"
        class="sp-logo-lg min-w-20 rounded-full ring-2 ring-gray-300"
        alt="user profile"
      />
      <div class="d-flex flex-column justify-content-evenly">
        <p class="h5">
          {{ owner.name }}
        </p>
        <p><span>Member since: </span>{{ formatDate(owner.created_at) }}</p>
      </div>
    </a>
    <div v-if="inValidProperty(owner, 'phone')" class="d-flex">
      <span class="min-w-8"><i class="fas fa-phone fa-lg me-1"></i></span>
      <p>
        {{ owner.phone }}
      </p>
    </div>
    <div v-if="inValidProperty(owner, 'location')" class="d-flex text-base">
      <span class="min-w-8"><i class="fas fa-map-pin fa-lg me-1"></i></span>
      <p>
        {{ owner.location }}
      </p>
    </div>
  </section>
</template>

<script>
import SocialMediaList from "../SocialMediaList.vue";
export default {
  name: "BookAuthorProfile",
  components: { SocialMediaList },
  props: {
    owner: Object,
  },
};
</script>

<style scoped>
p {
  margin: 0;
}
</style>
