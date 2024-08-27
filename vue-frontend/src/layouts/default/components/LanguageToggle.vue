<template>
    <li class="nav-item dropdown" :class="{ show: dropdownOpen }">
        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" aria-expanded="dropdownOpen"
            @click="toggleDropdown">
            {{ currentLanguageLabel }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end" :class="{ show: dropdownOpen }" aria-labelledby="languageDropdown">
            <li v-for="(label, key) in languages" :key="key">
                <a class="dropdown-item" href="#" @click.prevent="changeLanguage(key)">
                    {{ label }}
                </a>
            </li>
        </ul>
    </li>
</template>

<script setup>
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
    localStorage.setItem('selectedLanguage', lang)
}

const savedLanguage = localStorage.getItem('selectedLanguage')
if (savedLanguage) {
    locale.value = savedLanguage
}
</script>