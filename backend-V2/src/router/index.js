import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import VueRouteMiddleware from 'vue-route-middleware';
Vue.use(VueRouter);

// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkActiveClass: "active"
});

router.beforeEach(VueRouteMiddleware());

export default router;
