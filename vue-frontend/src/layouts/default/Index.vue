<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <img class="" src="/public/rob18n.png" alt="Logo">
                </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Projekte</router-link>
                        </li>
                    </ul>
                    <!-- Language Toggle Dropdown -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown" :class="{ show: dropdownOpen }">
                            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                                aria-expanded="dropdownOpen" @click="toggleDropdown">
                                {{ currentLanguageLabel }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" :class="{ show: dropdownOpen }"
                                aria-labelledby="languageDropdown">
                                <li v-for="(label, key) in languages" :key="key">
                                    <a class="dropdown-item" href="#" @click.prevent="changeLanguage(key)">{{ label
                                        }}</a>
                                </li>
                            </ul>
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
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();

// Dropdown-Zustand verwalten
const dropdownOpen = ref(false);

// Funktion zum Öffnen/Schließen des Dropdowns
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

// Sprachen verwalten
const languages = {
    de_DE: 'Deutsch',
    en_US: 'English'
};

// Aktuelles Sprachlabel anzeigen
const currentLanguageLabel = computed(() => languages[locale.value]);

// Funktion zum Wechseln der Sprache
const changeLanguage = (lang) => {
    locale.value = lang;
    dropdownOpen.value = false; // Schließe Dropdown nach Auswahl
};
</script>
