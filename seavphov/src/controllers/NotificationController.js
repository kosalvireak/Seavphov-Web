import { deleteData, getData, postForm } from "../utils/apiUtils.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const NotificationRoute = "/api/notification";

export default class NotificationController {
  static async getNotifications(params) {
    return await getData(NotificationRoute + `?${params}`, true);
    // const data = {
    //   "items": [
    //     {
    //       "user_picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2FIMG_9959%20copy.jpg?alt=media&token=1a1af343-d14d-486f-a521-834ccafc88a6",
    //       "user_name": "admin",
    //       "object_image": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2Fseavphov_logo.png?alt=media&token=550a1b65-e64b-4b88-8663-d65ec49c4813",
    //       "body": " joined reading challenge cnec",
    //       "type": "join-reading-challenge",
    //       "date": "2025-05-01 08:12:10",
    //       "url": "\/community\/1mmee",
    //       "unread": 0
    //     },
    //     {
    //       "user_picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2FIMG_9959%20copy.jpg?alt=media&token=1a1af343-d14d-486f-a521-834ccafc88a6",
    //       "user_name": "admin",
    //       "object_image": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2Fseavphov_logo.png?alt=media&token=550a1b65-e64b-4b88-8663-d65ec49c4813",
    //       "body": "request to join your community Kosalvireak community",
    //       "type": "request-to-join-cop",
    //       "date": "2025-05-01 08:09:22",
    //       "url": "\/community\/1mmee\/members#tabs=member-requests",
    //       "unread": 0
    //     },
    //     {
    //       "user_picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2FIMG_9959%20copy.jpg?alt=media&token=1a1af343-d14d-486f-a521-834ccafc88a6",
    //       "user_name": "admin",
    //       "object_image": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2Fseavphov_logo.png?alt=media&token=550a1b65-e64b-4b88-8663-d65ec49c4813",
    //       "body": "request to join your community Kosalvireak community",
    //       "type": "request-to-join-cop",
    //       "date": "2025-05-01 08:02:36",
    //       "url": "\/community\/1mmee\/members#tabs=member-requests",
    //       "unread": 0
    //     },
    //     {
    //       "user_picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2FIMG_9959%20copy.jpg?alt=media&token=1a1af343-d14d-486f-a521-834ccafc88a6",
    //       "user_name": "admin",
    //       "object_image": null,
    //       "body": " leave reading challenge cec",
    //       "type": "leave-reading-challenge",
    //       "date": "2025-05-01 08:01:08",
    //       "url": null,
    //       "unread": 0
    //     },
    //     {
    //       "user_picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2FIMG_9959%20copy.jpg?alt=media&token=1a1af343-d14d-486f-a521-834ccafc88a6",
    //       "user_name": "admin",
    //       "object_image": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2Fseavphov_logo.png?alt=media&token=550a1b65-e64b-4b88-8663-d65ec49c4813",
    //       "body": " joined reading challenge cec",
    //       "type": "join-reading-challenge",
    //       "date": "2025-05-01 07:58:55",
    //       "url": "\/community\/1mmee",
    //       "unread": 0
    //     },
    //     {
    //       "user_picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2FIMG_9959%20copy.jpg?alt=media&token=1a1af343-d14d-486f-a521-834ccafc88a6",
    //       "user_name": "admin",
    //       "object_image": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2Fseavphov_logo.png?alt=media&token=550a1b65-e64b-4b88-8663-d65ec49c4813",
    //       "body": "join your community Kosalvireak community",
    //       "type": "join-cop",
    //       "date": "2025-05-01 07:56:51",
    //       "url": "\/community\/1mmee\/members",
    //       "unread": 0
    //     }
    //   ],
    //   "pagination": {
    //     "total": 31,
    //     "current_page": 1,
    //     "last_page": 6
    //   }
    // }
    // return data;
  }
}
