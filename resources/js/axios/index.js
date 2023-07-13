import axios from "axios";
console.log({env:process.env.MIX_HOST})
const http = axios.create({
  baseURL: process.env.MIX_HOST || 'http://localhost:8002/'
})

export default http;
