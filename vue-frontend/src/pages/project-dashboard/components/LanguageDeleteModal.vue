<template>
    <div>
        <a href="#" class="btn btn-danger button-sm" @click="openModal">
            <BsBan></BsBan>
        </a>
        <!-- Modal -->
        <div class="modal fade" id="projectAddModal" tabindex="-1" aria-labelledby="languageDeleteModalLabel"
            aria-hidden="true" ref="modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="languageDeleteModalLabel">{{ t('modal.language.delete.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        {{ t('modal.language.delete.info', { name: name }) }}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="hide">
                            {{ t('button.cancel') }}
                        </button>
                        <button type="button" class="btn btn-primary" @click="destroy">
                            {{ t('button.submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, computed, defineProps } from 'vue'
import { Modal } from 'bootstrap'
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const selectedProjectStore = useSelectedProjectStore()
const modal = ref(null)
const props = defineProps(['language'])
let bootstrapModal = null

const destroy = function () {
    selectedProjectStore.destroyLanguage(props.language).then(r => {
        bootstrapModal.hide()
    })
}

const openModal = () => {
    if (bootstrapModal) {
        bootstrapModal.show()
    }
}

const hide = () => {
    bootstrapModal.hide()
}

const name = computed(() => {
    return props.language.name
})

onMounted(() => {
    bootstrapModal = new Modal(modal.value)
})
</script>
