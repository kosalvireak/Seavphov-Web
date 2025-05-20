import { getData, postForm, deleteData } from "../utils/apiUtils.js";

const BookRoute = "/api/books";

export default class BookController {
  static async getMostReviewed() {
    return await getData(BookRoute + "/mostReviewed");
  }

  static async fetchNewestAddition() {
    return await getData(BookRoute + "/newest");
  }

  static async addBook(formData) {
    return await postForm(BookRoute, formData, true);
  }

  static async getBookDetailWithOwner(id) {
    return await getData(BookRoute + `/${id}`, true);
  }

  static async changeBookAvailability(id) {
    return await getData(BookRoute + `/availability/${id}`, true);
  }

  static async getMyBooks() {
    return await getData("/api/auth/book", true);
  }

  static async getMyBook(id) {
    return await getData(`/api/auth/book/${id}`, true);
  }

  static async getSavedBook() {
    return await getData("/api/saved", true);
  }

  static async searchBook(formData) {
    return await postForm(BookRoute + "/search-book", formData, false);
  }

  static async modifyBook(formData) {
    let id = formData.get("id");
    return await postForm(`/api/books/${id}`, formData, true);
  }

  static async getBanner() {
    return await getData(BookRoute + "/banner");
  }

  static async toggleSaveBook(id) {
    return await getData(`/api/saved/${id}`, true);
  }

  static async deleteBook(id) {
    return await deleteData(BookRoute + `/${id}`, true);
  }
}
