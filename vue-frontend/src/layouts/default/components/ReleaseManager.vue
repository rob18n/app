<template>
    <li class="nav-item dropdown">
        <a class="nav-link" :class="{ 'dropdown-toggle': !isUp2date }" href="#" id="languageDropdown" role="button">
            <span v-if="isLoading">{{ t('general.loading') }}</span>
            <span v-if="!isLoading && isUp2date" @click="toggleDropdown">
                <span>v.{{ version }}</span>
            </span>
            <span v-if="!isLoading && !isUp2date" @click="toggleDropdown">
                <span>{{ t('navbar.update.label') }}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end" :class="{ show: dropdownOpen }" v-if="!isUp2date">
            <div class="dropdown-item">
                <b>{{ t('navbar.update.info') }}</b>
                <ul class="mt-2">
                    <li>
                        <span>{{ t('navbar.update.current') }}: {{ version }}</span>
                    </li>
                    <li>
                        <span>{{ t('navbar.update.new') }}: {{ gitVersion }}</span>
                    </li>
                </ul>
            </div>
            <button class="btn btn-primary w-100 mt-3" @click="goToDocu">{{ t('button.openchangelog') }}</button>
        </div>
    </li>
</template>
<script setup>
import { ref, inject, onMounted } from 'vue'
import config from '@/config'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const axios = inject('axios')
const gitVersion = ref(null)
const version = ref(null)
const isUp2date = ref(true)
const isLoading = ref(true)
const dropdownOpen = ref(false)

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value
}

const getReleases = function () {
    isLoading.value = true
    return axios.get(`${config.apiUrl}/update/check`, {})
        .then((response) => {
            isUp2date.value = !response.data.update_required
            version.value = response.data.current_version
            gitVersion.value = response.data.git_version
        }).catch((e) => {
            console.log(e)
        }).finally(f => {
            isLoading.value = false
        })
}

const goToDocu = function () {
    window.open(`https://rob18n.github.io/app/docs/changelog/${gitVersion.value}`)
}

onMounted(() => {
    getReleases()
})
</script>