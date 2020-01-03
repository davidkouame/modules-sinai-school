import DashboardLayout from "@/layout/dashboard/DashboardLayout.vue";
// GeneralViews
import NotFound from "@/pages/NotFoundPage.vue";

// Admin pages
import Dashboard from "@/pages/Dashboard.vue";
import UserProfile from "@/pages/UserProfile.vue";
import Notifications from "@/pages/Notifications.vue";
import Icons from "@/pages/Icons.vue";
import Maps from "@/pages/Maps.vue";
import Typography from "@/pages/Typography.vue";
import TableList from "@/pages/TableList.vue";

import AnneesScolaires from "@/components/Anneesscolaires/List.vue";
import PreviewAnneesScolaires from "@/components/Anneesscolaires/Preview.vue";
import AddAnneesScolaires from "@/components/Anneesscolaires/Add.vue";
import EditAnneesScolaires from "@/components/Anneesscolaires/Edit.vue";

import SectionsAnneeScolaire from "@/components/SectionsAnneeScolaire/List.vue";
import PreviewSectionsAnneeScolaire from "@/components/SectionsAnneeScolaire/Preview.vue";
import AddSectionsAnneeScolaire from "@/components/SectionsAnneeScolaire/Add.vue";
import EditSectionsAnneeScolaire from "@/components/SectionsAnneeScolaire/Edit.vue";

// Matières
import ListMatiere from "@/components/Matieres/List.vue";
import PreviewMatiere from "@/components/Matieres/Preview.vue";
import AddMatiere from "@/components/Matieres/Add.vue";
import EditMatiere from "@/components/Matieres/Edit.vue";

// Series
import ListSerie from "@/components/Series/List.vue";
import PreviewSerie from "@/components/Series/Preview.vue";
import AddSerie from "@/components/Series/Add.vue";
import EditSerie from "@/components/Series/Edit.vue";

// Niveaux
import ListNiveau from "@/components/Niveaux/List.vue";
import PreviewNiveau from "@/components/Niveaux/Preview.vue";
import AddNiveau from "@/components/Niveaux/Add.vue";
import EditNiveau from "@/components/Niveaux/Edit.vue";

// Notes
import ListNote from "@/components/Notes/List.vue";
import PreviewNote from "@/components/Notes/Preview.vue";
import AddNote from "@/components/Notes/Add.vue";
import EditNote from "@/components/Notes/Edit.vue";

// Professeurs
import ListProfesseur from "@/components/Professeurs/List.vue";
import PreviewProfesseur from "@/components/Professeurs/Preview.vue";
import AddProfesseur from "@/components/Professeurs/Add.vue";
import EditProfesseur from "@/components/Professeurs/Edit.vue";

// Classes
import ListClasse from "@/components/Classes/List.vue";
import PreviewClasse from "@/components/Classes/Preview.vue";
import AddClasse from "@/components/Classes/Add.vue";
import EditClasse from "@/components/Classes/Edit.vue";

// Classes Professeurs Matieres
import ListClasseProfesseurMatiere from "@/components/ClassesMatieresProfesseurs/List.vue";
import PreviewClasseProfesseurMatiere from "@/components/ClassesMatieresProfesseurs/Preview.vue";
import AddClasseProfesseurMatiere from "@/components/ClassesMatieresProfesseurs/Add.vue";
import EditClasseProfesseurMatiere from "@/components/ClassesMatieresProfesseurs/Edit.vue";

// Eleves Classes
import ListEleveClasse from "@/components/ElevesClasses/List.vue";
import PreviewEleveClasse from "@/components/ElevesClasses/Preview.vue";
import AddEleveClasse from "@/components/ElevesClasses/Add.vue";
import EditEleveClasse from "@/components/ElevesClasses/Edit.vue";

// Eleves 
import ListEleve from "@/components/Eleves/List.vue";
import PreviewEleve from "@/components/Eleves/Preview.vue";
import AddEleve from "@/components/Eleves/Add.vue";
import EditEleve from "@/components/Eleves/Edit.vue";

// Parents 
import ListParent from "@/components/Parents/List.vue";
import PreviewParent from "@/components/Parents/Preview.vue";
import AddParent from "@/components/Parents/Add.vue";
import EditParent from "@/components/Parents/Edit.vue";

