
import { ref, inject } from 'vue'
import { defineStore } from 'pinia'
import config from '@/config';

export const useProjectStore = defineStore('projectStore', () => {
    const projects = ref([])
    const axios = inject('axios')
    const projectsLoaded = ref(false)

    const get = function (key) {
        return axios.get(`${config.apiUrl}/projects`, {})
            .then((response) => {
                projects.value = response.data
            }).catch((e) => {
                return e
            }).finally((f => {
                projectsLoaded.value = true
            }))
    }

    const store = async function (title, description, selectedLanguages) {
        return axios.post(`${config.apiUrl}/projects`, {
            title: title,
            description: description,
            selectedLanguages: JSON.stringify(selectedLanguages)
        }).then((response) => {
            projects.value.push(response.data)
        }).catch((e) => {
            return e
        }).finally((f => {
            projectsLoaded.value = true
        }))
    }

    const update = async function (id, title, description) {
        return axios.put(`${config.apiUrl}/projects/${id}`, {
            title: title,
            description: description
        }).then((response) => {
            const index = projects.value.findIndex(project => project.id === id)
            projects.value[index].title = title
            projects.value[index].description = description

        }).catch((e) => {
            return e
        })
    }

    const destroy = async function (id) {
        return axios.delete(`${config.apiUrl}/projects/${id}`, {}).then((response) => {
            const index = projects.value.findIndex(project => project.id === id)
            projects.value.splice(index, 1)
        }).catch((e) => {
            return e
        })
    }

    return {
        projects, projectsLoaded,
        get, store, update, destroy
    }
})