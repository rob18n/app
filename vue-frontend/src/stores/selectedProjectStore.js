import { ref, inject } from 'vue'
import { defineStore } from 'pinia'
import config from '@/config';

export const useSelectedProjectStore = defineStore('selectedProjectStore', () => {
    const project = ref([])
    const keys = ref([])
    const languages = ref([])
    const axios = inject('axios')
    const projectLoaded = ref(false)

    const get = function (id) {
        return axios.get(`${config.apiUrl}/projects/${id}`, {})
            .then((response) => {
                project.value = response.data
                keys.value = response.data.keys
                languages.value = response.data.languages
            }).catch((e) => {
                return e
            }).finally((f => {
                projectLoaded.value = true
            }))
    }

    const store = async function (key, description, values, id) {
        return axios.post(`${config.apiUrl}/project-languages`, {
            id: id,
            key: key,
            description: description,
            values: JSON.stringify(values)
        }).then((response) => {
            keys.value.push(response.data)
        }).catch((e) => {
            return e
        })
    }

    const checkIfKeyExists = function (key) {
        return keys.value.findIndex(k => k.key === key) !== -1
    }

    return {
        project, projectLoaded, keys, languages,
        get, store, checkIfKeyExists
    }
})