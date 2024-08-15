import { ref, inject } from 'vue'
import { defineStore } from 'pinia'
import config from '@/config';

export const useSelectedProjectStore = defineStore('selectedProjectStore', () => {
    const project = ref([])
    const keys = ref([])
    const languages = ref([])
    const axios = inject('axios')
    const projectLoaded = ref(false)
    const selectedVariable = ref(null)

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
        return axios.post(`${config.apiUrl}/project-languages-key`, {
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

    const updateKey = async function (key, description) {
        return axios.put(`${config.apiUrl}/project-languages-key/${selectedVariable.value.id}`, {
            key: key,
            description: description,
        }).then((response) => {
            const variableIndex = keys.value.findIndex(k => k.id === response.data.id)
            keys.value[variableIndex].key = response.data.key
            keys.value[variableIndex].description = response.data.description
        }).catch((e) => {
            return e
        })
    }

    const updateKeyValue = async function (variable) {
        return axios.put(`${config.apiUrl}/project-languages-key-value/${variable.id}`, {
            value: variable.value,
        }).then((response) => {
            const keyIndex = project.value.keys.findIndex(k => k.id === variable.language_key_id)
            const variableIndex = project.value.keys[keyIndex].values.findIndex(v => v.id === variable.id)

            project.value.keys[keyIndex].values[variableIndex].value = variable.value
        }).catch((e) => {
            return e
        })
    }

    const destroy = async function (id) {
        return axios.delete(`${config.apiUrl}/project-languages-key/${id}`, {}).then((response) => {
            const index = project.value.keys.findIndex(v => v.id === id)
            project.value.keys.splice(index, 1)

            selectedVariable.value = null
        }).catch((e) => {
            return e
        })
    }

    const checkIfKeyExists = function (key) {
        return keys.value.findIndex(k => k.key === key && k.id != key.id) !== -1
    }

    const selectVariable = function (variable) {
        selectVariable.value = variable
    }

    return {
        project, projectLoaded, keys, languages, selectedVariable,
        get, store, checkIfKeyExists, selectVariable, updateKeyValue, destroy, updateKey
    }
})