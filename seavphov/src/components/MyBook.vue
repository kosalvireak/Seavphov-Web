<template>
  <div class="MyBook card my-4" >
    <div class="row container-sm m-0 p-2">
        <router-link
      :to="`/book/${book.id}`"
      class="col-md-3 d-flex-center bg-success-subtle hover-zoom rounded-7 p-2"
    >
        <img
          :src="book.images"
          class="card-img img-fluid m-2 book_image p-1 rounded-7"
          alt="book_image"
          style="object-fit: contain"
        />
    </router-link>
      <div class="col-md-9">
        <div class="d-flex justify-content-between p-2"> 
          <div>
            <h5 class="card-title fw-bold truncate-2-lines">{{ book.title }}</h5>
            <p class="card-text truncate-2-lines">
              {{ book.descriptions }}
            </p>
            
            <p class="card-text">
              <ul>
                  <li> <span class="fw-bold">Author:</span>{{ book.author }}</li>
                  <li><span class="fw-bold">Condition: </span>{{ book.condition }}</li>
                  <li><span class="fw-bold">Category: </span>{{ book.categories }}</li>
                  <li v-if="book.availability"><span class="fw-bold">Available:</span> True</li>
                  <li v-else><span class="fw-bold">Available: </span>False</li>
              </ul>
            </p>
        </div>
          <div class="">
            <MDBDropdown  btnGroup align="end"  v-model="openDropdown" >
              <MDBDropdownToggle @click="openDropdown = !openDropdown" color="info"/>
              <MDBDropdownMenu aria-labelledby="dropdownMenuButton">
                <MDBDropdownItem tag="button" 
                @click="editBook(book.id)"
                >Edit</MDBDropdownItem>
                <MDBDropdownItem tag="button">Delete</MDBDropdownItem>
              </MDBDropdownMenu>
            </MDBDropdown>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
import {
  MDBDropdown,
  MDBDropdownToggle,
  MDBDropdownMenu,
  MDBDropdownItem,
} from "mdb-vue-ui-kit";
export default {
  name: "MyBook",
  components: {
    MDBDropdown,
    MDBDropdownToggle,
    MDBDropdownMenu,
    MDBDropdownItem,
  },
  props: { book: Object },
  data() {
    return {
      openDropdown: false,
    };
  },
  methods: {
    editBook(id) {
      this.$router.push(`/book/edit/${id}`);
    },
  },
};
</script>
  
  <style scoped>
.dropdown-menu {
  min-width: 75px !important;
}
.dropdown-toggle {
  width: 75px !important;
}
.truncate-2-lines {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2; /* Number of lines to show */
  -webkit-box-orient: vertical;
}
.MyBook {
  min-height: 16rem;
}

.book_image {
  height: 14rem;
  width: 14rem;
}
@media (max-width: 768px) {
  .book_image {
    height: 12rem;
    width: 12rem;
  }
}
</style>