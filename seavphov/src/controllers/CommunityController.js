import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommunityRoute = "/api/community";

export default class CommunityController {
  static async fetchCommunityWithFilter(params) {
    try {
      const response = await getData(CommunityRoute + `?${params}`, true);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return null
    }
  }

  static async getCommunityByRoute(route) {
    try {
      const response = await getData(CommunityRoute + `/route/${route}`);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return null
    }
  }

  static async createCommunity(formData) {
    try {
      const response = await postForm(CommunityRoute + `/new`, formData, true);
      if (response.data.success) {
        toast.success(response.data.message);
        return response.data.data;
      }
    } catch (error) {
      console.error("Error create community:", error);
      toast.error(error.response.data.error);
      return null;
    }
  }
}
