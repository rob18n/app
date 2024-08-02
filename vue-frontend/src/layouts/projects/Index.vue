<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <router-link class="navbar-brand" to="/">rob18n</router-link>
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