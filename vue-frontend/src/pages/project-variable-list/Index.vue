<template>
    <div id="project-variable-list">
        <h2>Sprachvariablen</h2>

        <div class="row mt-3">
            <Sidebar></Sidebar>

            <Content></Content>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import Sidebar from './components/Sidebar.vue';
import Content from './components/Content.vue';
import { useSelectedProjectStore } from '@/stores/selectedProjectStore'
import { useRoute } from 'vue-router'

const route = useRoute()
const selectedProjectStore = useSelectedProjectStore()

onMounted(() => {
    selectedProjectStore.get(route.params.id)
})
</script>
