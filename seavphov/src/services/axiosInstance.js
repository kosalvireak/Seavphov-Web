import { useToast } from "vue-toastification";
import router from "../router";
import axios from "axios";

const toast = useToast();
const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_BACKEND_URL,
  timeout: 40000,
});

function handleSuccessResponse(response) {
  const { success, message, data, toast } = response.data;
  if (success) {
    handleToastMessage(toast, message);
    return data;
  }
}

function handleToastMessage(toastObject, message) {
  if (toastObject?.show) {
    switch (toastObject.type) {
      case "success":
        toast.success(message);
        break;
      case "error":
        toast.error(message);
        break;
      default:
        toast.info(message);
        break;
    }
  }
}

function handleErrorResponse(error) {
  let message = "";
  const errorResponse = error.response;
  if (errorResponse) {
    // The request was made and the server responded with a status code
    // that falls out of the range of 2xx

    message =
      errorResponse.data.message + ": " + errorResponse.data.error ?? "";

    if (errorResponse.status === 404) {
      router.push("/not-found");
    }
  } else if (error.request) {
    // The request was made but no response was received

    let moreInfo = "";
    if (error.code === "ERR_NETWORK") {
      moreInfo = "Server not reachable";
    }

    message = error.message + ": " + moreInfo;
  } else {
    // Something happened in setting up the request that triggered an Error

    message = "Something went wrong: " + error.message;
  }
  toast.error(message);
  return null;
}

axiosInstance.interceptors.response.use(
  (response) => {
    return handleSuccessResponse(response);
  },
  (error) => {
    return handleErrorResponse(error);
  },
);

export default axiosInstance;
