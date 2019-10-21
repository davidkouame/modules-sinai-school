import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'


import Classe from '@/components/Classe'
import CreateCompteParent from '@/components/CreateCompteParent'
import AbsenceEleve from '@/components/AbsenceEleve'
import DetailAbsenceEleve from '@/components/DetailAbsenceEleve'
import ProfesseurAbsenceEleve from '@/components/professeurs/AbsenceEleve'
import ProfesseurDetailAbsenceEleve from '@/components/professeurs/DetailAbsenceEleve'
import ProfesseurAddAbsenceEleve from '@/components/professeurs/AddAbsenceEleve'
import ProfesseurEditAbsenceEleve from '@/components/professeurs/EditAbsenceEleve'

// Note
import AddNote from '@/components/notes/Add.vue'
import UpdateNote from '@/components/notes/Update.vue'
import PreviewNote from '@/components/notes/Preview.vue'
import ListNote from '@/components/notes/List.vue'

// Absence élève
import ListAbsenceEleve from '@/components/absences/List.vue'
import AddAbsenceEleve from '@/components/absences/Add.vue'
import UpdateAbsenceEleve from '@/components/absences/Update.vue'
import PreviewAbsenceEleve from '@/components/absences/Preview.vue'

// Absence élève
import ListEleve from '@/components/eleves/List.vue'
// import AddAbsenceEleve from '@/components/absences/Add.vue'
// import UpdateAbsenceEleve from '@/components/absences/Update.vue'
import PreviewEleve from '@/components/eleves/Preview.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HelloWorld
    },
    /* ============== Note ============== */
    {
      path: '/notes',
      name: 'ListNote',
      component: ListNote
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
      path: '/notes/preview/:id(\\d+)',
      name: 'PreviewNote',
      component: PreviewNote
    },
    /* ============== \.Note ============== */
    {
      path: '/classe',
      name: 'Classe',
      component: Classe
    },
    {
      path: '/create-parent',
      name: 'Create compte parent',
      component: CreateCompteParent
    }/*,
    {
      path: '/professeur/absences-eleves',
      name: 'Absence eleve',
      component: ProfesseurAbsenceEleve
    }*/,
    {
      path: '/absence-eleve',
      name: 'Absence eleve',
      component: AbsenceEleve
    },
    /* ============== Absence élève ============== */
    {
      path: '/absences-eleves',
      name: 'ListAbsenceEleve',
      component: ListAbsenceEleve
    },
    {
      path: '/absences-eleves/add',
      name: 'AddAbsenceEleve',
      component: AddAbsenceEleve
    },
    {
      path: '/absences-eleves/update/:id(\\d+)',
      name: 'UpdateAbsenceEleve',
      component: UpdateAbsenceEleve
    },
    {
      path: '/absences-eleves/preview/:id(\\d+)',
      name: 'PreviewAbsenceEleve',
      component: PreviewAbsenceEleve
    }
    /* ============== \.Absence élève ============== */
    ,
    /* ============== Elèves ============== */
    {
      path: '/eleves',
      name: 'ListEleve',
      component: ListEleve
    },
    {
      path: '/eleves/preview/:id(\\d+)',
      name: 'PreviewEleve',
      component: PreviewEleve
    }
    /* ============== \.Elèves ============== */
    ,
    {
      path: '/absence-eleve/:id(\\d+)',
      name: 'Detail Absence élève',
      component: DetailAbsenceEleve
    },
    {
      path: '/professeur/absences-eleves/:id',
      name: 'Detail Absence élève',
      component: ProfesseurDetailAbsenceEleve
    },
    {
      path: '/professeur/absenceseleves/add',
      name: 'Add Absence élève',
      component: ProfesseurAddAbsenceEleve
    },
    {
      path: '/professeur/absences-eleves/edit/:id',
      name: 'ProfesseurEditAbsenceEleve',
      component: ProfesseurEditAbsenceEleve
    }
  ]
})
