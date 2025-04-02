import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const NotificationRoute = "/api/notification";

export default class NotificationController {
  static async getNotifications(params) {
    return await getData(NotificationRoute + `?${params}`, true);
  }
}
