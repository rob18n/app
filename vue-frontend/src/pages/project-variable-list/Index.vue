<template>
    <div id="project-variable-list">
        <h2>{{ t('page.variables.title') }}</h2>

        <div class="row mt-3">
            <Sidebar></Sidebar>

            <Content></Content>
        </div>
    </div>
</template>

<script setup>
import Sidebar from './components/Sidebar.vue'
import Content from './components/Content.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>
