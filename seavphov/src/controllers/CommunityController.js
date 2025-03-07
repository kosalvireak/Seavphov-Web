import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const CommunityRoute = "/api/community";

export default class CommunityController {
    static async fetchCommunityWithFilter(formData) {
        try {
            const response = await postForm(CommunityRoute + '/get', formData);
            if (response.data.success) {
                return response.data.data;
            }
        } catch (error) {
            toast.error(error.response.data.message);
        }
    }
}
