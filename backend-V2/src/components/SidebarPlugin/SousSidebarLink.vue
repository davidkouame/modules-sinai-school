<template>
  <component :is="tag"
           @click.native="hideSidebar"
           class="nav-item"
           v-bind="$attrs"
           tag="li">
  <a class="nav-link">
    <slot>
      <i v-if="icon" :class="icon"></i>
      <p>{{name}}</p>
    </slot>
  </a>
  <!--<div class="collapse-menu" :style="style" style="animation-fill-mode: both; animation-timing-function: ease-out;padding-left: 42px" >
    <li class="nav-item">
      <a href="#/table-list" class="nav-link">
        <i class="ti-view-list-alt"></i><p>sous 1</p>
      </a>
      <a href="#/table-list" class="nav-link">
        <i class="ti-view-list-alt"></i><p>sous 2</p>
      </a>
    </li>
  </div>-->        
</component>
</template>
<script>
export default {
  name: "sous-sidebar-link",
  inject: {
    addSousLink: {
      default: ()=>{}
    },
    removeSousLink: {
      default: ()=>{}
    }
  },
  props: {
    name: String,
    icon: String,
    tag: {
      type: String,
      default: "router-link"
    },
    sidebarLinks: {
      type: Array,
      default: () => []
    },
  },
  mounted(){
  	if (this.addSousLink) {
      this.addSousLink(this);
      // console.log(this)
    }
  	// console.log("nous so mmes dans le sous sidebar")
  },
  created(){
  	// console.log("nous so mmes dans le sous sidebar")
  },
  beforeDestroy() {
    if (this.$el && this.$el.parentNode) {
      this.$el.parentNode.removeChild(this.$el)
    }
    if (this.removeSousLink) {
      this.removeSosusLink(this);
    }
  },
  data(){
    return {
      showSousSidebarLinkMenu: false
    }
  },
  methods: {
    hideSidebar(){
      
    }
  }
};
</script>
<style>
</style>
