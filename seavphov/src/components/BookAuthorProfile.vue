<template>
  <div class="d-flex flex-column col-sm-12 col-lg-4 ps-lg-3 p-0 rounded-7">
    <div
      class="bg-seavphov rounded-7 d-flex align-items-center justify-content-center flex-wrap flex-row mt-3 mt-lg-0 bg-seavphov-light px-3"
      style="height: 150px"
    >
      <a :href="profileUrl">
        <div
          class="d-flex justify-content-start flex-row align-items-center w-100"
        >
          <img :src="author.picture" class="profile_image" alt="not found" />
          <h5 class="font-Roboto ms-3">{{ author.name }}</h5>
        </div>
      </a>
    </div>

    <!-- User Contact -->
    <div
      class="rounded-7 d-flex flex-wrap flex-column mt-3 bg-seavphov-light h-100 px-3"
    >
      <div class="d-flex flex-column w-100">
        <h4 class="mx-3 mt-3 font-Roboto">Contact</h4>
        <div class="d-flex flex-row my-2 mx-3">
          <span><i class="fas fa-phone fa-lg me-1"></i></span>
          <h5 class="ml-5" style="font-size: 18px; margin-top: 2.5px">
            {{ author.phone }}
          </h5>
        </div>

        <!-- Social Media Button -->
        <SocialMediaList
          :facebook="author.facebook"
          :instagram="author.instagram"
          :telegram="author.telegram"
          :twitter="author.twitter"
        />
        <hr class="custom-hr d-flex mx-4 justify-content-center" />

        <!-- Location-->
        <h4 class="mx-3 mt-3 font-Roboto">Location</h4>
        <h5 class="ml-5 my-2 mx-3" style="font-size: 18px; margin-top: 2.5px">
          <span><i class="fas fa-map-pin fa-lg me-1"></i></span>{{ author.location }}
        </h5>
        <div class="location d-flex flex-wrap flex-column my-1 mx-3">
          <!-- Map -->
          <div id="map" class="w-100 d-flex justify-content-center mt-3">
            <div class="gmap_canvas">
              <iframe
                class="rounded-7"
                src="https://maps.google.com/maps?q=aeon%20mall%20sensok&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                frameborder="0"
                scrolling="no"
                style="width: 360px; height: 200px"
              >
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SocialMediaList from "./SocialMediaList.vue";
export default {
  name: "BookAuthorProfile",
  components: { SocialMediaList },
  props: {
    author: Object,
  },
  data() {
    return {
      profileUrl: null,
    };
  },
  methods: {
    getUserProfileUrl(newAuthor) {
      if (newAuthor) {
        const email = newAuthor.email;
        this.profileUrl = `/profile/${email.split("@")[0]}`;
      }
    },
  },
  watch: {
    author: {
      handler(newAuthor, oldAuthor) {
        if (newAuthor) {
          this.getUserProfileUrl(newAuthor);
        }
      },
    },
  },
};
</script>

<style scoped>
.profile_image {
  width: 90px;
  height: 90px;
  min-width: 90px;
  min-height: 90px;
  border-radius: 9999px;
  object-fit: cover;
  border: 3px solid #9fb97f;
}

.mapouter {
  position: relative;
  height: 200px;
  width: 360px;
  background: #fff;
  border-radius: 15px;
}

.maprouter a {
  color: #fff !important;
  position: absolute !important;
  top: 0 !important;
  z-index: 0 !important;
}

.gmap_canvas {
  overflow: hidden;
  height: max-content;
  width: max-content;
}

.icon {
  width: 40px;
  height: 40px;
}
</style>