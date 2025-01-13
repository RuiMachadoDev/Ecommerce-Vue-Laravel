import{Q as c,c as s,a as o,t as d,i as n,d as g,o as r}from"./app-NMxi0bKh.js";import{_ as u}from"./_plugin-vue_export-helper-DlAUqK2U.js";const p={setup(){const{props:e}=c(),t=e==null?void 0:e.csrf_token;return{...e,csrfToken:t,logout:async()=>{try{await g.post("/logout",{},{headers:{"X-CSRF-TOKEN":t}}),window.location.href="/login"}catch(a){console.error("Erro ao fazer logout:",a),alert("Ocorreu um erro ao tentar fazer logout.")}}}}},y={class:"min-h-screen bg-gray-100"},h={class:"w-full fixed top-0 left-0 bg-white shadow-md py-2 px-8 flex justify-between items-center z-50"},m={key:0,class:"flex items-center space-x-4"},x={class:"text-gray-600"},f={key:1},_={key:0,href:"/login",class:"text-gray-600 hover:text-gray-800 px-3"},v={key:1,href:"/register",class:"text-gray-600 hover:text-gray-800 px-3"},b={class:"text-center pt-20"},k={class:"mt-6 space-x-4"},w={key:0,href:"/dashboard",class:"bg-gray-800 text-white px-6 py-3 rounded hover:bg-gray-700"},E={key:1,href:"/login",class:"bg-gray-800 text-white px-6 py-3 rounded hover:bg-gray-700"};function C(e,t,i,a,B,L){return r(),s("div",y,[o("nav",h,[t[1]||(t[1]=o("div",null,[o("h1",{class:"text-lg font-semibold text-gray-800"},"E-Commerce App")],-1)),o("div",null,[e.auth.user?(r(),s("div",m,[o("p",x,"Olá, "+d(e.auth.user.name),1),o("button",{onClick:t[0]||(t[0]=(...l)=>a.logout&&a.logout(...l)),class:"bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700"}," Logout ")])):(r(),s("div",f,[e.canLogin?(r(),s("a",_," Login ")):n("",!0),e.canRegister?(r(),s("a",v," Registrar ")):n("",!0)]))])]),o("div",b,[t[2]||(t[2]=o("h2",{class:"text-3xl font-bold text-gray-800"},"Bem-vindo ao E-Commerce App",-1)),t[3]||(t[3]=o("p",{class:"mt-4 text-gray-600"}," Uma app intuitiva tanto para users comuns como para administradores. ",-1)),o("div",k,[e.auth.user?(r(),s("a",w," Entrar ")):(r(),s("a",E," Faça Login "))])])])}const O=u(p,[["render",C]]);export{O as default};
