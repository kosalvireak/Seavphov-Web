import { getData, postForm } from "../utils/apiUtils.js";

const UserRoute = "/api/user";

export default class UserController {
    static async getProfile() {
        return await getData(UserRoute, true);
    }
    static async editProfile(profileData) {
        return await postForm(UserRoute + '/edit', profileData, true);
    }
    static async getOtherProfile(uuid) {
        return await getData(UserRoute + `/${uuid}`, true);
    }
}
