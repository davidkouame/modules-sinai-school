<template>
  <card class="card" :title="title">
    <div class="row card-body-header">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <div class="float-right">
          <div class="row">
            <div class="col-md-8">
              <input
                type="text"
                class="form-control search"
                placeholder="Rechercher un user"
                @keyup="searchModel"
                v-model="search"
              />
            </div>
            <div class="col-md-4">
              <a :href="'#/users/add/'" class="btn btn-primary btn-add" v-if="checkPermission('ADD_USER')">Ajouter</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 card-body-body">
      <table class="table table-d">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nom et prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Rôle</th>
            <th scope="col">Date de création</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="users" v-for="(user, index) in users">
            <th scope="row">{{ indexPagnation + index + 1}}</th>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.role ? user.role.libelle : '' }}</td>
            <td>{{ user.created_at|formatDate }}</td>
            <td>
              <a
                :href="'#/users/preview/'+user.id"
                class="btn btn-icon btn-info btn-sm"
              >
                <!---->
                <i class="fa fa-eye"></i>
                <!---->
              </a>&nbsp;
              <a
                :href="'#/users/edit/'+user.id"
                class="btn btn-icon btn-success btn-sm" v-if="checkPermission('EDIT_USER')"
              >
                <!---->
                <i class="fa fa-edit"></i>
                <!---->
              </a>&nbsp;
              <a
                id="show-modal"
                @click="showModalF(user.id)"
                type="button"
                class="btn btn-icon btn-danger btn-sm btn-delete" v-if="checkPermission('DELETE_USER')"
              >
                <!---->
                <i class="fa fa-trash"></i>
                <!---->
              </a>
            </td>
          </tr>
          <tr v-show="showEmptySentenceUser">
            <td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td>
          </tr>
        </tbody>
      </table>

      <modal
        v-if="showModal"
        @close="showModal = false"
        v-bind:modelid="userId"
        modelname="user"
        textBody="Voulez vous supprimez cet utilisateur ?"
        nameUrl="users"
      ></modal>

      <div class="row" v-if="pageCount > 1">
        <div
          class="col-md-4"
          style="color: #98a7a8;font-size: 13px;"
        >Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}</div>
        <div class="col-md-8">
          <div class="float-right pagi">
            <paginate
              :page-count="pageCount"
              :click-handler="dispatchUsers"
              :prev-text="'&laquo;'"
              :next-text="'&raquo;'"
              :container-class="'pagination'"
              :page-class="'page-item'"
            ></paginate>
          </div>
        </div>
      </div>
    </div>
  </card>
</template>
<script>
export default {
  data() {
    return {
      title: "Liste des users",
      showModal: false,
      userId: null,
      search: null,
      indexPagnation: 0
    };
  },
  created() {
    this.dispatchUsers();
  },
  methods: {
    dispatchUsers(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "search", value: search },
        { key: "ecole_id", value: this.$cookies.get("ecoleId") },
        {
          key: "annee_scolaire_id",
          value: this.$cookies.get("anneeScolaireId")
        }
      ];
      this.$store.dispatch("getUsers", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    trimSearch(searchs = null) {
      let params = [];
      for (var key in searchs) {
        if (searchs[key].value) {
          params.push({ key: searchs[key].key, value: searchs[key].value });
        }
      }
      return params;
    },
    showModalF(userId = null) {
      this.showModal = true;
      this.userId = userId;
    },
    searchModel() {
      this.dispatchUsers(1, this.search);
    }
  },
  computed: {
    users() {
      return this.$store.getters.users;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    currentPage() {
      return this.$store.getters.currentPage;
    },
    countPage() {
      return this.$store.getters.countPage;
    },
    totalElement() {
      return this.$store.getters.totalElement;
    },
    showEmptySentenceUser() {
      return this.notEmptyObject(this.users) == 0;
    }
  },
  watch: {
    currentPage() {
      this.indexPagnation = (this.currentPage - 1) * 10;
    }
  }
};
</script>
<style>
.form-control.search {
  border-right: 0 none;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
  padding: 10px 10px 10px 10px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-right-color: rgb(221, 221, 221);
  border-right-style: solid;
  border-right-width: 1px;
  border-right-color: rgb(221, 221, 221);
  border-right-style: solid;
  border-right-width: 1px;
  border-radius: 4px;
  border-top-right-radius: 4px;
  border-bottom-right-radius: 4px;
  border-top-right-radius: 4px;
  border-bottom-right-radius: 4px;
  color: #66615b;
  line-height: normal;
  font-size: 14px;
}

.card-body-header .row {
  margin-right: 0px;
  margin-left: 0 px;
}

.card-body-body {
  padding-top: 20px;
}

.paginate active {
  z-index: 1;
  color: #fff;
  background-color: #8294a8;
}

.pagination .active a {
  z-index: 1;
  color: #fff !important;
  background-color: #8294a8 !important;
}
</style>
