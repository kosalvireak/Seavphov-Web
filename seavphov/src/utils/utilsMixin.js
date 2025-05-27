import { getCookie } from "../services/cookie";
import { resizeState } from "./breakpoint";
import { ref, deleteObject } from 'firebase/storage';
import { storage } from "../firebase";

export const UtilsMixin = {
  data() {
    return {
      dropdownItemClass:
        "block px-4 py-2 mb-0 w-fit-content text-sm text-center text-gray-700 hover:bg-gray-200 clickable",
      fwbDropdownNavCss:
        "py-2 text-sm text-gray-700 dark:text-gray-200 flex flex-col",
      fwbDropdownItemCss:
        "text-center cursor-pointer px-4 py-2 hover:bg-gray-100 whitespace-nowrap overflow-hidden text-ellipsis",
    };
  },
  methods: {
    isEqual(var1, var2) {
      return JSON.stringify(var1) === JSON.stringify(var2);
    },
    setValueToFormAttribute(form, attribute, value) {
      if (form.has(attribute)) {
        form.delete(attribute);
      }
      form.append(attribute, value);
    },
    inValidProperty(obj, attribute) {
      if (obj == null) {
        return false;
      }
      return !(obj[attribute] == null || obj[attribute] === "null");
    },
    bookPluralize(total) {
      return total > 1 ? "Books" : "Book";
    },
    textPluralize(total, singular, plural) {
      return total > 1 ? plural : singular;
    },
    getStoragePathFromUrl(url) {
      try {
        const base = url.split('?')[0]; // remove query params
        const pathEncoded = base.split('/o/')[1]; // get encoded path after /o/
        return decodeURIComponent(pathEncoded);  // convert %2F to /
      } catch (err) {
        console.error('Failed to extract path from URL:', err);
        return null;
      }
    },
    async deleteImageFromUrl(imageUrl) {
      const storagePath = this.getStoragePathFromUrl(imageUrl);
      if (!storagePath) return;

      const imageRef = ref(storage, storagePath);
      try {
        await deleteObject(imageRef);
      } catch (error) {
        console.error('Error deleting image:', error);
      }
    }

  },
  computed: {
    isLogin() {
      return !!getCookie();
    },
    isMobile() {
      return resizeState.isMobile;
    },
  },
};
