
import {createRouter, createWebHistory}  from 'vue-router'
import Main from "../pages/Main";
import SecondPage from "../pages/SecondPage";
import ThirdPage from "../pages/ThirdPage";
import CardToDo from "../pages/CardToDo/CardToDo";


const routes =[
    {
        path:'/',
        name:'Main',
        component:Main,
    },
    {
        path: '/:slug',
        name:'Card',
        component: CardToDo,
    },
    {
        path:'/second',
        name:'SecondPage',
        component:SecondPage,
    },
    {
        path:'/third',
        name:'ThirdPage',
        component:ThirdPage,
    },
]

const router = new createRouter({
    history: createWebHistory(),
    routes
})

export default router

// const app = new Vue({
//     router
// }).$mount('#app')



