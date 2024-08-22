<template>
    <div>
        <button type="button" class="btn btn-secondary" @click="openModal">
            <BsPencilFill />
        </button>
        <!-- Modal -->
        <div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="projectAddModalLabel"
            aria-hidden="true" ref="modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectAddModalLabel">{{ t('modal.project.edit.title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label for="title-edit" class="form-label">{{ t('modal.project.edit.field.title') }}</label>
                            <input type="text" class="form-control" id="title-edit"
                                :placeholder="t('modal.project.edit.title.placeholder')" v-model="title">
                        </div>
                        <div class="mb-3">
                            <label for="description-edit" class="form-label">
                                {{ t('modal.project.edit.description.title') }}
                            </label>
                            <textarea class="form-control" id="description-edit" rows="3"
                                v-model="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
import { computed, onMounted, ref } from 'vue';
import { Modal } from 'bootstrap';
import { useProjectStore } from '@/stores/projectStore'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const props = defineProps(['project'])
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
        bootstrapModal.show()
    }
};

const store = () => {
    projectStore.update(props.project.id, title.value, description.value).then(t => {
        bootstrapModal.hide()
    })
}

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
    title.value = props.project.title
    description.value = props.project.description
})
</script>
