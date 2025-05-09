import { deleteData, getData, postForm } from "../utils/apiUtils.js";

const ReadingChallengeRoute = "/api/reading-challenge";

const ReadingChallengeMemberRoute = "/api/members/reading-challenge";

export default class ReadingChallengeController {
  static async editReadingChallenge(formData, id) {
    return await postForm(
      ReadingChallengeRoute + `/${id}/edit`,
      formData,
      true,
    );
  }
  static async addReadingChallenge(formData, route) {
    return await postForm(
      ReadingChallengeRoute + `/${route}/add`,
      formData,
      true,
    );
  }

  static async getReadingChallenges(route) {
    return await getData(ReadingChallengeRoute + `/${route}`, true);
  }

  static async getReadingChallenge(route, id) {
    return await getData(ReadingChallengeRoute + `/${route}/${id}`, true);
  }

  static async startReadingChallenge(route, id) {
    return await getData(ReadingChallengeRoute + `/${route}/${id}/join`, true);
  }

  static async getReadingChallengeMembers(id) {
    return await getData(ReadingChallengeMemberRoute + `/${id}`, true);
  }

  static async getMyReadingProgress(id) {
    return await getData(
      ReadingChallengeMemberRoute + `/my-progress/${id}`,
      true,
    );
  }

  static async updateChallengeProgress(id, formData) {
    return await postForm(
      ReadingChallengeMemberRoute + `/update-progress/${id}`,
      formData,
      true,
    );
  }

  static async withDrawChallenge(id, formData) {
    return await deleteData(
      ReadingChallengeMemberRoute + `/withdraw/${id}`,
      formData,
      true,
    );
  }

  static async deleteChallenge(id) {
    return await deleteData(ReadingChallengeRoute + `/${id}`, true);
  }
}
