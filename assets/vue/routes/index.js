
import {createRouter, createWebHistory}  from 'vue-router'
import Main from "@/pages/Main";
import SecondPage from "@/pages/SecondPage";
import ThirdPage from "@/pages/ThirdPage";


const routes =[
    {
        path:'/',
        name:'Main',
        component:Main,
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



