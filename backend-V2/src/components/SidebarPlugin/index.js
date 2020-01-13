import Sidebar from "./SideBar.vue";
import SidebarLink from "./SidebarLink";
import SousSidebarLink from "./SousSidebarLink";

const SidebarStore = {
  showSidebar: false,
  showSidebarParam: false,
  sidebarLinks: [],
  displaySidebar(value) {
    this.showSidebar = value;
  }
};

const SidebarPlugin = {
  install(Vue) {
    let app = new Vue({
      data: {
        sidebarStore: SidebarStore
      }
    });

    Vue.prototype.$sidebar = app.sidebarStore;
    Vue.component("side-bar", Sidebar);
    Vue.component("sidebar-link", SidebarLink);
    Vue.component("sous-sidebar-link", SousSidebarLink);
  }
};

export default SidebarPlugin;
