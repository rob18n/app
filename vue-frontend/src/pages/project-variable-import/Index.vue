<template>
    <div id="project-variable-import">
        <h2>Datei Import</h2>
        <div class="row">
            <div class="col-12 col-md-8">
                <ImportUpload></ImportUpload>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        robi8n unterstützt folgende Formate:
                        <ul class="list-group">
                            <li class="list-group-item">
                                .json
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
</script>