<template>
  <section class="BannersList shadow-5 rounded-7 flex-center flex-column w-100">
    <div v-if="page == 1" class="Banners_table">
      <div class="flex-center mb-3">
        <button
          type="submit"
          class="btn btn-primary btn_submit"
          @click="changePage(2)"
        >
          Add new banner
        </button>
      </div>
      <EasyDataTable
        :headers="headers"
        :items="banners"
        alternating
        :loading="isLoading"
        border-cell
        buttons-pagination
      >
        <template #item-image_url="banners">
          <img
            :src="banners.image_url"
            class="img-fluid admin_book m-3 ms-1"
            alt="admin_book"
            loading="lazy"
          />
        </template>
        <template #item-order_priority="banners">
          <p v-if="banners.order_priority == 1">True</p>
          <p class="text-bold" v-else>False</p>
        </template>
        <template #item-created_at="banners">
          {{ formatDate(banners.created_at) }}
        </template>
        <template #item-="banners">
          <div class="flex-center w-100">
            <LoadingButton
              v-if="banners.order_priority == 0"
              @click="changeSelectedBanner(banners.id)"
              :disabled="disabled"
            >
              Select</LoadingButton
            >
            <LoadingButton v-else :disabled="true"> Selected</LoadingButton>
            <LoadingButton
              v-if="banners.order_priority == 0"
              color="danger"
              @click="adminDeleteBanner(banners.id)"
              :disabled="disabled"
            >
              <i class="fa fa-trash fa-xl clickable" aria-hidden="true"></i
            ></LoadingButton>
          </div>
        </template>
      </EasyDataTable>
    </div>
    <div v-if="page == 2" class="Add_Banners flex-center flex-column w-100">
      <div class="w-100 clickable">
        <a @click="changePage(1)" class="text-gray">
          <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
          Back
        </a>
      </div>
      <h4 class="mb-4 text-gray font-bold">Add new Banner</h4>
      <form
        style="width: 100%"
        v-on:submit.prevent="addBanner()"
        class="row flex-center p-0 p-lg-5 space-y-4"
      >
        <ImageUpload
          id="banner"
          @image-uploaded="onUploadBanner"
          :filled="true"
        />
        <div class="col-12 col-md-6 space-y-4">
          <MDBInput
            type="text"
            label="Title"
            id="title"
            v-model="newBanner.title"
            wrapperClass="bg-white h-3rem"
            required
          />
          <MDBCheckbox
            v-model="newBanner.order_priority"
            label="Selected"
            id="order"
          />
          <MDBInput
            type="text"
            label="Banner redirect link"
            id="link_url"
            v-model="newBanner.link_url"
            wrapperClass="bg-white h-3rem"
          />
        </div>

        <div class="d-flex align-items-center justify-content-center">
          <LoadingButton :loading="isLoading">Add Banner</LoadingButton>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import Carousel from "../../components/home/Carousel.vue";

import { MDBInput, MDBCheckbox } from "mdb-vue-ui-kit";
import AdminController from "../../controllers/admin/AdminController.js";

export default {
  name: "BannersList",
  components: { Carousel, MDBInput, MDBCheckbox },
  data() {
    return {
      banners: [],
      isLoading: false,
      headers: [
        { text: "ID", value: "id", sortable: true },
        { text: "IMAGE", value: "image_url", width: 400 },
        { text: "TITLE", value: "title" },
        { text: "LINK", value: "link_url", width: 100 },
        { text: "CREATED_AT", value: "created_at" },
        { text: "ACTION", value: "" },
      ],
      newBanner: {
        title: "",
        order_priority: true,
        image_url: "",
        link_url: "",
      },
      page: 1,
      formData: new FormData(),
      uploadingBanner: false,
      disabled: false,
    };
  },
  methods: {
    async changeSelectedBanner(id) {
      this.disabled = true;
      await AdminController.changeSelectedBanner(id);
      this.disabled = false;
      this.adminGetBanners();
    },
    async adminDeleteBanner(id) {
      this.disabled = true;
      await AdminController.adminDeleteBanner(id);
      this.disabled = false;
      this.adminGetBanners();
    },
    async adminGetBanners() {
      this.isLoading = true;
      this.banners = await AdminController.adminGetBanners();
      this.isLoading = false;
    },
    async addBanner() {
      this.formData.append("title", this.newBanner.title);
      const orderIndex = this.newBanner.order_priority ? 1 : 0;
      this.formData.append("order_priority", orderIndex);
      this.formData.append("link_url", this.newBanner.link_url);
      await AdminController.adminAddBanner(this.formData);
      this.changePage(1);
      this.adminGetBanners();
    },
    async onUploadBanner(url) {
      this.newBanner.image_url = url;
      this.setValueToFormAttribute(this.formData, "image_url", url);
    },
    changePage(page) {
      this.page = page;
    },
  },
  async mounted() {
    this.adminGetBanners();
  },
};
</script>

<style scoped>
/* .Banners {
  width: 20rem;
  height: 10rem;
  background-color: white;
} */
.admin_book {
  height: 120px;
  width: 400px;
  object-fit: cover;
}

.btn_submit {
  width: 180px;
  height: 40px;
  background-color: #5c836e;
  color: #ffffff;
}

.custom-file-upload {
  display: inline-block;
  padding: 4px 9px;
  cursor: pointer;
  color: #4f4f4f;
  background-color: #fff;
  border-radius: 5px;
  position: absolute;
  margin: 1px 0px 0px 1px;
}
</style>
