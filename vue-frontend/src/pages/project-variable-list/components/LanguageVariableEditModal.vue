<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="projectEditModal" tabindex="-1" aria-labelledby="projectEditModalLabel"
            aria-hidden="true" ref="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectEditModalLabel">Variable bearbeiten</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start" v-if="variable">
                        <div class="mb-3">
                            <label for="key" class="form-label">Name</label>
                            <input type="text" class="form-control" id="key" placeholder="Hello world" v-model="key">

                            <div id="emailHelp" class="form-text text-danger" v-if="keyExists">Der Key ist schon
                                vergeben.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Beschreibung</label>
                            <textarea class="form-control" id="description" rows="3" v-model="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-primary" @click="edit" :disabled="isLoading">{{ buttonText
                            }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, watch, computed } from 'vue'
import { Modal } from 'bootstrap'
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { useModalStore } from '@/stores/modalStore'

const modalStore = useModalStore()
const props = defineProps(['variable'])
const selectedProjectStore = useSelectedProjectStore()
const modal = ref(null)
const key = ref('')
const description = ref('')
const isLoading = ref(false)
const keyExists = ref(false)

let bootstrapModal = null

const edit = () => {
    if (!selectedProjectStore.checkIfKeyExists(key.value)) {
        keyExists.value = false
    } else {
        keyExists.value = true
    }
    selectedProjectStore.updateKey(key.value, description.value).then(() => {
        bootstrapModal.hide()
    })
}

const onModalHidden = () => {
    modalStore.variableEditModalIsOpen = false
}

watch(
    () => modalStore.variableEditModalIsOpen,
    (newValue) => {
        if (newValue) {
            key.value = props.variable.key
            description.value = props.variable.description
            bootstrapModal.show()
        } else {
            bootstrapModal.hide()
        }
    }
)

const buttonText = computed(() => {
    return isLoading.value == true ? 'Lädt ...' : 'absenden'
})

onMounted(() => {
    bootstrapModal = new Modal(modal.value)

    const modalElement = modal.value
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', onModalHidden)
    }
})

onBeforeUnmount(() => {
    const modalElement = modal.value
    if (modalElement) {
        modalElement.removeEventListener('hidden.bs.modal', onModalHidden)
    }
})
</script>
