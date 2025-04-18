import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommunityRoute = "/api/community";

export default class CommunityController {
  static async searchCommunity(params) {
    return await getData(CommunityRoute + `?${params}`, true);
  }

  static async getCommunityByRoute(route) {
    return await getData(CommunityRoute + `/route/${route}`);
  }

  static async createCommunity(formData) {
    return await postForm(CommunityRoute + `/new`, formData, true);
  }

  static async editCommunity(formData, route) {
    return await postForm(CommunityRoute + `/edit/${route}`, formData, true);
  }

  static async deleteCommunity(route) {
    return await deleteData(CommunityRoute + `/delete/${route}`, true);
  }
}
