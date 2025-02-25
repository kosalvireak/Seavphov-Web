import axiosInstance from "../services/axiosInstance.js";
import { getCookie } from "../services/cookie.js";

const backend_url = import.meta.env.VITE_BACKEND_URL;
const api_token = getCookie()?.api_token || null; // if user just login and access profile, the api_token won't invoke to get cookie again it will be null and get unauthorize

export async function getData(route, auth = false) {
  const headers = auth
    ? {
        Authorization: `Bearer ${api_token}`,
      }
    : {};
  return await axiosInstance.get(backend_url + route, { headers });
}

export async function postJson(route, body) {
  return await axiosInstance.post(backend_url + route, body, {
    headers: {
      "Content-Type": "application/json",
    },
  });
}

export async function postForm(route, body, auth = false) {
  const headers = {
    "Content-Type": "multipart/form-data",
  };
  if (auth) {
    headers.Authorization = `Bearer ${api_token}`;
  }
  return await axiosInstance.post(backend_url + route, body, {
    headers,
  });
}

export async function deleteData(route) {
  const headers = {
    Authorization: `Bearer ${api_token}`,
  };
  return await axiosInstance.delete(backend_url + route, {
    headers,
  });
}
