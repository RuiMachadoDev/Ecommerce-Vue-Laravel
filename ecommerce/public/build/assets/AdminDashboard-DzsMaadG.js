import{Q as n,c as i,a as e,t as l,b as d,d as c,o as g}from"./app-NMxi0bKh.js";import{_ as p}from"./_plugin-vue_export-helper-DlAUqK2U.js";const u={setup(){const{props:o}=n(),t=o==null?void 0:o.csrf_token;return{...o,logout:async()=>{try{await c.post("/logout",{},{headers:{"X-CSRF-TOKEN":t}}),window.location.href="/login"}catch(s){console.error("Erro ao fazer logout:",s),alert("Ocorreu um erro ao tentar fazer logout.")}}}}},f={class:"min-h-screen bg-gray-100"},h={class:"w-full fixed top-0 left-0 bg-white shadow-md py-2 px-8 flex justify-between items-center z-50"},x={class:"flex items-center space-x-4"},m={class:"text-gray-600"};function w(o,t,r,s,v,y){return g(),i("div",f,[e("nav",h,[t[1]||(t[1]=e("div",null,[e("h1",{class:"text-lg font-semibold text-gray-800"},"E-Commerce Dashboard")],-1)),e("div",null,[e("div",x,[e("p",m,"Olá, "+l(o.auth.user.name),1),e("button",{onClick:t[0]||(t[0]=(...a)=>s.logout&&s.logout(...a)),class:"bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700"}," Logout ")])])]),t[2]||(t[2]=d('<div class="pt-20 px-8"><h2 class="text-2xl font-bold text-gray-800">Bem-vindo ao Painel Administrativo</h2><p class="mt-4 text-gray-600">Faça a gestão da sua aplicação de forma rápida e fácil.</p><div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"><a href="/categories" class="bg-gray-800 text-white px-6 py-4 rounded flex items-center justify-between hover:bg-gray-700"><span>Gerir Categorias</span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a><a href="/products" class="bg-gray-800 text-white px-6 py-4 rounded flex items-center justify-between hover:bg-gray-700"><span>Gerir Produtos</span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></div></div>',1))])}const _=p(u,[["render",w]]);export{_ as default};
