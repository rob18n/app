
import { ref, inject } from 'vue'
import { defineStore } from 'pinia'
import config from '@/config';

export const useLanguageStore = defineStore('languageStore', () => {
    const languages = ref([])
    const axios = inject('axios')
    const languagesLoaded = ref(false)

    const get = function (key) {
        return axios.get(`${config.apiUrl}/languages`, {})
            .then((response) => {
                languages.value = response.data
            }).catch((e) => {
                return e
            }).finally((f => {
                languagesLoaded.value = true
            }))
    }

    return {
        languages,
        get
    }
})