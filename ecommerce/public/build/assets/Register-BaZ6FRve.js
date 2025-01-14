import{T as f,e as c,w as n,o as w,f as o,u as e,Z as g,a as l,g as d,l as _,n as V,h as v}from"./app-D7z7GU7d.js";import{_ as y}from"./GuestLayout-CJzPrEwB.js";import{_ as t,a as m,b as i}from"./TextInput-Cme4vwih.js";import{P as b}from"./PrimaryButton-D1iDxZyo.js";import"./ApplicationLogo-CGEl_bFW.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const x={class:"mt-4"},k={class:"mt-4"},q={class:"mt-4"},B={class:"flex items-center justify-end mt-4"},j={__name:"Register",setup(N){const s=f({name:"",email:"",password:"",password_confirmation:""}),u=()=>{s.post(route("register"),{onFinish:()=>s.reset("password","password_confirmation")})};return(p,a)=>(w(),c(y,null,{default:n(()=>[o(e(g),{title:"Register"}),l("form",{onSubmit:v(u,["prevent"])},[l("div",null,[o(t,{for:"name",value:"Name"}),o(m,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:e(s).name,"onUpdate:modelValue":a[0]||(a[0]=r=>e(s).name=r),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.name},null,8,["message"])]),l("div",x,[o(t,{for:"email",value:"Email"}),o(m,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(s).email,"onUpdate:modelValue":a[1]||(a[1]=r=>e(s).email=r),required:"",autocomplete:"username"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.email},null,8,["message"])]),l("div",k,[o(t,{for:"password",value:"Password"}),o(m,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:e(s).password,"onUpdate:modelValue":a[2]||(a[2]=r=>e(s).password=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password},null,8,["message"])]),l("div",q,[o(t,{for:"password_confirmation",value:"Confirm Password"}),o(m,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:e(s).password_confirmation,"onUpdate:modelValue":a[3]||(a[3]=r=>e(s).password_confirmation=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password_confirmation},null,8,["message"])]),l("div",B,[o(e(_),{href:p.route("login"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:n(()=>a[4]||(a[4]=[d(" Already registered? ")])),_:1},8,["href"]),o(b,{class:V(["ms-4",{"opacity-25":e(s).processing}]),disabled:e(s).processing},{default:n(()=>a[5]||(a[5]=[d(" Register ")])),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{j as default};
