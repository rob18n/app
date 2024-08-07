<template>
    <div>
        <a href="#" class="btn btn-primary" @click="openModal">Add project</a>
        <!-- Modal -->
        <div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="projectAddModalLabel"
            aria-hidden="true" ref="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectAddModalLabel">Projekt hinzufügen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label for="title" class="form-label">Projektname</label>
                            <input type="text" class="form-control" id="title" placeholder="Hello world"
                                v-model="title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Beschreibung</label>
                            <textarea class="form-control" id="description" rows="3" v-model="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-primary" @click="store"
                            :disabled="!hasContent">Absenden</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { Modal } from 'bootstrap';
import { useProjectStore } from '@/stores/projectStore'

const projectStore = useProjectStore()
const modal = ref(null)
const title = ref('')
const description = ref('')

let bootstrapModal = null

const hasContent = computed(() => {
    return title.value && description.value
})

const openModal = () => {
    if (bootstrapModal) {
        bootstrapModal.show();
    }
};

const store = () => {
    projectStore.store(title.value, description.value).then(t => {
        title.value = ''
        description.value = ''
        bootstrapModal.hide()
    })
}

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
})
</script>
