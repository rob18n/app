<template>
    <div>
        <div class="drag-drop-upload p-5 border rounded" :class="{ 'drag-over': isDragOver }"
            @dragover.prevent="handleDragOver" @dragleave.prevent="handleDragLeave" @drop.prevent="handleDrop"
            @click="openFileDialog">
            <div class="text-center">
                <BsUpload />
                <p class="pt-3">Ziehe die Dateien mit Drag and Drop hier rein, oder klicke auf das Feld.</p>
            </div>
            <input type="file" ref="fileInputRef" class="d-none" @change="handleFileSelect" multiple accept=".json" />
        </div>

        <ul v-if="files.length" class="file-list list-group mt-3">
            <li v-for="(fileObj, index) in files" :key="index"
                class="list-group-item d-flex flex-column align-items-start">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <span>{{ fileObj.file.name }}</span>
                    <button class="btn btn-danger btn-sm" @click="removeFile(index)">Delete</button>
                </div>
                <select class="form-select mt-2" v-model="fileObj.language" @change="handleLanguageChange">
                    <option value="" disabled>Select language</option>
                    <option v-for="lang in availableLanguages(fileObj)" :key="lang.id" :value="lang.id">
                        {{ lang.shortkey }}
                    </option>
                </select>
            </li>
        </ul>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary mt-3" @click="uploadFiles" :disabled="!filesReadyForUpload">Upload
                Files</button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import config from '@/config'

const selectedProjectStore = useSelectedProjectStore()
const { languages, project } = selectedProjectStore
const isDragOver = ref(false)
const files = ref([])
const fileInputRef = ref(null)

const handleDragOver = () => {
    isDragOver.value = true
}

const handleDragLeave = () => {
    isDragOver.value = false
}

const handleDrop = (event) => {
    isDragOver.value = false
    const droppedFiles = Array.from(event.dataTransfer.files)
    addFiles(droppedFiles)
}

const handleFileSelect = (event) => {
    const selectedFiles = Array.from(event.target.files)
    addFiles(selectedFiles)
}

const addFiles = (newFiles) => {
    newFiles.forEach(newFile => {
        if (!files.value.some(file => file.file.name === newFile.name)) {
            files.value.push({
                file: newFile,
                language: ''
            })
        }
    })
}

const projectLanguages = computed(() => {
    return selectedProjectStore.languages
})

const openFileDialog = () => {
    fileInputRef.value.click()
}

const removeFile = (index) => {
    files.value.splice(index, 1)
}

const availableLanguages = (currentFile) => {
    const selectedLanguages = files.value
        .filter(file => file !== currentFile && file.language)
        .map(file => file.language)
    return projectLanguages.value.filter(lang => !selectedLanguages.includes(lang.shortkey))
}

const filesReadyForUpload = computed(() => {
    return files.value.length > 0 && files.value.every(file => file.language && file.language !== '')
})

const uploadFiles = async () => {
    try {
        const formData = new FormData()

        files.value.forEach((fileObj, index) => {
            formData.append(`files[${index}][file]`, fileObj.file)
            formData.append(`files[${index}][language]`, fileObj.language || '')
            formData.append(`project_id`, selectedProjectStore.project.id)
        })

        const response = await axios.post(`${config.apiUrl}/language-key/import`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })

        console.log(response.data)
    } catch (error) {
        console.error('Error uploading files:', error)
    }
}
</script>
