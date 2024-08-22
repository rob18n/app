<template>
    <router-view></router-view>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const route = useRoute();
const title = ref('')

watch(route, (to) => {
    title.value = `meta.title.${to.name}`
    document.title = `${t(title.value)} | rob18n`
}, { immediate: true });
</script>