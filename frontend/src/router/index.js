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

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HelloWorld
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
      path: '/classe',
      name: 'Classe',
      component: Classe
    },
    {
      path: '/create-parent',
      name: 'Create compte parent',
      component: CreateCompteParent
    },
    {
      path: '/professeur/absences-eleves',
      name: 'Absence eleve',
      component: ProfesseurAbsenceEleve
    },
    {
      path: '/absence-eleve',
      name: 'Absence eleve',
      component: AbsenceEleve
    },
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
