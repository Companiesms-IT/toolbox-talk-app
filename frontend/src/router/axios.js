// src/axios.js
import axios from "axios";
// Create an instance of Axios
const axiosInstance = axios.create({
  baseURL: "https://companymanagementsystems-back-qa.chetu.com/api/v1", // Base URL for your API
  headers: {
    "Content-Type": "application/json",
    "Content-Type": "multipart/form-data", // Adjust if needed
  },
  withCredentials: false,
});
// Request interceptor
axiosInstance.interceptors.request.use(
  (config) => {
    // Perform actions before sending the request
    // You can add additional headers or modify the request here
    return config;
  },
  (error) => {
    // Handle request error
    return Promise.reject(error);
  }
);
// Response interceptor
axiosInstance.interceptors.response.use(
  (response) => {
    // Perform actions on response data
    return response;
  },
  (error) => {
    // Handle response error
    return Promise.reject(error);
  }
);
export default axiosInstance;
