import { getData } from "../../utils/apiUtils.js";

const AdminRoute = "/api/admin";

export default class AdminController {
  static async adminGetAuth() {
    return await getData(AdminRoute + "/auth", true);
  }

  static async adminGetBanners() {
    return await getData(AdminRoute + "/banners", true);
  }

  static async adminGetOverviewData() {
    return await getData(AdminRoute + "/overview", true);
  }

  static async adminGetUsers() {
    return await getData(AdminRoute + "/users", true);
  }

  static async adminGetBooks() {
    return await getData(AdminRoute + "/books", true);
  }
}
