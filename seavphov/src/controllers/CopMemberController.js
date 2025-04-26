import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommunityRoute = "/api/community";

export default class CopMemberController {
  static async getCommunityMembers(route) {
    return await getData(CommunityRoute + `/${route}/members`, true);
  }

  static async getCommunityMemberRequest(route) {
    return await getData(CommunityRoute + `/${route}/member-requests`, true);
  }

  static async checkViewCopHomePermission(route) {
    return await getData(CommunityRoute + `/${route}/permission/home`, true);
  }

  static async requestToJoinCop(route) {
    return await getData(
      CommunityRoute + `/${route}/request-to-join-cop`,
      true,
    );
  }

  static async joinCop(route) {
    return await getData(CommunityRoute + `/${route}/join-cop`, true);
  }

  static async approveMemberRequest(route, uuid) {
    const formData = new FormData();
    formData.append("uuid", uuid);

    return await postForm(
      CommunityRoute + `/${route}/approved`,
      formData,
      true,
    );
  }

  static async rejectMemberRequest(route, uuid) {
    const formData = new FormData();
    formData.append("uuid", uuid);
    return await postForm(CommunityRoute + `/${route}/reject`, formData, true);
  }

  static async changeUserRole(route, uuid, role) {
    const formData = new FormData();
    formData.append("uuid", uuid);
    formData.append("role", role);
    return await postForm(CommunityRoute + `/${route}/change-role`, formData, true);
  }

  static async removeMemberFromCop(route, uuid) {
    const formData = new FormData();
    formData.append("uuid", uuid);
    return await postForm(CommunityRoute + `/${route}/remove-member/${uuid}`, formData, true);
  }
}
