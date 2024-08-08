<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <img class="" src="/public/rob18n.png">
                </router-link>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Projekte</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container">
            <router-view />
        </main>
    </div>
</template>
<script setup>
import { useProjectStore } from '@/stores/projectStore'
import { useLanguageStore } from '@/stores/languageStore'

const projectStore = useProjectStore()
const languageStore = useLanguageStore()

projectStore.get()
languageStore.get()
</script>