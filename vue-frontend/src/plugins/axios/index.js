import axios from "axios";

export default {
    install: (app, options) => {
        const myAxios = axios.create({
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

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
        myAxios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
        app.provide("axios", myAxios);
    },
};
