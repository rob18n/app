<template>
    <div id="sidebar-container" class="col-12 col-md-4">
        <div id="sidebar" class="d-flex flex-column">
            <div class="search-box mb-3">
                <label for="keySearchInput" class="form-label">Suche</label>
                <input type="text" class="form-control" id="keySearchInput" placeholder="Key eingeben" />
            </div>

            <div class="sort-box mb-3 d-flex justify-content-end">
                <button class="btn btn-secondary">Sortieren</button>
            </div>

            <div class="entries flex-grow-1 w-100">
                <ul class="list-group">
                    <li class="List-group-item" v-if="!hasLoaded">
                        Lädt ...
                    </li>
                    <li class="list-group-item list-group-item-info" v-if="hasLoaded && !hasEntries">
                        Keine Einträge vorhanden
                    </li>
                    <li class="list-group-item" v-for="entry in keyEntries" :key="entry.key">
                        a
                        <p class="fs-6">{{ entry.key }}</p>
                    </li>
                </ul>
            </div>

            <div class="add-box mt-3">
                <LanguageVariableAddModal></LanguageVariableAddModal>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import LanguageVariableAddModal from './LanguageVariableAddModal.vue'

const selectedProjectStore = useSelectedProjectStore()
const { projectsLoaded, projects } = selectedProjectStore

const hasLoaded = computed(() => {
    return selectedProjectStore.projectLoaded
})

const keyEntries = computed(() => {
    return selectedProjectStore.keys
})

const hasEntries = computed(() => {
    return selectedProjectStore.keys.length
})
</script>

<style lang="scss" scoped></style>
