import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const ProfileRoute = "/api/profile";

export default class ProfileController {
  static async getMyProfileInfo() {
    return await getData(ProfileRoute, true);
  }

  static async getOtherUserProfile(uuid) {
    try {
      const response = await getData(ProfileRoute + `/${uuid}`, true);

      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }
}
