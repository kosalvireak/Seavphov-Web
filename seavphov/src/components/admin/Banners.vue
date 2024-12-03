<template>
  <section class="Banners shadow-5 rounded-7 flex-center p-2 flex-column w-100">
    <div v-if="page == 1" class="Banners_table">
      <div class="flex-center m-3">
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
        <template #item-="banners">
          <div class="flex-center w-100">
            <button
              v-if="banners.order_priority == 0"
              class="ellipsis text-center btn btn-primary h-auto"
              style="background-color: #5c836e"
              @click="changeSelectedBanner(banners.id)"
            >
              Select
            </button>
            <button
              class="ellipsis text-center btn btn-danger h-auto"
              @click="adminDeleteBanner(banners.id)"
            >
              <i
                class="fa fa-trash fa-xl cursor-pointer"
                aria-hidden="true"
              ></i>
            </button>
          </div>
        </template>
      </EasyDataTable>
    </div>
    <div v-if="page == 2" class="Add_Banners flex-center flex-column w-100">
      <a @click="changePage(1)" class="text-gray">
        <i
          class="fa fa-arrow-circle-left cursor-pointer"
          aria-hidden="true"
        ></i>
        Banners
      </a>
      <h4 class="my-4 text-gray fw-bold">Your are adding a new Banner</h4>

      <form
        style="width: 100%"
        v-on:submit.prevent="addBanner()"
        class="row p-0 p-lg-5"
      >
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Title"
              id="title"
              v-model="newBanner.title"
              wrapperClass="bg-white p-2"
              required
            />
          </div>
          <div class="mb-4">
            <p>1 for selected banner, 0 for not selected.</p>
            <MDBInput
              type="text"
              label="Order"
              id="order"
              v-model="newBanner.order_priority"
              wrapperClass="bg-white p-2"
              required
            />
          </div>
          <div class="mb-4">
            <MDBInput
              type="text"
              label="Banner link"
              id="link_url"
              v-model="newBanner.link_url"
              wrapperClass="bg-white p-2"
            />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <label for="images" class="form-label custom-file-upload"
              >Banner Image</label
            >
            <input
              type="file"
              class="form-control ps-4 p-2"
              id="images"
              name="images"
              @change="handleImageChange"
            />
          </div>
          <div
            class="my-3 mt-3 d-flex align-items-center justify-content-center border border-bdbdbd rounded-7"
            style="width: 100%; height: 220px"
          >
            <img
              v-if="newBanner.image_url"
              :src="newBanner.image_url"
              alt="preview_image"
              class="img-fluid h-100"
              style="object-fit: cover"
            />
            <div v-else>
              <Loader v-if="uploadingBanner" />
              <p class="text-center" v-else>Your image will preview here</p>
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" class="btn btn-primary m-2">Add Banner</button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import Carousel from "../Carousel.vue";

import { MDBInput } from "mdb-vue-ui-kit";
import { storage } from "../../firebase";
import { ref, uploadBytes, getDownloadURL } from "firebase/storage";

export default {
  name: "Banners",
  components: { Carousel, MDBInput },
  data() {
    return {
      banners: [],
      isLoading: false,
      headers: [
        { text: "ID", value: "id", sortable: true },
        { text: "SELECTED", value: "order_priority", sortable: true },
        { text: "IMAGE", value: "image_url", width: 400 },
        { text: "TITLE", value: "title" },
        { text: "LINK", value: "link_url", width: 100 },
        { text: "CREATED_AT", value: "created_at" },
        { text: "ACTION", value: "" },
      ],
      newBanner: {
        title: "",
        order_priority: "",
        image_url: "",
        link_url: "",
      },
      page: 1,

      formData: new FormData(),
      uploadingBanner: false,
    };
  },
  methods: {
    async changeSelectedBanner(id) {
      await this.$store.dispatch("changeSelectedBanner", id);
      this.adminGetBanners();
    },
    async adminDeleteBanner(id) {
      await this.$store.dispatch("adminDeleteBanner", id);
      this.adminGetBanners();
    },
    async adminGetBanners() {
      this.isLoading = true;
      this.banners = await this.$store.dispatch("adminGetBanners");
      this.isLoading = false;
    },
    async addBanner() {
      this.formData.append("title", this.newBanner.title);
      this.formData.append("order_priority", this.newBanner.order_priority);
      this.formData.append("link_url", this.newBanner.link_url);
      const response = await this.$store.dispatch(
        "adminAddBanner",
        this.formData
      );
      if (response) {
        this.page = 1;
        this.adminGetBanners();
      }
    },
    async handleImageChange(event) {
      this.uploadingBanner = true;
      try {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
          const storageRef = ref(storage, `folder/${selectedFile.name}`);
          const imageUpload = await uploadBytes(storageRef, selectedFile);
          getDownloadURL(ref(storage, imageUpload.metadata.fullPath)).then(
            (url) => {
              this.newBanner.image_url = url;
              this.formData.append("image_url", url);
              this.uploadingBanner = false;
            }
          );
        }
      } catch (error) {
        this.toast.error(error);
      }
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