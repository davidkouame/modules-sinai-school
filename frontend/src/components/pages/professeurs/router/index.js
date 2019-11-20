import ListNote from '@/components/pages/professeurs/notes/List.vue'
import AddNote from '@/components/pages/professeurs/notes/Add.vue'
import PreviewNote from '@/components/pages/professeurs/notes/Preview.vue'
import UpdateNote from '@/components/pages/professeurs/notes/Update.vue'

// Absence élève
import ListAbsenceEleve from '@/components/pages/professeurs/absences/List.vue'
import PreviewAbsenceEleve from '@/components/pages/professeurs/absences/Preview.vue'
import AddAbsenceEleve from '@/components/pages/professeurs/absences/Add.vue'
import UpdateAbsenceEleve from '@/components/pages/professeurs/absences/Update.vue'

// Matière élève
import ListMatiere from '@/components/pages/parents/matieres/List.vue'
import PreviewMatiere from '@/components/pages/parents/matieres/Preview.vue'

// Paramétrage
import Parametre from '@/components/pages/professeurs/parametres/User.vue'

// Eleve
import ListEleve from '@/components/pages/professeurs/eleves/List.vue'
import PreviewEleve from '@/components/pages/professeurs/eleves/Preview.vue'

import DashboardProfesseur from '@/components/pages/professeurs/DashboardProfesseur.vue'


export default [
  {
    path: '/',
    name: 'DashboardProfesseur',
    component: DashboardProfesseur
  },
  {
    path: '/dashboard',
    name: 'DashboardProfesseur',
    component: DashboardProfesseur
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
      path: '/notes/add',
      name: 'AddNote',
      component: AddNote
    },
    {
      path: '/notes/update/:id(\\d+)',
      name: 'UpdateNote',
      component: UpdateNote
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
      path: '/absences/add',
      name: 'AddAbsenceEleve',
      component: AddAbsenceEleve
    },
    {
      path: '/absences/update/:id(\\d+)',
      name: 'UpdateAbsenceEleve',
      component: UpdateAbsenceEleve
    },


    {
      path: '/eleves',
      name: 'ListEleve',
      component: ListEleve
    },
    {
      path: '/eleves/preview/:id(\\d+)',
      name: 'PreviewEleve',
      component: PreviewEleve
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
      path: '/parametres',
      name: 'Parametre',
      component: Parametre
    },
    /*{
      path: '/parametres/eleve/:id(\\d+)',
      name: 'ParentParametre',
      component: ParentParametre
    },*/
    {
      path: '/parametres/eleves/preview/:id(\\d+)',
      name: 'PreviewEleve',
      component: PreviewEleve
    }
];
