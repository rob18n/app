<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="projectDestroyModal" tabindex="-1" aria-labelledby="projectDestroyModalLabel"
            aria-hidden="true" ref="modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectDestroyModalLabel">{{ t('modal.variable.delete.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start" v-if="variable">
                        {{ t('modal.variable.delete.info', { key: variable.key }) }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ t('button.cancel') }}
                        </button>
                        <button type="button" class="btn btn-primary" @click="destroy">
                            {{ t('button.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, watch } from 'vue'
import { Modal } from 'bootstrap'
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { useModalStore } from '@/stores/modalStore'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const modalStore = useModalStore()
const props = defineProps(['variable'])
const selectedProjectStore = useSelectedProjectStore()
const modal = ref(null)

let bootstrapModal = null

const destroy = () => {
    selectedProjectStore.destroy(props.variable.id).then(() => {
        bootstrapModal.hide()
    })
}

const onModalHidden = () => {
    modalStore.variableDeleteModalIsOpen = false
}

watch(
    () => modalStore.variableDeleteModalIsOpen,
    (newValue) => {
        if (newValue) {
            bootstrapModal.show()
        } else {
            bootstrapModal.hide()
        }
    }
)

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
