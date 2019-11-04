import ListNote from '@/components/pages/parents/notes/List.vue'
import PreviewNote from '@/components/pages/parents/notes/Preview.vue'

// Absence élève
import ListAbsenceEleve from '@/components/pages/parents/absences/List.vue'
import PreviewAbsenceEleve from '@/components/pages/parents/absences/Preview.vue'

// Matière élève
import ListMatiere from '@/components/pages/parents/matieres/List.vue'
import PreviewMatiere from '@/components/pages/parents/matieres/Preview.vue'


export default [
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
    }
];
