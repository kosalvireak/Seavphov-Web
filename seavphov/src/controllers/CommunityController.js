import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommunityRoute = "/api/community";

export default class CommunityController {
  static async fetchCommunityWithFilter(params) {
    try {
      const response = await getData(CommunityRoute + `?${params}`);
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
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
    }
  }
}
