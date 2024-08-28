<template>
    <div id="project-variable-import">
        <h2>{{ t('page.import.title') }}</h2>
        <div class="row">
            <div class="col-12 mb-3">
                <p v-html="t('page.import.description')"></p>
            </div>
            <div class="col-12 col-md-8">
                <ImportUpload></ImportUpload>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        {{ t('page.import.supported.text') }}
                        <ul class="list-group mt-3">
                            <li class="list-group-item">
                                .json
                            </li>
                            <li class="list-group-item">
                                .php (Laravel)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ImportUpload from './components/ImportUpload.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>