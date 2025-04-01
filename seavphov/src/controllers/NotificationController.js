import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const NotificationRoute = "/api/notification";

export default class NotificationController {
    static async getNotifications(params) {
        try {
            const response = await getData(NotificationRoute + `?${params}`, true);
            if (response.data.success) {
                return response.data.data;
            }
        } catch (error) {
            toast.error(error.response);
            return false;
        }
    }

}