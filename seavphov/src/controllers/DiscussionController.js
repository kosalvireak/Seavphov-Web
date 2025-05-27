import { deleteData, getData, postForm } from "../utils/apiUtils.js";

const DiscussionRoute = "/api/discussions";

export default class DiscussionController {
  static async getDiscussionsWithFilter(filters) {
    const params = new URLSearchParams();
    if (filters.title) {
      params.append("title", filters.title);
    }
    if (filters.uuid) {
      params.append("uuid", filters.uuid); // for filter discussion belong to this user
    }
    return await getData(DiscussionRoute + `?${params.toString()}`, true);
  }

  static async getMyDiscussions() {
    return await getData(DiscussionRoute + "/my-discussions", true);
  }

  static async getDiscussionById(id) {
    return await getData(DiscussionRoute + `/${id}`, true);
  }

  static async getNewestDiscussion() {
    return await getData(DiscussionRoute + "/newest");
  }

  static async getPopularDiscussion() {
    return await getData(DiscussionRoute + "/popular");
  }

  static async deleteDiscussion(id) {
    return await deleteData(DiscussionRoute + `/delete/${id}`);
  }

  static async createDiscussion(formData) {
    return await postForm(DiscussionRoute, formData, true);
  }

  static async editDiscussion(formData, id) {
    return await postForm(DiscussionRoute + `/edit/${id}`, formData, true);
  }
}
