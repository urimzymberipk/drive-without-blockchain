"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[4738],{6226:(t,e,n)=>{n.d(e,{Z:()=>r});const a={name:"CardNavigation",props:["pages"],computed:{routeName:function(){return this.$route.name}},data:function(){return{fixedNav:!1}},created:function(){var t=this;window.addEventListener("scroll",(function(){var e=document.getElementById("card-navigation");t.fixedNav=e.getBoundingClientRect().top<0}))}};const r=(0,n(1900).Z)(a,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"mb-7",staticStyle:{height:"62px"},attrs:{id:"card-navigation"}},[n("div",{class:{"fixed top-0 left-0 right-0 z-10 rounded-none bg-white bg-opacity-50 px-6 backdrop-blur-lg backdrop-filter dark:bg-dark-foreground":t.fixedNav}},[n("div",{staticClass:"overflow-x-auto whitespace-nowrap"},t._l(t.pages,(function(e,a){return n("router-link",{key:a,staticClass:"border-bottom-theme inline-block border-b-2 border-transparent px-4 py-5 text-sm font-bold",class:{"text-theme":t.routeName===e.route,"text-gray-600 dark:text-gray-100":t.routeName!==e.route},attrs:{to:{name:e.route},replace:""}},[t._v("\n                "+t._s(e.title)+"\n            ")])})),1)])])}),[],!1,null,null,null).exports},4677:(t,e,n)=>{n.r(e),n.d(e,{default:()=>r});const a={name:"AppSettings",components:{CardNavigation:n(6226).Z},data:function(){return{pages:[{title:this.$t("admin_settings.tabs.others"),route:"AppOthers"},{title:this.$t("login_and_registration"),route:"AppSignInUp"},{title:this.$t("appearance"),route:"AppAppearance"},{title:this.$t("Adsense"),route:"AppAdsense"},{title:this.$t("homepage"),route:"AppIndex"},{title:this.$t("environment"),route:"AppEnvironment"},{title:this.$t("server"),route:"AppServer"}]}},mounted:function(){"/admin/settings"===this.$route.path&&this.$router.push({name:"AppOthers"})}};const r=(0,n(1900).Z)(a,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"card z-10 shadow-card",staticStyle:{"padding-bottom":"0","padding-top":"0"}},[n("CardNavigation",{staticClass:"-mx-1",attrs:{pages:t.pages}})],1),t._v(" "),n("router-view")],1)}),[],!1,null,null,null).exports}}]);