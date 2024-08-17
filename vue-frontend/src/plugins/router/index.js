import { createRouter, createWebHistory } from 'vue-router';
import ProjectsLayout from '@/layouts/default/Index.vue'
import ProjectListPage from '@/pages/project-list/Index.vue'
import ProjectPage from '@/pages/project/Index.vue'
import ProjectDashboardPage from '@/pages/project-dashboard/Index.vue'
import ProjectVariableListPage from '@/pages/project-variable-list/Index.vue'
import ProjectVariableImportPage from '@/pages/project-variable-import/Index.vue'

const routes = [
    {
        path: '/',
        component: ProjectsLayout, // Verwende das Standard-Layout
        children: [
            {
                path: '',
                name: 'ProjectListPage',
                component: ProjectListPage,
            },
            {
                path: '/project/:id',
                name: 'ProjectPage',
                component: ProjectPage,
                children: [
                    {
                        path: '/project/:id/dashboard',
                        name: 'ProjectDashboardPage',
                        component: ProjectDashboardPage,
                    },
                    {
                        path: '/project/:id/variables',
                        name: 'ProjectVariableListPage',
                        component: ProjectVariableListPage,
                    },
                    {
                        path: '/project/:id/import',
                        name: 'ProjectVariableImportPage',
                        component: ProjectVariableImportPage,
                    },
                ]
            }
        ],
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
