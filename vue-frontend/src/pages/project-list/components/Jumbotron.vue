<template>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8 col-12">
                <h1 class="display-4">{{ t('page.landing.title') }}</h1>
                <h2 class="display-6">{{ t('page.landing.subtitle') }}</h2>
                <p class="lead">{{ t('page.landing.herotext') }}</p>
            </div>
            <div class="col-md-4 col-12">
                <img :src="img" class="img-fluid rounded">
            </div>
        </div>
    </div>
</template>

<script setup>
import img from '../img/welcome.webp'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>