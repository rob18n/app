<template>
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
                <a class="nav-link" :class="{ active: activeTab === tab.name }" href="#"
                    @click.prevent="activeTab = tab.name">
                    {{ tab.label }}
                </a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <component :is="getActiveTabComponent"></component>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ProjectDashboardPage from '@/pages/project-dashboard/Index.vue';
import ProjectVariableList from '@/pages/project-variable-list/Index.vue';

const activeTab = ref('home');

const tabs = [
    { name: 'dashboard', label: 'Dashboard', component: ProjectDashboardPage },
    { name: 'project', label: 'Variablen', component: ProjectVariableList },
];

const getActiveTabComponent = computed(() => {
    const tab = tabs.find((tab) => tab.name === activeTab.value);
    return tab ? tab.component : null;
});
</script>
