import axios from 'axios';


const http = axios.create({
  baseURL: window.location.origin+'/api',
  withCredentials:true,
  headers: {    
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Content-Type': 'multipart/form-data'
  }
});

export default http;