import { useToast } from "vue-toastification";
import axios from "axios";

const toast = useToast();
const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_BACKEND_URL,
});

axiosInstance.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (!error.response) {
      toast.error("Network Error:", error.message);
    }
    return Promise.reject(error);
  },
);

export default axiosInstance;
