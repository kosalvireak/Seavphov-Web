import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const DiscussionRoute = "/api/discussions";

export default class DiscussionController {
  static async getDiscussionsWithFilter(filters) {
    const params = new URLSearchParams();
    if (filters.title) {
      params.append("title", filters.title);
    }
    if (filters.uuid) {
      params.append("uuid", filters.uuid);
    }
    try {
      const response = await getData(
        DiscussionRoute + `?${params.toString()}`,
        true,
      );
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async getMyDiscussions() {
    try {
      const response = await getData(DiscussionRoute + "/my-discussions", true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }
  static async getDiscussionById(id) {
    try {
      const response = await getData(DiscussionRoute + `/${id}`, true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async deleteDiscussion(id) {
    try {
      const response = await deleteData(DiscussionRoute + `/delete/${id}`);
      if (response.data.success) {
        toast.success(response.data.message);

        return response.data.message;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async createDiscussion(formData) {
    try {
      const response = await postForm(DiscussionRoute, formData, true);
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return null;
    }
  }
  static async editDiscussion(formData, id) {
    try {
      const response = await postForm(DiscussionRoute + `/edit/${id}`, formData, true);
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return null;
    }
  }
}
