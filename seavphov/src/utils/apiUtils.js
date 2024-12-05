import axiosInstance from "../../axiosInstance.js";

const backend_url = import.meta.env.VITE_BACKEND_URL;

export async function getData(route, auth = false, apiToken = null) {
  const headers = auth ? {
    'Authorization': `Bearer ${apiToken}`
  } : {}
  return await axiosInstance.get(backend_url + route, { headers })
}

export async function postJson(route, body) {
  return await axiosInstance.post(backend_url + route, body, {
    headers: {
      'Content-Type': 'application/json',
    },
  });
}

export async function postForm(route, body, auth = false, apiToken = null) {
  const headers = {
    'Content-Type': 'multipart/form-data'
  };
  if (auth) {
    headers.Authorization = `Bearer ${apiToken}`;
  }
  return await axiosInstance.post(backend_url + route, body, {
    headers
  });
}