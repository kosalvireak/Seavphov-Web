<template>
    <div class="NavDropdown">
    <Dropdown
      id="discussion-dropdown"
      id_content="discussion-dropdown_content"
      placement="bottom-start"
    >
      <template #button>
        <div class="w-8 h-8 flex-center hover:bg-gray-200 rounded-lg text-white">
            <i class="fa fa-bars fa-xl" aria-hidden="true"></i>
        </div>
      </template>
      <template #content>
        <ul class="py-1 mt-0">
          <li>
            <p :class="dropdownItemCss" @click="toRouteName()">Category</p>
          </li>
          <li>
            <p :class="dropdownItemCss" @click="toRouteName('discussion')">Discussion</p>
          </li>
        </ul>
      </template>
    </Dropdown>
  </div>
  </template>
  
  <script>
  export default {
    name: "NavItemDropdown",
    data() {
      return {
        dropdownItemCss:
          "block px-4 py-2 mb-0 w-100 text-sm text-center text-gray-700 hover:bg-gray-200 clickable",
      };
    },
  };
  </script>
  