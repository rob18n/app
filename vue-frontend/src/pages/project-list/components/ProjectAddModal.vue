<template>
    <div>
        <a href="#" class="btn btn-primary" @click="openModal">{{ t('button.add.project') }}</a>
        <!-- Modal -->
        <div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="projectAddModalLabel"
            aria-hidden="true" ref="modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectAddModalLabel">{{ t('modal.project.add.field.title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-start">
                        <div class="general-data mb-3">
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ t('modal.project.add.field.title') }}</label>
                                <input type="text" class="form-control" id="title"
                                    :placeholder="t('modal.project.add.field.title.placeholder')" v-model="title">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    {{ t('modal.project.add.field.description') }}
                                </label>
                                <textarea class="form-control" id="description" rows="3"
                                    v-model="description"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="language-data">
                            <p class="fs-5">{{ t('modal.project.add.languages.title') }}</p>
                            <p>{{ t('modal.project.add.languages.info') }}</p>
                            <SearchSelectInput @addLanguage="addLanguage" :selected-languages="selectedLanguages"
                                class="mb-3"></SearchSelectInput>

                            <ul class="list-group">
                                <li class="list-group-item" v-if="!selectedLanguages.length">
                                    {{ t('general.no-entries') }}
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    v-for="(language, index) in selectedLanguages">
                                    {{ language.shortkey }}

                                    <div class="btn-group" role="group" aria-label="List">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            @click="togglePrimary(language)">
                                            <BsStarFill v-if="language.primary"></BsStarFill>
                                            <BsStar v-else></BsStar>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            @click="removeLanguage(language)">
                                            <BsBan></BsBan>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-primary" @click="store" :disabled="!hasContent">
                            {{ t('button.submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { Modal } from 'bootstrap'
import { useProjectStore } from '@/stores/projectStore'
import SearchSelectInput from './SearchSelectInput.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const projectStore = useProjectStore()
const modal = ref(null)
const title = ref('')
const description = ref('')
const selectedLanguages = ref([])

let bootstrapModal = null

const togglePrimary = function (language) {
    selectedLanguages.value.forEach(lang => {
        lang.primary = lang.shortkey === language.shortkey
    })
}

const removeLanguage = function (language) {
    selectedLanguages.value = selectedLanguages.value.filter(
        l => l.shortkey !== language.shortkey
    )

    if (selectedLanguages.value.length == 1) {
        selectedLanguages.value[0].primary = true
    }
}

const addLanguage = function (language) {
    language.primary = selectedLanguages.value.length ? false : true
    selectedLanguages.value.push(language)
}

const hasContent = computed(() => {
    return title.value && description.value && selectedLanguages.value.length
})

const openModal = () => {
    if (bootstrapModal) {
        bootstrapModal.show()
    }
}

const store = () => {
    projectStore.store(title.value, description.value, selectedLanguages.value).then(t => {
        title.value = ''
        description.value = ''
        selectedLanguages.value = []
        bootstrapModal.hide()
    })
}

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
})
</script>
