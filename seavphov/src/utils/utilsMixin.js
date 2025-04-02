import { getCookie } from "../services/cookie";

export const UtilsMixin = {
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
  },
  computed: {
    isLogin() {
      return !!getCookie();
    },
  },
};
