<template>
  <div class="SearchInput rounded-7">
    <form
      class="rounded-7 d-flex justify-content-between"
      v-on:submit.prevent="SearchBooks()"
    >
      <input
        type="text"
        id="search"
        name="search"
        placeholder="Search..."
        v-model="keyword"
      />
      <button type="submit">Search</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "SearchInput",
  data() {
    return {
      keyword: "",
    };
  },
  methods: {
    SearchBooks() {
      this.$router.push({ path: "/search", query: { q: this.keyword } });
    },
  },
  watch: {
    "$route.name"() {
      if (this.$route.name !== "search") {
        this.keyword = "";
      }
    },
  },
};
</script>


<style scoped>
.SearchInput {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: stretch;
  width: 100%;
  background-color: white;
}

input[type="text"] {
  border: none;
  background: transparent;
  width: 85%;
  margin: 0;
  padding: 7px 8px;
  font-size: 14px;
  color: inherit;
  border: 1px solid transparent;
  border-radius: inherit;
}

input[type="text"]::placeholder {
  color: #bbb;
}

button[type="submit"] {
  text-indent: -999px;
  overflow: hidden;
  width: 15%;
  padding: 0;
  margin: 0;
  border: 1px solid transparent;
  border-radius: inherit;
  background: transparent
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E")
    no-repeat center;
  cursor: pointer;
  opacity: 0.7;
}

button[type="submit"]:hover {
  opacity: 1;
}

input[type="text"]:focus {
  outline: none;
}

form:focus-within {
  border: 2px solid #48abe0;
}
</style>