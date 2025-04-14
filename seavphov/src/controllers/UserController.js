import { deleteData, getData, postForm } from "../utils/apiUtils.js";

const UserRoute = "/api/user";

export default class UserController {
    static async register(registerData) {
        return await postForm(UserRoute + '/register', registerData, true);
    }

    static async login(loginData) {
        return await postForm(UserRoute + '/login', loginData, true);
    }
} 