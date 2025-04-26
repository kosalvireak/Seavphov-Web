import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommentRoute = "/api/comment";

export default class CommentController {
  static async getCommentsOfDiscussion(discussionId) {
    return await getData(CommentRoute + `/discussion/${discussionId}`, true);
  }

  static async deleteComment(id) {
    return await deleteData(CommentRoute + `/delete/${id}`);
  }

  static async editComment(formData) {
    let id = formData.get("id");
    return await postForm(CommentRoute + `/edit/${id}`, formData, true);
  }

  static async createComment(formData) {
    return await postForm(CommentRoute + `/add`, formData, true);
  }

  static async getMyComments() {
    return await getData(CommentRoute + `/my-comments`, true);
  }
}
