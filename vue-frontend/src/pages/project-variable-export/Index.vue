<template>
    <div id="project-variable-import">
        <h2>Datei Export</h2>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="col-4">
                            <label for="format-selection">Exportformat auswählen</label>
                            <select id="format-selection" class="form-select" v-model="format">
                                <option disabled>Auswählen</option>
                                <option value="json" selected>.json</option>
                            </select>
                        </div>
                        <div class="col-8 mt-3">
                            <label for="language-selection">Sprachen auswählen</label>
                            <select class="form-select" v-model="selectedLanguages">
                                <option :value="null" selected>Alle Sprachen</option>
                                <option v-for="language in selectedProjectStore.languages" :value="language.shortkey"
                                    :key="language.id">{{ language.shortkey }}</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary" @click="submit">Absenden</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, inject, onMounted } from 'vue'
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import config from '@/config';

const axios = inject('axios')
const selectedProjectStore = useSelectedProjectStore()
const { languages, project } = selectedProjectStore
const projectLanguageIds = ref([])
const format = ref('json')
const selectedLanguages = ref(null)

const submit = function () {
    if (selectedLanguages.value == null) {
        selectedLanguages.value = selectedProjectStore.languages.map(obj => obj.shortkey);
    } else {
        selectedLanguages.value = [selectedLanguages.value]
    }

    return axios.post(`${config.apiUrl}/language-key/export`, {
        project_id: selectedProjectStore.project.id,
        format: format.value,
        languages: JSON.stringify(selectedLanguages.value)
    }).then((response) => {
        window.open(response.data, '_blank')
    }).catch((e) => {
        return e
    })
}
</script>