<template>
    <div>
        <button type="button" class="btn btn-danger" @click="openModal">
            <BsTrashFill />
        </button>
        <!-- Modal -->
        <div class="modal fade" id="projectDestroyModal" tabindex="-1" aria-labelledby="projectDestroyModalLabel"
            aria-hidden="true" ref="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectDestroyModalLabel">Projekt löschen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <span>Möchtest du das Projekt "<span class="fw-bold">{{ project.title }}</span>" wirklich
                            löschen?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-primary" @click="destroy">Absenden</button>
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
