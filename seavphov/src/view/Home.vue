<template>
  <div class="w-100 h-100 mb-auto space-y-8">
    <HomeNavigation selectedTab="home" />
    <!-- <BannerContainer />
    <MostReviewed />
    <NewestAddition />
    <DiscussionHomepage />
    <PaginatedBook /> -->
  </div>
</template>

<script>
import MostReviewed from "../components/home/MostReviewed.vue";
import NewestAddition from "../components/home/NewestAddition.vue";
import RenderBook from "../components/RenderBook.vue";
import PaginatedBook from "../components/PaginatedBook.vue";
import DiscussionHomepage from "../components/discussion/DiscussionHomepage.vue";
import BannerContainer from "../components/home/BannerContainer.vue";
export default {
  name: "Home",
  components: {
    RenderBook,
    PaginatedBook,
    NewestAddition,
    MostReviewed,
    DiscussionHomepage,
    BannerContainer,
  },
  data() {
    return {
      reloaded: false,
      filters: {
        categories: "Text-Book",
      },
      carouselData: [],
      isLoading: false,
    };
  },
};
</script>
