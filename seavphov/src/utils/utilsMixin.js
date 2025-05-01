import { getCookie } from "../services/cookie";

export const UtilsMixin = {
  data() {
    return {
      dropdownItemClass:
        "block px-4 py-2 mb-0 w-100 text-sm text-center text-gray-700 hover:bg-gray-200 clickable",
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
  },
  computed: {
    isLogin() {
      return !!getCookie();
    },
  },
};
