import ListNote from '@/components/pages/eleves/notes/List.vue'
import PreviewNote from '@/components/pages/eleves/notes/Preview.vue'

// Absence élève
import ListAbsenceEleve from '@/components/pages/eleves/absences/List.vue'
import PreviewAbsenceEleve from '@/components/pages/eleves/absences/Preview.vue'

// Matière élève
import ListMatiere from '@/components/pages/eleves/matieres/List.vue'
import PreviewMatiere from '@/components/pages/eleves/matieres/Preview.vue'

// moyenne
import ListMoyenne from '@/components/pages/eleves/moyennes/List.vue'
import PreviewMoyenne from '@/components/pages/eleves/moyennes/Preview.vue'

// Paramétrage
import EleveParametre from '@/components/pages/eleves/parametres/User.vue'

// Eleve
// import PreviewEleve from '@/components/pages/eleves/eleves/Preview.vue'


import DashboardEleve from '@/components/pages/eleves/DashboardEleve.vue'

export default [
  {
    path: '/',
    name: 'DashboardEleve',
    component: DashboardEleve
  },
  {
    path: '/dashboard',
    name: 'DashboardEleve',
    component: DashboardEleve
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
      path: '/matieres/notes/:matiere_id(\\d+)/preview/:id(\\d+)',
      name: 'PreviewNote',
      component: PreviewNote
    },
    {
      path: '/parametres',
      name: 'EleveParametre',
      component: EleveParametre
    },
    {
      path: '/parametres/eleve/:id(\\d+)',
      name: 'EleveParametre',
      component: EleveParametre
    }
];
