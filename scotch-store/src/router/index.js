import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Test1 from '@/components/Test1'
import Test2 from '@/components/Test2'
import Test3 from '@/components/Test3'
import Page from '@/pages/admin/Page'
import Page1 from '@/pages/admin/Page1'
// import Page2 from '@/pages/admin/Page2'
import Page3 from '@/pages/admin/Page3'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/test1',
      name: 'Test1',
      component: Test1
    },
    {
      path: '/test2',
      name: 'Test2',
      component: Test2
    },
    {
      path: '/test3',
      name: 'Test3',
      component: Test3
    },
    {
      path: '/page',
      // name: 'Page',

      component: Page,

      children: [
        {
          path: 'ch',
          // name: 'Page1',
          component: Page1
        },
        {
          path: 'edit/:id',
          name: 'Page3',
          component: Page3
        }
      ]
    }
  ]
})
