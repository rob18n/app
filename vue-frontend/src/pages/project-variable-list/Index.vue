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
</script>
