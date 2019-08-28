<template>
  <!-- <h1>{{ msg }}</h1> -->
  <div>
    <div>Page qbdbsq </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <ul class="admin-menu">
            <!-- Links are to sibling routes -->
            <li><router-link to="/admin">View Products</router-link></li>
            <li><router-link to="/admin/new">New Product</router-link></li>
          </ul>
        </div>
  <router-view></router-view>
  </div>
  
</template>
