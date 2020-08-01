import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import TareaComponent from "./components/TareasComponent.vue";
import ComentariosComponent from "./components/ComentariosComponent.vue";
import PageComponent from "./components/page_components/Page.vue";


const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: PageComponent
        },
        {
            path: "/comments",
            name: "comentarios",
            component: ComentariosComponent
        }
        
    ]
});

export default router;
