
export const RouterMixin = {
    methods: {
        toRouteName(route) {
            return this.$router.push({ name: route })
        },
        async logout() {
            await this.$store.dispatch("logoutUser");
            this.$router.push("/login");
        }
    }
}