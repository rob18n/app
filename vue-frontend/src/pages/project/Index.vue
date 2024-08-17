<template>
    <div>
        <ul class="nav nav-tabs">
            <li v-for="tab in tabs" :key="tab.name" class="nav-item">
                <router-link :to="{ name: tab.name, params: { id: $route.params.id } }" class="nav-link"
                    :class="{ active: $route.name === tab.name }">
                    {{ tab.label }}
                </router-link>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const tabs = computed(() => [
    { name: "ProjectDashboardPage", label: "Dashboard" },
    { name: "ProjectVariableListPage", label: "Variables" },
    { name: "ProjectVariableImportPage", label: "Import" },
])
</script>
