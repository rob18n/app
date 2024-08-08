import { createRouter, createWebHistory } from 'vue-router';
import ProjectsLayout from '@/layouts/default/Index.vue'
import ProjectsPage from '@/pages/project-list/Index.vue'

const routes = [
    {
        path: '/',
        component: ProjectsLayout, // Verwende das Standard-Layout
        children: [
            {
                path: '',
                name: 'Projects',
                component: ProjectsPage,
            },
        ],
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
