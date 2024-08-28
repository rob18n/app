<template>
    <div>
        <button class="btn btn-primary w-100" @click="openModal">{{ t('modal.variable.add.title') }}</button>
        <!-- Modal -->
        <div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="projectAddModalLabel"
            aria-hidden="true" ref="modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectAddModalLabel">{{ t('modal.variable.add.title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-start">
                        <div class="general-data mb-3">
                            <div class="mb-3">
                                <label for="key" class="form-label">{{ t('modal.variable.add.field.title') }}</label>
                                <input type="text" class="form-control" id="key"
                                    :placeholder="t('modal.variable.add.field.placeholder')" v-model="key">

                                <div id="emailHelp" class="form-text text-danger" v-if="keyExists">
                                    {{ t('modal.variable.add.field.error') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    {{ t('modal.variable.add.field.description') }}
                                </label>
                                <textarea class="form-control" id="description" rows="3"
                                    v-model="description"></textarea>
                            </div>

                            <hr>

                            <div class="mb-3" v-for="language in projectLanguages" :key="language.id">
                                <label for="values" class="form-label">{{ language.shortkey }}</label>
                                <textarea class="form-control" id="values" rows="3"
                                    v-model="values[language.id]"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="addMoreKeys" id="addMoreKeys">
                            <label class="form-check-label" for="addMoreKeys">
                                {{ t('modal.variable.add.nextkey') }}
                            </label>
                        </div>
                        <div class="mb-3" v-if="addMoreKeys">
                            <input type="text" class="form-control" id="startkey"
                                :placeholder="t('modal.variable.add.nextkey.placeholder')" v-model="keyPreset">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ t('button.cancel') }}
                        </button>
                        <button type="button" class="btn btn-primary" @click="store"
                            :disabled="!hasContent || isLoading">
                            {{ buttonText }}
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
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const selectedProjectStore = useSelectedProjectStore()
const { languages } = selectedProjectStore
const modal = ref(null)
const key = ref('')
const description = ref('')
const values = ref({})
const route = useRoute()
const keyExists = ref(false)
const isLoading = ref(false)
const addMoreKeys = ref(false)
const keyPreset = ref('')

let bootstrapModal = null

const openModal = () => {
    if (bootstrapModal) {
        bootstrapModal.show()
    }
}

const store = () => {
    isLoading.value = true
    if (!selectedProjectStore.checkIfKeyExists(key.value)) {
        selectedProjectStore.store(key.value, description.value, values.value, route.params.id).then(() => {
            key.value = ''
            description.value = ''
            values.value = {}
            keyExists.value = false

            if (!addMoreKeys.value) {
                bootstrapModal.hide()
            } else {
                key.value = keyPreset.value
            }
        })
    } else {
        keyExists.value = true
    }
    isLoading.value = false
}

const hasContent = computed(() => {
    return key.value
})

const projectLanguages = computed(() => {
    return selectedProjectStore.languages
})

const buttonText = computed(() => {
    return isLoading.value == true ? t('general.loading') : t('button.submit')
})

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
})
</script>