<template>
    <div id="sidebar-container" class="col-12 col-md-4">
        <div id="sidebar" class="d-flex flex-column">
            <div class="search-box card mb-3">
                <div class="card-body">
                    <label for="keySearchInput" class="form-label">{{ t('page.variable.search') }}</label>
                    <input type="text" class="form-control" id="keySearchInput"
                        :placeholder="t('page.variable.search.placeholder')" v-model="searchInput" />
                </div>
            </div>

            <div class="sort-box mb-3 d-flex justify-content-end">
                <div class="btn-group">
                    <button class="btn btn-secondary" @click="toggleDropdown">
                        {{ t('button.sort') }}
                    </button>
                    <ul v-show="isDropdownOpen" class="dropdown-menu show dropdown-menu-end"
                        style="left: auto; right: 0; top: 40px;">
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="setSortOrder('key', 'asc')">
                                {{ t('sort.alpha.asc') }}
                                <span v-if="sortBy === 'key' && sortOrder === 'asc'">
                                    <AkCheck />
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="setSortOrder('key', 'desc')">
                                {{ t('sort.alpha.desc') }}
                                <span v-if="sortBy === 'key' && sortOrder === 'desc'">
                                    <AkCheck />
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="setSortOrder('id', 'asc')">
                                {{ t('sort.creation.asc') }}
                                <span v-if="sortBy === 'id' && sortOrder === 'asc'">
                                    <AkCheck />
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="setSortOrder('id', 'desc')">
                                {{ t('sort.creation.desc') }}
                                <span v-if="sortBy === 'id' && sortOrder === 'desc'">
                                    <AkCheck />
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="entries flex-grow-1 w-100">
                <ul class="list-group">
                    <li class="list-group-item" v-if="!hasLoaded">
                        {{ t('general.loading') }}
                    </li>
                    <li class="list-group-item list-group-item-info" v-if="hasLoaded && !hasEntries">
                        {{ t('general.no-entries') }}
                    </li>
                    <li class="list-group-item list-group-item-action" v-for="(entry, index) in sortedEntries"
                        :key="entry.key" @click="selectVariable(entry)">
                        <p>{{ entry.key }}</p>
                        <small class="text-muted">{{ entry.description }}</small>
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
import { computed, ref } from "vue";
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import LanguageVariableAddModal from './LanguageVariableAddModal.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const selectedProjectStore = useSelectedProjectStore()
const { projectsLoaded, projects, selectedVariable } = selectedProjectStore
const searchInput = ref('')
const sortOrder = ref('asc')
const sortBy = ref('key')
const isDropdownOpen = ref(false)

const hasLoaded = computed(() => {
    return selectedProjectStore.projectLoaded
})

const keyEntries = computed(() => {
    return selectedProjectStore.keys.filter(entry =>
        entry.key.toLowerCase().includes(searchInput.value.toLowerCase()) ||
        entry.description.toLowerCase().includes(searchInput.value.toLowerCase())
    )
})

const sortedEntries = computed(() => {
    return keyEntries.value
    return keyEntries.value.slice().sort((a, b) => {
        if (sortBy.value === 'key') {
            if (sortOrder.value === 'asc') {
                return a.key.localeCompare(b.key)
            } else {
                return b.key.localeCompare(a.key)
            }
        } else if (sortBy.value === 'id') {
            if (sortOrder.value === 'asc') {
                return a.id - b.id
            } else {
                return b.id - a.id
            }
        }
    })
})

const hasEntries = computed(() => {
    return sortedEntries.value.length > 0
})

const selectVariable = function (variable) {
    selectedProjectStore.selectedVariable = variable
}

const setSortOrder = function (criteria, order) {
    sortBy.value = criteria
    sortOrder.value = order
    isDropdownOpen.value = false
}

const toggleDropdown = function () {
    isDropdownOpen.value = !isDropdownOpen.value
}
</script>
