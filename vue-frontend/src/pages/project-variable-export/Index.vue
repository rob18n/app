<template>
    <div id="project-variable-import">
        <h2>{{ t('page.export.title') }}</h2>
        <div class="row">
            <div class="col-12">
                <p v-html="t('page.export.description')"></p>
            </div>
            <div class="col-12 col-md-8 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="col-4">
                            <label for="format-selection">{{ t('page.export.field.format.title') }}</label>
                            <select id="format-selection" class="form-select" v-model="format">
                                <option disabled>{{ t('page.export.field.format.placeholder') }}</option>
                                <option value="json" selected>.json</option>
                                <option value="php" selected>.php</option>
                            </select>
                        </div>
                        <div class="col-8 mt-3">
                            <label for="language-selection">{{ t('page.export.field.language.title') }}</label>
                            <select class="form-select" v-model="selectedLanguages">
                                <option :value="null" selected>
                                    {{ t('page.export.field.language.placeholder') }}
                                </option>
                                <option v-for="language in selectedProjectStore.languages" :value="language.shortkey"
                                    :key="language.id">{{ language.shortkey }}</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary" @click="submit">
                                {{ t('button.submit') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import config from '@/config'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const axios = inject('axios')
const selectedProjectStore = useSelectedProjectStore()
const { languages, project } = selectedProjectStore
const projectLanguageIds = ref([])
const format = ref('json')
const selectedLanguages = ref(null)

const submit = function () {
    if (selectedLanguages.value == null) {
        projectLanguageIds.value = selectedProjectStore.languages.map(obj => obj.shortkey);
    } else {
        projectLanguageIds.value = [{ shortkey: selectedLanguages.value }];
    }

    return axios.post(`${config.apiUrl}/language-key/export`, {
        project_id: selectedProjectStore.project.id,
        format: format.value,
        languages: JSON.stringify(projectLanguageIds.value)
    }).then((response) => {
        window.open(response.data, '_blank')
    }).catch((e) => {
        return e
    })
}
</script>