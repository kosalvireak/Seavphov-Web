import { getCookie } from "../services/cookie.js";

export const RouterMixin = {
  methods: {
    toRouteName(route, paramId) {
      return this.$router.push({ name: route, params: { id: paramId } });
    },
    toCopHome(route, paramId) {
      return this.$router.push({ name: route, params: { route: paramId } });
    },
    backRoute() {
      return this.$router.back();
    },
    async logout() {
      await this.$store.dispatch("logoutUser");
      this.toRouteName("login");
    },
    isEqual(var1, var2) {
      return JSON.stringify(var1) === JSON.stringify(var2);
    }
  },
  computed: {
    isLogin() {
      return !!getCookie();
    },
  },
};
