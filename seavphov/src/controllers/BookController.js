import { getData, postForm } from "../utils/apiUtils.js";

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


  static async getBooksWithFilter(filters = {}, paginate = false) {
    const params = new URLSearchParams();
    if (filters.title) {
      params.append("title", filters.title);
    }
    if (filters.author) {
      params.append("author", filters.author);
    }
    if (filters.categories) {
      params.append("categories", filters.categories);
    }
    if (filters.condition) {
      params.append("condition", filters.condition);
    }
    if (filters.owner_id) {
      params.append("owner_id", filters.owner_id);
    }
    if (filters.uuid) {
      params.append("uuid", filters.uuid);
    }
    if (filters.max > 0) {
      params.append("max", filters.max);
    }
    if (filters.excludeId) {
      params.append("excludeId", filters.excludeId);
    }
    if (filters.page) {
      params.append("page", filters.page);
    }
    const response = await getData(BookRoute + `?${params.toString()}`);
    if (paginate) {
      return response;
    }
    return response.data;
  }


  static async modifyBook(formData) {
    let id = formData.get("id");
    return await postForm(`/api/books/${id}`, formData, true);

  }

  static async getBanner() {
    return await getData(BookRoute + "/banner");
  }
}
