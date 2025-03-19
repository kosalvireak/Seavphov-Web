import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommunityRoute = "/api/community";

export default class CopMemberController {
    static async getCommunityMembers(route) {
        try {
            console.log("getCommunityMembers", route);

            const response = await getData(CommunityRoute + `/${route}/members`, true);
            if (response.data.success) {
                return response.data.data;
            }
        } catch (error) {
            console.error("Error get cop members:", error);
            toast.error(error.response.data.message);
        }
    }
}