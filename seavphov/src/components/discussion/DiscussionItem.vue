<template>
  <section
    class="DiscussionItem container-2xl rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Discussion header -->
    <a
      :href="`/profile/${data.userName}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100"
    >
      <img class="sp-logo-sm rounded-full mr-2" :src="data.userImage" />
      <p class="m-0 text-sp-dark">{{ data.userName }}</p>
    </a>

    <!-- Discussion delete Button -->
    <FwbButton color="red" class="absolute right-2 top-0">Delete</FwbButton>

    <!-- Discussion Date -->
    <p class="text-xs text-sp-gray">
      posted on {{ formatDate(data.createdDate) }}
    </p>

    <!-- Discussion Body -->
    <div class="w-100 py-2">
      {{ data.body }}
    </div>
    <div class="w-100 min-h-12 border border-gray-100 rounded-lg flex-center">
      <img :src="data.bodyImage" class="sp-img-lg" alt="book cover" />
    </div>
  </section>
</template>

<script>
export default {
  name: "DiscussionItem",
  data() {
    return {
      data: {
        userName: "admin",
        userImage:
          "https://firebasestorage.googleapis.com/v0/b/seavphov-919d7.appspot.com/o/folder%2FIMG_9959%20copy.jpg?alt=media&token=1a1af343-d14d-486f-a521-834ccafc88a6",
        createdDate: "2025-01-06T04:44:55.000000Z",
        body: "This is a discussion for a book that I want to read.",
        bodyImage: "https://m.media-amazon.com/images/I/51uqS5M6KtL.jpg",
      },
    };
  },
};
</script>

<style>
</style>