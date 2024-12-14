
export const RouterMixin = {
    methods: {
        toRouteName(route, paramId) {
            return this.$router.push({ name: route, params: { id: paramId } });
        },
        async logout() {
            await this.$store.dispatch("logoutUser");
            this.toRouteName('login')
        }
    }
}