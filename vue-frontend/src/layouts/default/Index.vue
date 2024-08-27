<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <img class="" src="/public/rob18n.png" alt="Logo">
                    rob18n
                </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <ReleaseManager></ReleaseManager>
                        <li class="nav-item dropdown" :class="{ show: dropdownOpen }">
                            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                                aria-expanded="dropdownOpen" @click="toggleDropdown">
                                {{ currentLanguageLabel }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" :class="{ show: dropdownOpen }"
                                aria-labelledby="languageDropdown">
                                <li v-for="(label, key) in languages" :key="key">
                                    <a class="dropdown-item" href="#" @click.prevent="changeLanguage(key)">
                                        {{ label }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://rob18n.github.io/app/" target="_blank">
                                {{ t('navbar.documentation') }}
                                <BxLinkExternal />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/rob18n/app" target="_blank">
                                {{ t('navbar.github') }}
                                <BxLinkExternal />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content">
            <router-view />
        </main>
    </div>
</template>

<script setup>
import ReleaseManager from './components/ReleaseManager.vue'
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const { locale } = useI18n()
const dropdownOpen = ref(false)

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value
}

const languages = {
    en_US: t('language.english'),
    de_DE: t('language.german'),
}

const currentLanguageLabel = computed(() => languages[locale.value])

const changeLanguage = (lang) => {
    locale.value = lang
    dropdownOpen.value = false
}
</script>
