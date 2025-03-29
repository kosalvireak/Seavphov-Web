import { useToast } from "vue-toastification";
import axios from "axios";

const toast = useToast();
const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_BACKEND_URL,
  timeout: 30000,
});

axiosInstance.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {

    // Handle error
    if (error.response) {
      // The request was made and the server responded with a status code
      // that falls out of the range of 2xx

      toast.error(error.response.message);
    } else if (error.request) {
      // The request was made but no response was received

      let moreInfo = "";
      if (error.code = "ERR_NETWORK") {
        moreInfo = "Server not reachable";
      }

      toast.error(error.message + ": " + moreInfo);
    } else {
      // Something happened in setting up the request that triggered an Error

      toast.error('Something went wrong: ', error.message);

    }


  },
);

export default axiosInstance;
