<template>
    <div>
        <h2>{{ title }}</h2>
        <p>{{ description }}</p>

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <LanguageAddModal></LanguageAddModal>
            </div>
        </div>

        <div class="row mt-3" v-if="statistics">
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <span class="fs-5">{{ t('page.dashboard.stats.title') }}</span>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="fw-bold">{{ t('page.dashboard.stats.variables') }}:</div>
                            <p>{{ statistics.variables }}</p>
                        </li>
                        <li class="list-group-item">
                            <div class="fw-bold">{{ t('page.dashboard.stats.coverage') }}:</div>
                            <p>{{ statistics.coveragePercent }}%</p>
                        </li>
                        <li class="list-group-item">
                            <div class="fw-bold">{{ t('page.dashboard.stats.words') }}:</div>
                            <p>{{ statistics.wordCount }}</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3" v-for="entry in languageCoverage">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fs-5">{{ entry.name }}</span>
                                <LanguageDeleteModal :language="entry"></LanguageDeleteModal>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="fw-bold">{{ t('page.dashboard.stats.coverage') }}:</div>
                                    <p>{{ entry.filled }}/{{ statistics.variables }} </p>
                                </li>
                                <li class="list-group-item">
                                    <div class="fw-bold">{{ t('page.dashboard.stats.coverage.percent') }}:</div>
                                    <p>{{ entry.coveragePercent }}%</p>
                                </li>
                                <li class="list-group-item">
                                    <div class="fw-bold">{{ t('page.dashboard.stats.words') }}:</div>
                                    <p>{{ entry.wordCount }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { computed } from 'vue'
import LanguageAddModal from './components/LanguageAddModal.vue'
import LanguageDeleteModal from './components/LanguageDeleteModal.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const selectedProjectStore = useSelectedProjectStore()
const { project } = selectedProjectStore

const title = computed(() => {
    return selectedProjectStore.project.title ?? ''
})

const description = computed(() => {
    return selectedProjectStore.project.description ?? ''
})

const statistics = computed(() => {
    return selectedProjectStore.project.statistics
})

const languageCoverage = computed(() => {
    return selectedProjectStore.project.statistics.languageCoverage
})
</script>