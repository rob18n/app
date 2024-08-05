import axios from "axios";

export default {
    install: (app, options) => {
        const myAxios = axios.create();

        myAxios.interceptors.request.use(
            config => {
                return config;
            },
            error => {
                return Promise.reject(error);
            }
        );

        myAxios.interceptors.response.use(
            function (response) {
                return response;
            },
            function (error) {
                return Promise.reject(error);
            }
        );

        app.provide("axios", myAxios);
    },
};