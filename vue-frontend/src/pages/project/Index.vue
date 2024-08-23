<template>
    <div id="project-page">
        <div class="tab-header">
            <ul class="container nav nav-tabs">
                <li v-for="tab in tabs" :key="tab.name" class="nav-item">
                    <router-link :to="{ name: tab.name, params: { id: $route.params.id } }" class="nav-link"
                        :class="{ active: $route.name === tab.name }">
                        {{ tab.label }}
                    </router-link>
                </li>
            </ul>
        </div>

        <div class="container tab-content mt-3">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const selectedProjectStore = useSelectedProjectStore()
const { project } = selectedProjectStore
const route = useRoute()

const tabs = computed(() => [
    { name: "ProjectDashboardPage", label: t('tab.dashboard') },
    { name: "ProjectVariableListPage", label: t('tab.variables') },
    { name: "ProjectVariableImportPage", label: t('tab.import') },
    { name: "ProjectVariableExportPage", label: t('tab.export') },
])

onMounted(() => {
    selectedProjectStore.get(route.params.id)
})
</script>
