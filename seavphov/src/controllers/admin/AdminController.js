import { getData, deleteData, postForm } from "../../utils/apiUtils.js";

const AdminRoute = "/api/admin";

export default class AdminController {
  static async adminGetAuth() {
    return await getData(AdminRoute + "/auth", true);
  }

  // banner

  static async adminGetBanners() {
    return await getData(AdminRoute + "/banners", true);
  }

  static async changeSelectedBanner(id) {
    return await getData(AdminRoute + `/banners/selected/${id}`, true);
  }

  static async adminDeleteBanner(id) {
    return await deleteData(AdminRoute + `/banners/${id}`, true);
  }

  static async adminAddBanner(formData) {
    return await postForm(AdminRoute + "/banners", formData, true);
  }

  static async adminDeleteBook(id) {
    return await deleteData(AdminRoute + `/books/delete/${id}`, true);
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

  static async adminGetCommunities() {
    return await getData(AdminRoute + "/communities", true);
  }

  static async adminDeleteCommunity(id) {
    return await deleteData(AdminRoute + `/community/${id}`, true);
  }
}
