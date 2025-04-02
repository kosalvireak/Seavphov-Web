import { deleteData, getData, postForm } from "../utils/apiUtils.js";

const ReviewRoute = "/api/review";

export default class ReviewController {
  static async getReviewsOfBook(bookId) {
    return await getData(ReviewRoute + `/book/${bookId}`, true);
  }

  static async getMyReviews() {
    return await getData(ReviewRoute + "/my-reviews", true);
  }

  static async deleteReview(id) {
    return await deleteData(ReviewRoute + `/delete/${id}`);
  }

  static async createReview(formData) {
    return await postForm(ReviewRoute + `/add`, formData, true);

  }

  static async editReview(formData) {
    let id = formData.get("id");
    return await postForm(
      ReviewRoute + `/edit/${id}`,
      formData,
      true,
    );
  }
}
