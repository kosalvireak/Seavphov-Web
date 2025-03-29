import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const BookRoute = "/api/books";

export default class BookController {
  static async getMostReviewed() {
    try {
      const response = await getData(BookRoute + "/mostReviewed");
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.message);
      return null;
    }
  }

  static async fetchNewestAddition() {
    try {
      const response = await getData(BookRoute + "/newest");
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.message);
      return null;
    }
  }

  static async addBook(formData) {
    try {
      const response = await postForm(BookRoute, formData, true);
      toast.success(response.data.message);
      return response.data.data;
    } catch (error) {
      console.error("Error adding book:", error);
      toast.error(error.response.data.message);
    }
  }

  static async getBookDetailWithOwner(id) {
    try {
      const response = await getData(BookRoute + `/${id}`, true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return false;
    }
  }

  static async changeBookAvailability(id) {
    try {
      const response = await getData(BookRoute + `/availability/${id}`, true);
      toast.success(response.data.message);
      return response.data.success;
    } catch (error) {
      console.error("Error change book status:", error);
      toast.error(error.response.data.message);
    }
  }

  static async getMyBooks() {
    try {
      const response = await getData("/api/auth/book", true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async getMyBook(id) {
    try {
      const response = await getData(`/api/auth/book/${id}`, true);
      if (response.data.success) {
        return response.data.data;
      } else {
        toast.error(response.data.message);
      }
    } catch (error) {
      toast.error(error.response.message);
    }
  }
  static async getSavedBook() {
    try {
      const response = await getData("/api/saved", true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
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
    try {
      const response = await getData(BookRoute + `?${params.toString()}`);
      if (response.data.success) {
        if (paginate) {
          return response.data.data;
        }
        return response.data.data.data;

      }
    } catch (error) {
      toast.error(error.response.data.message);
      return null;
    }
  }

  static async getBanner() {
    try {
      const response = await getData(BookRoute + "/banner");
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return null;
    }
  }
}
