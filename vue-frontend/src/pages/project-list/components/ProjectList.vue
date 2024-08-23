<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ t('page.landing.list.title') }}</h5>
            <p class="card-text">{{ t('page.landing.list.info') }}</p>
        </div>
        <div class="list-group">
            <div class="list-group-item" v-if="!hasLoaded">
                {{ t('general.loading') }}
            </div>
            <div class="list-group-item list-group-item-info" v-if="hasLoaded && !hasEntries">
                {{ t('general.no-entries') }}
            </div>
            <div class="list-group-item d-flex justify-content-between align-items-top"
                v-for="project in projectEntries" :key="project.id" @click.stop="goToDashboard($event, project)">
                <div>
                    <h3 class="display-7">{{ project.title }}</h3>
                    <p class="text-muted" v-html="project.description"></p>
                </div>
                <div class="btn-group" role="group" aria-label="List">
                    <ProjectEditModal :project="project"></ProjectEditModal>
                    <ProjectDestroyModal :project="project"></ProjectDestroyModal>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <ProjectAddModal></ProjectAddModal>
        </div>
    </div>
</template>

<script setup>
import { useProjectStore } from '@/stores/projectStore'
import { useLanguageStore } from '@/stores/languageStore'
import { computed, onMounted, ref } from 'vue'
import ProjectAddModal from './ProjectAddModal.vue'
import ProjectEditModal from './ProjectEditModal.vue'
import ProjectDestroyModal from './ProjectDestroyModal.vue'
import { useI18n } from 'vue-i18n'
import { useRouter } from 'vue-router'

const router = useRouter()
const { t } = useI18n()
const projectStore = useProjectStore()
const { projectsLoaded, projects } = projectStore
const languageStore = useLanguageStore()

const goToDashboard = function (ev, project) {
    const classList = Array.from(ev.target.classList)

    if (!classList.includes('modal-footer') && !classList.includes('modal') && !classList.includes('btn')) {
        router.push({ name: 'ProjectDashboardPage', params: { id: project.id } })
    }
}

const hasLoaded = computed(() => {
    return projectStore.projectsLoaded
})

const projectEntries = computed(() => {
    return projectStore.projects
})

const hasEntries = computed(() => {
    return projectStore.projects.length
})

onMounted(() => {
    languageStore.get()
    projectStore.get()
})
</script>