
import DashboardLayout from '../layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../pages/NotFoundPage.vue'

// Admin pages
// import Overview from 'src/pages/Overview.vue'
// import UserProfile from 'src/pages/UserProfile.vue'
// import TableList from 'src/pages/TableList.vue'
// import Typography from 'src/pages/Typography.vue'
// import Icons from 'src/pages/Icons.vue'
// import Maps from 'src/pages/Maps.vue'
// import Notifications from 'src/pages/Notifications.vue'
// import Upgrade from 'src/pages/Upgrade.vue'

import UserProfile from '@/components/UserProfile.vue'
import TableList from '@/components/TableList.vue'
import Typography from '@/components/Typography.vue'
import Icons from '@/components/Icons.vue'
import Maps from '@/components/Maps.vue'
import Notifications from '@/components/Notifications.vue'
import Upgrade from '@/components/Upgrade.vue'
import Overview from '@/components/Overview.vue'
import VueRouteMiddleware from 'vue-route-middleware';
import VueRouter from "vue-router";

import routerParent from '@/components/pages/parents/router'
import routerEleve from '@/components/pages/eleves/router'
import routerProfesseur from '@/components/pages/professeurs/router'


import ListNote from '@/components/pages/parents/notes/List.vue'
import PreviewNote from '@/components/pages/parents/notes/Preview.vue'

// Absence élève
import ListAbsenceEleve from '@/components/pages/parents/absences/List.vue'
import PreviewAbsenceEleve from '@/components/pages/parents/absences/Preview.vue'

// Matière élève
import ListMatiere from '@/components/pages/parents/matieres/List.vue'
import PreviewMatiere from '@/components/pages/parents/matieres/Preview.vue'

// Moyenne
import ListMoyenne from '@/components/pages/parents/moyennes/List.vue'
import PreviewMoyenne from '@/components/pages/parents/moyennes/Preview.vue'

// Paramétrage
import ParentParametre from '@/components/pages/parents/parametres/User.vue'

// Eleve
import PreviewEleve from '@/components/pages/parents/eleves/Preview.vue'

import DashboardParent from '@/components/pages/parents/DashboardParent.vue'
import ParentLayout from '@/layout/ParentLayout.vue'
import HomeLayout from '@/layout/HomeLayout.vue'

// Login
// import Login from '@/components/Login.vue'

// Login
import Login from '@/components/Login.vue'

// Forgot password
import ForgotPassword from '@/components/ForgotPassword.vue'
import CheckResetPassword from '@/components/CheckResetPassword.vue'
import ResetPassword from '@/components/ResetPassword.vue'
import SucessResetPassword from '@/components/SucessResetPassword.vue'
import FirstConnexion from '@/components/FirstConnexion.vue'

import Vue from 'vue'

import VueCookies from 'vue-cookies'
Vue.use(VueCookies);
// Vue.use(VueRouter);

/*const baseRoutes = [
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/admin/overview'
  },
  {
    path: '/admin',
    component: DashboardLayout,
    redirect: '/admin/overview',
    children: [
      {
        path: 'overview',
        name: 'Overview',
        component: Overview
      },
      {
        path: 'user',
        name: 'User',
        component: UserProfile
      },
      {
        path: 'table-list',
        name: 'Table List',
        component: TableList
      },
      {
        path: 'typography',
        name: 'Typography',
        component: Typography
      },
      {
        path: 'icons',
        name: 'Icons',
        component: Icons
      },
      {
        path: 'maps',
        name: 'Maps',
        component: Maps
      },
      {
        path: 'notifications',
        name: 'Notifications',
        component: Notifications
      },
      {
        path: 'upgrade',
        name: 'Upgrade to PRO',
        component: Upgrade
      }
    ]
  },
  { path: '*', component: NotFound }
]*/

/*const baseRoutes = [
  {
    path: "/login",
    name: "Login",
    component: Login
  },
  { path: '*', component: NotFound }
]*/

const baseRoutes = [
  /*{
    path: "/",
    component: HomeLayout,
    redirect: "dashboard",
    meta: {
      middleware: (to, from, next) => {
        const cookies = Vue.prototype.$cookies;
        if (!cookies.get("userId")) {
          next({ name: 'Login' });
        }

        if (cookies.get('firstLogin') == 0) {
          next({ name: 'FirstConnexion' });
        }
      }
    }
  },*/
  {
    path: "/login",
    name: "Login",
    component: Login
  },
  {
    path: "/first-connexion",
    name: "FirstConnexion",
    component: FirstConnexion
  },
  {
    path: "/forgot-password",
    name: "ForgotPassword",
    component: ForgotPassword
  },
  {
    path: "/check-reset-password/:code",
    name: "CheckResetPassword",
    component: CheckResetPassword
  },
  {
    path: "/reset-password/:userId/:code",
    name: "ResetPassword",
    component: ResetPassword
  },
  {
    path: "/success-reset-password",
    name: "SucessResetPassword",
    component: SucessResetPassword
  }
];

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

//  export default routes


let routes = null;
const cookies = Vue.prototype.$cookies;
// const routes = baseRoutes;//.concat(messagesRoutes, peopleRoutes);

if (cookies.get('userId') && cookies.get('firstLogin') != 0) {
  if (cookies.get('userType') == "parent") {
    routes = baseRoutes.concat(routerParent);
    console.log("je suis dans la route du parent");
  } else if (cookies.get('userType') == "professeur") {
    console.log("je suis dans la route du professeur");
    routes = baseRoutes.concat(routerProfesseur);
  }
  console.log("je suis ni chez le professeur ni chez le parent !");
} else {
  console.log("je suis dans la base ");
  baseRoutes.push({
    path: "/",
    component: HomeLayout,
    redirect: "dashboard",
    meta: {
      middleware: (to, from, next) => {
        const cookies = Vue.prototype.$cookies;
        if (!cookies.get("userId")) {
          next({ name: 'Login' });
        }

        if (cookies.get('firstLogin') == 0) {
          next({ name: 'FirstConnexion' });
        }
      }
    },
    children: routerParent[0]['children']
  });
  routes = baseRoutes;
  // console.log("routes "+JSON.stringify(routes))
}

// console.log("routes "+JSON.stringify(routerParent[0]['children']));

// routes = baseRoutes.concat(routerParent);

// console.log('je suis dans la route');
// routes = baseRoutes;
// routes = baseRoutes;
/*export default new Router({
  routes,
});*/

/*const router = new VueRouter({
  routes, // short for routes: routes
  linkActiveClass: "active"
});

router.beforeEach(VueRouteMiddleware());*/

// routes.beforeEach(VueRouteMiddleware());

export default routes
// export default router

