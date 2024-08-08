<template>
    <div class="container">
        <!-- Infotext -->

        <!-- Projekte Auflistung -->
        <div class="row">
            <div class="col-12">
                <Jumbotron />
            </div>
            <div class="col-12">
                <ProjectList />
            </div>
        </div>
    </div>
</template>

<script setup>
import Jumbotron from './components/Jumbotron.vue'
import ProjectList from './components/ProjectList.vue'
</script>
<style>
.custom-jumbotron {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://via.placeholder.com/1200x400') center/cover no-repeat;
    color: #fff;
    padding: 5rem 2rem;
    border-radius: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>