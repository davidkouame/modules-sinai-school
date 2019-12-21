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


export default [
  {
    path: '/',
    name: 'DashboardParent',
    component: DashboardParent
  },
  {
    path: '/dashboard',
    name: 'DashboardParent',
    component: DashboardParent
  },
  {
    path: '/notes',
    name: 'ListNote',
    component: ListNote
  },
  {
  	path: '/notes/preview/:id(\\d+)',
  	name: 'PreviewNote',
  	component: PreviewNote
  },
  {
      path: '/absences',
      name: 'ListAbsenceEleve',
      component: ListAbsenceEleve
    },
    {
      path: '/absences/preview/:id(\\d+)',
      name: 'PreviewAbsenceEleve',
      component: PreviewAbsenceEleve
    },
    {
      path: '/matieres',
      name: 'ListMatiere',
      component: ListMatiere
    },
    {
      path: '/matieres/preview/:id(\\d+)',
      name: 'PreviewMatiere',
      component: PreviewMatiere
    },
    {
      path: '/moyennes',
      name: 'ListMoyenne',
      component: ListMoyenne
    },
    {
      path: '/moyennes/preview/:id(\\d+)',
      name: 'PreviewMoyenne',
      component: PreviewMoyenne
    },
    {
      path: '/parametres',
      name: 'ParentParametre',
      component: ParentParametre
    },
    {
      path: '/parametres/eleve/:id(\\d+)',
      name: 'ParentParametre',
      component: ParentParametre
    },
    {
      path: '/parametres/eleves/preview/:id(\\d+)',
      name: 'PreviewEleve',
      component: PreviewEleve
    }
];
