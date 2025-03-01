import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const ReviewRoute = "/api/review";

export default class ReviewController {
  static async fetchBookReviews(bookId) {
    try {
      const response = await getData(ReviewRoute + `/book/${bookId}`, true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async fetchMyReviews() {
    try {
      const response = await getData(ReviewRoute + '/my-reviews', true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async deleteReview(id) {
    try {
      const response = await deleteData(ReviewRoute + `/delete/${id}`);
      if (response.data.success) {
        toast.success(response.data.message);

        return response.data.message;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async createReview(formData) {
    try {
      const response = await postForm(ReviewRoute + `/add`, formData, true);
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async editReview(formData) {
    try {
      let id = formData.get("id");
      const response = await postForm(
        ReviewRoute + `/edit/${id}`,
        formData,
        true,
      );
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.data;
      }
    } catch (error) {
      console.error("Error editing review:", error);
      toast.error(error.response.data.message);
    }
  }
}
