import { useToast } from "vue-toastification"
import axios from 'axios';

const toast = useToast();
const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_BACKEND_URL,
});

axiosInstance.interceptors.response.use(response => {
    return response;
}, error => {
    if (!error.response) {
        // Handle network errors here
        // For example, display a message to the user
        toast.error('Network Error:', error.message);
    } else {
        // Handle HTTP errors here
        // For example, display error messages from the server
        toast.error('HTTP Error:', error.response.status);
    }
    return Promise.reject(error);
});

export default axiosInstance;
