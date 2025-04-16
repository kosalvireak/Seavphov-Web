import { deleteData, getData, postForm } from "../utils/apiUtils.js";

const ReadingChallengeRoute = "/api/reading-challenge";

export default class ReadingChallengeController {
    static async addReadingChallenge(formData, route) {
        return await postForm(ReadingChallengeRoute + `/${route}/add`, formData, true);
    }

    static async getReadingChallenges(route) {
        return await getData(ReadingChallengeRoute + `/${route}`, true);
    }

    static async getReadingChallenge(route, id) {
        return await getData(ReadingChallengeRoute + `/${route}/${id}`, true);
    }
}
