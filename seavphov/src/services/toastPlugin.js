import Toast, { POSITION } from "vue-toastification";

export default {
  install(app) {
    app.use(Toast, {
      position: POSITION.BOTTOM_RIGHT,
    });
  },
};
