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
    inValidProperty(obj, attribute) {
      if (obj == null) {
        return false;
      }
      return !(obj[attribute] == null || obj[attribute] === 'null');

    }
  },
  computed: {
    isLogin() {
      return !!getCookie();
    },
  },
};
