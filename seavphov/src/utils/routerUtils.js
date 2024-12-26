import { getCookie } from "./cookieUtils";

export const RouterMixin = {
    methods: {
        toRouteName(route, paramId) {
            return this.$router.push({ name: route, params: { id: paramId } });
        },
        backRoute() {
            return this.$router.back();
        },
        async logout() {
            await this.$store.dispatch("logoutUser");
            this.toRouteName('login')
        },
    },
    computed: {
        isLogin() {
            return !!getCookie();
        }
    }
}