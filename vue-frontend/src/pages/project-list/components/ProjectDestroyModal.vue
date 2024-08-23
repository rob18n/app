<template>
    <div>
        <div class="btn btn-danger" @click.stop.prevent="openModal">
            <BsTrashFill />
        </div>
        <!-- Modal -->
        <div class="modal fade" id="projectDestroyModal" tabindex="-1" aria-labelledby="projectDestroyModalLabel"
            aria-hidden="true" ref="modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectDestroyModalLabel">
                            {{ t('modal.project.delete.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <span>{{ t('modal.project.delete.info', { title: project.title }) }}</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ t('button.cancel') }}
                        </button>
                        <button type="button" class="btn btn-delete" @click="destroy">
                            {{ t('button.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { Modal } from 'bootstrap'
import { useProjectStore } from '@/stores/projectStore'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const props = defineProps(['project'])
const projectStore = useProjectStore()
const modal = ref(null)

let bootstrapModal = null

const openModal = () => {
    if (bootstrapModal) {
        bootstrapModal.show()
    }
}

const destroy = () => {
    projectStore.destroy(props.project.id).then(t => {
        bootstrapModal.hide()
    })
}

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
})
</script>
