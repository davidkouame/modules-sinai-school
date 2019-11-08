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

import routerParent from '@/components/pages/parents/router'
import routerEleve from '@/components/pages/eleves/router'

const baseRoutes = [
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
]

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

//  export default routes

let routes = null
// const routes = baseRoutes;//.concat(messagesRoutes, peopleRoutes);
if (localStorage.getItem('userId')) {
  if (localStorage.getItem('userType') == "parent") {
    routes = routerParent;
  }else if(localStorage.getItem('userType') == "eleve"){
    routes = routerEleve;
  }else{
    routes = baseRoutes;
  }
}
// routes = baseRoutes;
/*export default new Router({
  routes,
});*/
export default routes

