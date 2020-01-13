<template>
  <component :is="tag"
             @click.native="hideSidebar"
             class="nav-item"
             v-bind="$attrs"
             tag="li">
    <a class="nav-link" @click="testClick">
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
    <ul class="nav" style="margin-left: -22px;" v-bind:style="{display:showSousParams}">
      <slot name="souslinks">
      </slot>
    </ul>      
  </component>
</template>
<script>

const getCircularReplacer = () => {
  const seen = new WeakSet();
  return (key, value) => {
    if (typeof value === "object" && value !== null) {
      if (seen.has(value)) {
        return;
      }
      seen.add(value);
    }
    return value;
  };
};

export default {
  name: "sidebar-link",
  // inheritAttrs: false,
  data() {
    return {
      style: "animation-fill-mode: both; animation-timing-function: ease-out; display: none;",
      isSee: false,
      souslinks: [],
      isMenuParam: false
    };
  },
  inject: {
    autoClose: {
      default: true
    },
    addLink: {
      default: ()=>{}
    },
    removeLink: {
      default: ()=>{}
    }
  },
  provide() {
    return {
      addSousLink: this.addSousLink,
    };
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
  methods: {
    hideSidebar() {
      // alert("dhdhd");
      return 0;
      var styleShow = "animation-fill-mode: both; animation-timing-function: ease-out;padding-left: 42px;"
      var styleHide = "animation-fill-mode: both; animation-timing-function: ease-out; display: none;padding-left: 42px;"
      this.style = styleShow
      if(this.isSee == false){
        this.style = styleShow
        this.isSee = true
      }else{
        this.style = styleHide
        this.isSee = false
      }
      if (this.autoClose) {
        this.$sidebar.displaySidebar(false);
      }
    },
    isActive() {
      return this.$el.classList.contains("active");
    },
    addSousLink(souslink) {
      // console.log("ffhf")
      // console.log(JSON.stringify(souslink.$vnode, getCircularReplacer()))
      const index = this.$slots.souslinks.indexOf(souslink.$vnode);
      this.souslinks.splice(index, 0, souslink);
    },
    removeSousLink(souslink) {
      const index = this.souslinks.indexOf(souslink);
      if (index > -1) {
        this.souslinks.splice(index, 1);
      }
    },
    testClick(){
      // console.log("le nom du menu est params "+this.name)
      // this.isMenuParam = this.name == "Paramètre"
      // this.$sidebar.showSidebarParam
      if(this.name == "Paramètre"){
        this.$sidebar.showSidebarParam = true
      }else{
        this.$sidebar.showSidebarParam = false
      }
      // console.log("le menu est "+this.isMenuParam)
    }
  },
  mounted() {
    if (this.addLink) {
      this.addLink(this);
    }
    // console.log("---------- debut de la liste ------")
    // console.log(this.souslinks)
    // console.log("---------- fin de la liste ----------")
  },
  created(){
    // console.log("liste des sous links "+ JSON.stringify(this.$slots.souslinks, getCircularReplacer()))
    // console.log(this.souslinks)
    // console.log("à la création");
  },
  beforeDestroy() {
    if (this.$el && this.$el.parentNode) {
      this.$el.parentNode.removeChild(this.$el)
    }
    if (this.removeLink) {
      this.removeLink(this);
    }
  },
  computed:{
    showSousParams(){
      if(this.$sidebar.showSidebarParam){
        return 'block'
      }else{
        return 'none'
      }
    }
  }
};
</script>
<style>
</style>
