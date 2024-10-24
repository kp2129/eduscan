import axiosLib from "axios";
import { getToken } from "../services/TokenServices";

const axios = axiosLib.create({
    baseURL: "http://10.13.38.200:8000/api",
    headers: {
        Accept: "application/json",
        
    }
});

axios.interceptors.request.use(async(req) => {
    const token = await getToken();
    if(token != null) {
        req.headers["Authorization"] = `Bearer ${token}`;
    }
    return req;
})

export default axios;