<template>
    <div>
        <button class="btn btn-primary w-100" @click="openModal">Hinzufügen</button>
        <!-- Modal -->
        <div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="projectAddModalLabel"
            aria-hidden="true" ref="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectAddModalLabel">Variable hinzufügen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-start">
                        <div class="general-data mb-3">
                            <div class="mb-3">
                                <label for="key" class="form-label">Name</label>
                                <input type="text" class="form-control" id="key" placeholder="Hello world"
                                    v-model="key">

                                <div id="emailHelp" class="form-text text-danger" v-if="keyExists">Der Key ist schon
                                    vergeben.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Beschreibung</label>
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
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
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

const selectedProjectStore = useSelectedProjectStore()
const { languages } = selectedProjectStore
const modal = ref(null)
const key = ref('')
const description = ref('')
const values = ref({})
const route = useRoute()
const keyExists = ref(false)
const isLoading = ref(false)

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
            bootstrapModal.hide()
        })
    } else {
        keyExists.value = true
    }
    isLoading.value = false
}

const hasContent = computed(() => {
    return key.value && Object.values(values.value).some(val => val.trim() !== '')
})

const projectLanguages = computed(() => {
    return selectedProjectStore.languages
})

const buttonText = computed(() => {
    return isLoading.value == true ? 'Lädt ...' : 'absenden'
})

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
})
</script>