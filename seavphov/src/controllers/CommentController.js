import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommentRoute = "/api/comment";

export default class CommentController {
  static async getCommentsOfDiscussion(discussionId) {
    try {
      const response = await getData(
        CommentRoute + `/discussion/${discussionId}`,
        true,
      );
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async deleteComment(id) {
    try {
      const response = await deleteData(CommentRoute + `/delete/${id}`);
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.message;
      }
    } catch (error) {
      console.error("Error deleting comment:", error);
      toast.error(error.response.data.message);
    }
  }

  static async editComment(formData) {
    try {
      let id = formData.get("id");
      const response = await postForm(
        CommentRoute + `/edit/${id}`,
        formData,
        true,
      );
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.data;
      }
    } catch (error) {
      console.error("Error editing comment:", error);
      toast.error(error.response.data.message);
    }
  }

  static async createComment(formData) {
    try {
      const response = await postForm(CommentRoute + `/add`, formData, true);
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.data;
      }
    } catch (error) {
      console.error("Error adding comment:", error);
      toast.error(error.response.data.message);
    }
  }
}
