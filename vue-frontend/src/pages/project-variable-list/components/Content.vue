<template>
    <div id="content" class="col-12 col-md-8 mt-3 mt-md-0">
        <div v-if="showContent">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>{{ variable.key }}</h5>
                    <p>{{ variable.description }}</p>
                </div>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" @click="openEditModal">
                            <BsPencilFill />
                        </button>
                        <button type="button" class="btn btn-danger" @click="openDeleteModal">
                            <BsTrashFill />
                        </button>
                    </div>
                </div>
            </div>
            <div class="mb-3" v-for="key in variable.values">
                <label for="description" class="form-label">{{ key.language.shortkey }}</label>
                <textarea class="form-control" id="description" rows="3" v-model="key.value"
                    @blur="update(key)"></textarea>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center align-items-center h-100">
            <div class="text-center">
                <p class="fs-5">{{ t('page.variables.content.no-selection') }}</p>
                <p>{{ t('page.variables.content.no-selection.info') }}</p>
            </div>
        </div>
        <LanguageVariableDestroyModal :variable="variable"></LanguageVariableDestroyModal>
        <LanguageVariableEditModal :variable="variable"></LanguageVariableEditModal>
    </div>
</template>
<script setup>
import { computed } from "vue";
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { useModalStore } from '@/stores/modalStore'
import LanguageVariableDestroyModal from './LanguageVariableDestroyModal.vue'
import LanguageVariableEditModal from './LanguageVariableEditModal.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const modalStore = useModalStore()
const { variableDeleteModalIsOpen, variableEditModalIsOpen } = modalStore
const selectedProjectStore = useSelectedProjectStore()
const { selectedVariable, selectVariable, updateKeyValue } = selectedProjectStore

const update = function (key) {
    selectedProjectStore.updateKeyValue(key)
}

const openDeleteModal = function () {
    modalStore.variableDeleteModalIsOpen = true
}

const openEditModal = function () {
    modalStore.variableEditModalIsOpen = true
}

const showContent = computed(() => {
    return selectedProjectStore.selectedVariable != null
})

const variable = computed(() => {
    return selectedProjectStore.selectedVariable
})
</script>