import { deleteData, getData, postForm } from "../utils/apiUtils.js";

const AuthRoute = "/api/auth";

export default class AuthController {
  static async register(registerData) {
    return await postForm(AuthRoute + "/register", registerData, true);
  }

  static async login(loginData) {
    return await postForm(AuthRoute + "/login", loginData, true);
  }

  static async resetPassword(formData) {
    return await postForm(AuthRoute + "/reset", formData, true);
  }
  static async sendMailResetPassword(formData) {
    return await postForm(AuthRoute + "/reset/send-mail", formData, true);
  }
}
