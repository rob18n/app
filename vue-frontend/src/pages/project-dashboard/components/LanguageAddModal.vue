<template>
    <div>
        <a href="#" class="btn btn-primary" @click="openModal">{{ t('button.add.language') }}</a>
        <!-- Modal -->
        <div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="languageAddModalLabel"
            aria-hidden="true" ref="modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="languageAddModalLabel">{{ t('modal.language.add.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="language-data">
                            <SearchSelectInput @addLanguage="addLanguage" :selected-languages="selectedLanguages"
                                class="mb-3"></SearchSelectInput>
                        </div>

                        <div v-if="newLanguage">
                            {{ t('modal.language.add.new-language', { key: newLanguage.shortkey }) }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="hide">
                            {{ t('button.cancel') }}
                        </button>
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
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import SearchSelectInput from './SearchSelectInput.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const projectStore = useProjectStore()
const selectedProjectStore = useSelectedProjectStore()
const modal = ref(null)
const newLanguage = ref(null)
let bootstrapModal = null


const addLanguage = function (language) {
    selectedLanguages.value.push(language)
    newLanguage.value = language
}

const hasContent = computed(() => {
    return newLanguage
})

const selectedLanguages = computed(() => {
    return selectedProjectStore.languages
})

const openModal = () => {
    if (bootstrapModal) {
        bootstrapModal.show()
    }
}

const store = () => {
    selectedProjectStore.addLanguage(newLanguage.value).then(t => {
        newLanguage.value = null
        bootstrapModal.hide()
    })
}


const hide = () => {
    newLanguage.value = null
    bootstrapModal.hide()
}

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
})
</script>
