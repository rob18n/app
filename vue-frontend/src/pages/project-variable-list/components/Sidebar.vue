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
                    <button class="btn btn-secondary" @click="toggleFilterDropdown">
                        {{ t('button.filter') }}
                    </button>
                    <ul v-show="isFilterDropdownOpen" class="dropdown-menu show dropdown-menu-start"
                        style="left: auto; right: 0px; top: 40px">
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="setFilter('all')">
                                {{ t('filter.all') }}
                                <span v-if="filterType === 'all'">
                                    <AkCheck />
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="setFilter('non-empty')">
                                {{ t('filter.non_empty') }}
                                <span v-if="filterType === 'non-empty'">
                                    <AkCheck />
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="setFilter('empty')">
                                {{ t('filter.empty') }}
                                <span v-if="filterType === 'empty'">
                                    <AkCheck />
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button class="btn btn-secondary" @click="toggleDropdown">
                        {{ t('button.sort') }}
                    </button>
                    <ul v-show="isDropdownOpen" class="dropdown-menu show dropdown-menu-start"
                        style="left: auto; right: 0px; top: 40px">
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

            <div class="counter">
                <p class="fs-5" v-html="t('page.variable.counter', { counter: sortedEntries.length })"> </p>
            </div>

            <div id="entry-list" class="entries flex-grow-1 w-100">
                <ul class="list-group">
                    <li class="list-group-item" v-if="!hasLoaded">
                        {{ t('general.loading') }}
                    </li>
                    <li class="list-group-item list-group-item-info" v-if="hasLoaded && !hasEntries">
                        {{ t('general.no-entries') }}
                    </li>
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start"
                        v-for="(entry, index) in sortedEntries" :key="entry.key" @click="selectVariable(entry)">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">
                                <p class="text-truncate" style="max-width: 150px;">{{ entry.key }}</p>
                            </div>
                            <div class="description text-truncate" style="max-width: 300px;">
                                <small class="text-muted" style="height: 50px;">{{ entry.description }}</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill"
                            :class="{ 'bg-warning': entry.empty_value_counter, 'bg-secondary': !entry.empty_value_counter }">
                            {{ entry.filled_values_counter }}
                        </span>
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
import { onMounted, onBeforeUnmount, ref, computed } from "vue"
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
const isFilterDropdownOpen = ref(false)
const filterType = ref('all')

const hasLoaded = computed(() => selectedProjectStore.projectLoaded)

const keyEntries = computed(() => {
    return selectedProjectStore.keys.filter(entry =>
        entry.key.toLowerCase().includes(searchInput.value.toLowerCase()) ||
        entry.description.toLowerCase().includes(searchInput.value.toLowerCase())
    )
})

const sortedEntries = computed(() => {
    let entries = keyEntries.value.slice()

    if (filterType.value === 'filled') {
        entries = entries.filter(entry => {
            return entry.empty_value_counter == 0
        })
    } else if (filterType.value === 'empty') {
        entries = entries.filter(entry => {
            return entry.empty_value_counter > 0
        })
    }

    entries.sort((a, b) => {
        if (sortBy.value === 'key') {
            return sortOrder.value === 'asc' ? a.key.localeCompare(b.key) : b.key.localeCompare(a.key)
        } else if (sortBy.value === 'id') {
            return sortOrder.value === 'asc' ? a.id - b.id : b.id - a.id
        }
    })

    return entries
})

const hasEntries = computed(() => sortedEntries.value.length > 0)

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
    isFilterDropdownOpen.value = false
}

const toggleFilterDropdown = function () {
    isFilterDropdownOpen.value = !isFilterDropdownOpen.value
    isDropdownOpen.value = false
}

const setFilter = function (type) {
    filterType.value = type
    isFilterDropdownOpen.value = false
}

const handleClickOutside = (event) => {
    if (!event.target.closest('.btn-group')) {
        isDropdownOpen.value = false
        isFilterDropdownOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>
