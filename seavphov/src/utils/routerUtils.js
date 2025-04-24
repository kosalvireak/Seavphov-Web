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
    reloadPage() {
      return this.$router.go(0);
    },
    async logout() {
      await this.$store.dispatch("logoutUser");
      this.toRouteName("login");
    },
  },
};