const routes = [
  {
    path: "/",
    component: DashboardLayout,
    redirect: "/dashboard",
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard
      },
      {
        path: "stats",
        name: "stats",
        component: UserProfile
      },
      {
        path: "notifications",
        name: "notifications",
        component: Notifications
      },
      {
        path: "icons",
        name: "icons",
        component: Icons
      },
      {
        path: "maps",
        name: "maps",
        component: Maps
      },
      {
        path: "typography",
        name: "typography",
        component: Typography
      },
      {
        path: "table-list",
        name: "table-list",
        component: TableList
      },

      {
        path: "annees-scolaires",
        name: "Annees scolaires",
        component: AnneesScolaires
      },
      {
        path: '/annees-scolaires/preview/:id(\\d+)',
        name: 'Annees scolairese',
        component: PreviewAnneesScolaires
      },
      {
        path: '/annees-scolaires/edit/:id(\\d+)',
        name: 'Annees scolairese',
        component: EditAnneesScolaires
      },
      {
        path: "annees-scolaires/add",
        name: "Annees scolaires",
        component: AddAnneesScolaires
      },


      {
        path: "sections-annee-scolaire",
        name: "Section Annee scolaire",
        component: SectionsAnneeScolaire
      },
      {
        path: '/sections-annee-scolaire/preview/:id(\\d+)',
        name: 'Section Annee scolaire',
        component: PreviewSectionsAnneeScolaire
      },
      {
        path: '/sections-annee-scolaire/edit/:id(\\d+)',
        name: 'Annees scolairese',
        component: EditSectionsAnneeScolaire
      },
      {
        path: "sections-annee-scolaire/add",
        name: "Section Annee scolaire",
        component: AddSectionsAnneeScolaire
      },


      {
        path: "matieres",
        name: "Matières",
        component: ListMatiere
      },
      {
        path: '/matieres/preview/:id(\\d+)',
        name: 'Matières',
        component: PreviewMatiere
      },
      {
        path: '/matieres/edit/:id(\\d+)',
        name: 'Matières',
        component: EditMatiere
      },
      {
        path: "matieres/add",
        name: "Matières",
        component: AddMatiere
      },

      {
        path: "series",
        name: "Series",
        component: ListSerie
      },
      {
        path: '/series/preview/:id(\\d+)',
        name: 'Series',
        component: PreviewSerie
      },
      {
        path: '/series/edit/:id(\\d+)',
        name: 'Series',
        component: EditSerie
      },
      {
        path: "series/add",
        name: "Series",
        component: AddSerie
      },

      {
        path: "niveaux",
        name: "Niveaux",
        component: ListNiveau
      },
      {
        path: '/niveaux/preview/:id(\\d+)',
        name: 'Niveaux',
        component: PreviewNiveau
      },
      {
        path: '/niveaux/edit/:id(\\d+)',
        name: 'Niveaux',
        component: EditNiveau
      },
      {
        path: "niveaux/add",
        name: "Niveaux",
        component: AddNiveau
      },

      // ------------------ NOTES ------------------ //
      {
        path: "notes",
        name: "Notes",
        component: ListNote
      },
      {
        path: '/notes/preview/:id(\\d+)',
        name: 'Notes',
        component: PreviewNote
      },
      {
        path: '/notes/edit/:id(\\d+)',
        name: 'Notes',
        component: EditNote
      },
      {
        path: "notes/add",
        name: "Notes",
        component: AddNote
      },

      // ------------------ PROFESSEURS ------------------ //

      {
        path: "professeurs",
        name: "Professeurs",
        component: ListProfesseur
      },
      {
        path: '/professeurs/preview/:id(\\d+)',
        name: 'Professeurs',
        component: PreviewProfesseur
      },
      {
        path: '/professeurs/edit/:id(\\d+)',
        name: 'Professeurs',
        component: EditProfesseur
      },
      {
        path: "professeurs/add",
        name: "Professeurs",
        component: AddProfesseur
      },

      // ------------------ CLASSES ------------------ //

      {
        path: "classes",
        name: "Classes",
        component: ListClasse
      },
      {
        path: '/classes/preview/:id(\\d+)',
        name: 'Classes',
        component: PreviewClasse
      },
      {
        path: '/classes/edit/:id(\\d+)',
        name: 'Classes',
        component: EditClasse
      },
      {
        path: "classes/add",
        name: "Classes",
        component: AddClasse
      },

      // ------------------ CLASSES PROFESSEURS MATIERES ------------------ //

      {
        path: "classes-matieres-professeurs",
        name: "Classes Professeurs Matieres",
        component: ListClasseProfesseurMatiere
      },
      {
        path: '/classes-matieres-professeurs/preview/:id(\\d+)',
        name: 'Classes Professeurs Matieres',
        component: PreviewClasseProfesseurMatiere
      },
      {
        path: '/classes-matieres-professeurs/edit/:id(\\d+)',
        name: 'Classes Professeurs Matieres',
        component: EditClasseProfesseurMatiere
      },
      {
        path: "classes-matieres-professeurs/add/:id(\\d+)",
        name: "Classes Professeurs Matieres",
        component: AddClasseProfesseurMatiere
      },

      // ------------------ ELEVES CLASSES ------------------ //

      {
        path: "eleves-classes",
        name: "Elèves classes",
        component: ListEleveClasse
      },
      {
        path: '/eleves-classes/preview/:id(\\d+)',
        name: 'Elèves classes',
        component: PreviewEleveClasse
      },
      {
        path: '/eleves-classes/edit/:id(\\d+)',
        name: 'Elèves classes',
        component: EditEleveClasse
      },
      {
        path: "/eleves-classes/add/:id(\\d+)",
        name: "Elèves classes",
        component: AddEleveClasse
      },

      // ------------------ ELEVES ------------------ //

      {
        path: "eleves",
        name: "Elèves",
        component: ListEleve
      },
      {
        path: '/eleves/preview/:id(\\d+)',
        name: 'Elèves',
        component: PreviewEleve
      },
      {
        path: '/eleves/edit/:id(\\d+)',
        name: 'Elèves',
        component: EditEleve
      },
      {
        path: "/eleves/add",
        name: "Elèves",
        component: AddEleve
      },

      // ------------------ PARENTS ------------------ //

      {
        path: "parents",
        name: "Parents",
        component: ListParent
      },
      {
        path: '/parents/preview/:id(\\d+)',
        name: 'Parents',
        component: PreviewParent
      },
      {
        path: '/parents/edit/:id(\\d+)',
        name: 'Parents',
        component: EditParent
      },
      {
        path: "/parents/add",
        name: "Parents",
        component: AddParent
      },
    ]
  },
  { path: "*", component: NotFound }
];

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes;
