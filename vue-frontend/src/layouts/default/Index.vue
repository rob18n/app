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

                        <LanguageToggle></LanguageToggle>
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
import LanguageToggle from './components/LanguageToggle.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>
