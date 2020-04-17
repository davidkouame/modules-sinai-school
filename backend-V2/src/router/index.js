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

/* router.beforeResolve((to, from, next) => {
  // If this isn't an initial page load.
  if (to.name) {
      // Start the route progress bar.
      NProgress.start()
  }
  next()
})

router.afterEach((to, from) => {
  // Complete the animation of the route progress bar.
  NProgress.done()
}) */

export default router;
