import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import DetailNote from '@/components/DetailNote'
import Note from '@/components/Note'
import Classe from '@/components/Classe'
import CreateCompteParent from '@/components/CreateCompteParent'
import AbsenceEleve from '@/components/AbsenceEleve'
import DetailAbsenceEleve from '@/components/DetailAbsenceEleve'
import ProfesseurAbsenceEleve from '@/components/professeurs/AbsenceEleve'
import ProfesseurDetailAbsenceEleve from '@/components/professeurs/DetailAbsenceEleve'
import ProfesseurAddAbsenceEleve from '@/components/professeurs/AddAbsenceEleve'

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
      name: 'Note',
      component: Note
    },
    {
      path: '/notes/:id',
      name: 'DetailNote',
      component: DetailNote
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
      path: '/absence-eleve/:id',
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
    }
  ]
})
