import{k as u,A as i,o as s,c as t,a as d,t as l,r as m,H as p,p as _,x as f,s as g}from"./app-D7z7GU7d.js";const v={class:"text-sm text-red-600"},S={__name:"InputError",props:{message:{type:String}},setup(e){return(a,o)=>u((s(),t("div",null,[d("p",v,l(e.message),1)],512)),[[i,e.message]])}},x={class:"block font-medium text-sm text-gray-700"},h={key:0},y={key:1},V={__name:"InputLabel",props:{value:{type:String}},setup(e){return(a,o)=>(s(),t("label",x,[e.value?(s(),t("span",h,l(e.value),1)):(s(),t("span",y,[m(a.$slots,"default")]))]))}},M={__name:"TextInput",props:{modelValue:{type:String,required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(e,{expose:a}){const o=p(e,"modelValue"),n=_(null);return f(()=>{n.value.hasAttribute("autofocus")&&n.value.focus()}),a({focus:()=>n.value.focus()}),(b,r)=>u((s(),t("input",{class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm","onUpdate:modelValue":r[0]||(r[0]=c=>o.value=c),ref_key:"input",ref:n},null,512)),[[g,o.value]])}};export{V as _,M as a,S as b};
