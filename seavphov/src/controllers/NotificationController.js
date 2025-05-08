import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const NotificationRoute = "/api/notification";

export default class NotificationController {
  static async getNotifications(params) {
    return await getData(NotificationRoute + `?${params}`, true);
  }
  static async toggleRead(id) {
    return await getData(NotificationRoute + `/read-unread/${id}`, true);
  }
  static async markAsRead(id) {
    return await getData(NotificationRoute + `/read/${id}`, true);
  }
  static async deleteNotification(id) {
    return await deleteData(NotificationRoute + `/${id}`, true);
  }
}
