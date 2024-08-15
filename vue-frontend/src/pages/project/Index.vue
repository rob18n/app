<template>
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <router-link :to="{ name: 'ProjectDashboardPage', params: { id: $route.params.id } }" class="nav-link"
                    :class="{ active: $route.name === 'ProjectDashboardPage' }">
                    Dashboard
                </router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{ name: 'ProjectVariableListPage', params: { id: $route.params.id } }"
                    class="nav-link" :class="{ active: $route.name === 'ProjectVariableListPage' }">
                    Variables
                </router-link>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <router-view></router-view>
        </div>
    </div>
</template>
