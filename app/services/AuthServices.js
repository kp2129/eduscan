import axios from "../utils/axios";
import { setToken } from "./TokenServices";

export async function login(credentials) {
    const { data } = await axios.post('/login', credentials);
    await setToken(data.token);
    console.log(data.token);

}

export async function loadUser() {
    const { data: user } = await axios.get(`/user`)
    return user;
}

export async function fetchQR() {
    const { data: qr } = await axios.get(`/qr`)
    return qr;

}

export async function validateQR(token) {
    const { data } = await axios.post('/validate-qr-code', { token: token });
    return data;
}


export async function logout() {
    await axios.post('/logout')
    await setToken(null);
}

export async function register(registerInfo) {
    const { data } = await axios.post('/register', registerInfo);
    await setToken(data.token);

}



