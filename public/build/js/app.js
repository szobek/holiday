!function(e){function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}var t={};n.m=e,n.c=t,n.i=function(e){return e},n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:r})},n.n=function(e){var t=e&&e.__esModule?function n(){return e.default}:function n(){return e};return n.d(t,"a",t),t},n.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},n.p="",n(n.s=2)}([function(e,n,t){"use strict";function r(e){var n=window.user,t=parseInt(e.value),r=document.querySelector("select[name='name']");r.innerHTML="";var o=user.filter(function(e){var n=!1;for(var o in e.company_list)if(n=e.company_list[o].id===t){var a=document.createElement("option");a.value=e.id,a.innerHTML=e.name,r.appendChild(a);break}return n})}window.testerPermission=function(e){return confirm("Valóban?")&&(window.location=e),!1},$(".datepicker").datepicker({autoclose:!0,days:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"],daysShort:["vas","hét","ked","sze","csü","pén","szo"],daysMin:["V","H","K","Sze","Cs","P","Szo"],months:["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],monthsShort:["jan","feb","már","ápr","máj","jún","júl","aug","sze","okt","nov","dec"],today:"ma",weekStart:1,clear:"töröl",titleFormat:"yyyy. MM",format:"yyyy-mm-dd"}),$(".hidden-form").on("click",function(){$("#hidden-form").toggle()}),$(document).ready(function(){$("#holiday").length&&$("#holiday").DataTable()}),$("#company-selector").on("change",function(){r(this)})},function(e,n){},function(e,n,t){t(0),e.exports=t(1)}]);