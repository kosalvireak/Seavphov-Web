import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommunityRoute = "/api/community";

export default class CopMemberController {
  static async getCommunityMembers(route) {
    try {
      const response = await getData(
        CommunityRoute + `/${route}/members`,
        true,
      );
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      console.error("Error get cop members:", error);
      toast.error(error.response.data.message);
    }
  }

  static async getCommunityMemberRequest(route) {
    try {
      const response = await getData(
        CommunityRoute + `/${route}/member-requests`,
        true,
      );
      if (response.data.success) {
        return response.data.data;
      }
    } catch (error) {
      console.error("Error get cop members:", error);
      toast.error(error.response.data.message);
    }
  }

  static async checkViewCopHomePermission(route) {
    try {
      const response = await getData(
        CommunityRoute + `/${route}/permission/home`,
        true,
      );
      if (response.data.success) {
        return response.data;
      }
    } catch (error) {
      toast.error(error.response.data.message);
    }
  }

  static async requestToJoinCop(route) {
    try {
      const response = await getData(CommunityRoute + `/${route}/join`, true);
      return response.data;
    } catch (error) {
      toast.error(error.response.data.message);
      return false;
    }
  }

  static async approveMemberRequest(route, uuid) {
    try {
      const formData = new FormData();
      formData.append("uuid", uuid);

      const response = await postForm(
        CommunityRoute + `/${route}/approved`,
        formData,
        true,
      );
      if (response.data.success) {
        toast.success(response.data.message);
        return true;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return false;
    }
  }

  static async rejectMemberRequest(route, uuid) {
    try {
      const formData = new FormData();
      formData.append("uuid", uuid);
      const response = await postForm(
        CommunityRoute + `/${route}/reject`,
        formData,
        true,
      );
      if (response.data.success) {
        toast.success(response.data.message);
        return true;
      }
    } catch (error) {
      toast.error(error.response.data.message);
      return false;
    }
  }

}
