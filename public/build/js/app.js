!function(n){function e(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return n[o].call(r.exports,r,r.exports,e),r.l=!0,r.exports}var t={};e.m=n,e.c=t,e.i=function(n){return n},e.d=function(n,t,o){e.o(n,t)||Object.defineProperty(n,t,{configurable:!1,enumerable:!0,get:o})},e.n=function(n){var t=n&&n.__esModule?function e(){return n.default}:function e(){return n};return e.d(t,"a",t),t},e.o=function(n,e){return Object.prototype.hasOwnProperty.call(n,e)},e.p="",e(e.s=2)}([function(n,e,t){"use strict";function o(n){var e=window.user,t=parseInt(n.value),o=document.querySelector("select[name='name']");o.innerHTML="";var r=user.filter(function(n){var e=!1;for(var r in n.company_list)if(e=n.company_list[r].id===t){var i=document.createElement("option");i.value=n.id,i.innerHTML=n.name,o.appendChild(i);break}return e})}window.testerPermission=function(n){return confirm("Valóban?")&&(window.location=n),!1},$(".datepicker").datepicker({autoclose:!0,days:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"],daysShort:["vas","hét","ked","sze","csü","pén","szo"],daysMin:["V","H","K","Sze","Cs","P","Szo"],months:["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],monthsShort:["jan","feb","már","ápr","máj","jún","júl","aug","sze","okt","nov","dec"],today:"ma",weekStart:1,clear:"töröl",titleFormat:"yyyy. MM",format:"yyyy-mm-dd"}),$(".hidden-form").on("click",function(){$("#hidden-form").toggle(),$("#holiday-table").toggle(),$(this).html("lenyitva")}),$(document).ready(function(){$("#holiday").length&&$("#holiday").DataTable(),$("#workhours").length&&$("#workhours").DataTable(),$("#wh-ci-container").length&&($("#incoming").on("click",function(){r("incoming")}),$("#outgoing").on("click",function(){r("outgoing")}))}),$("#company-selector").on("change",function(){o(this)});var r=function n(e){var t={uid:$("#user").val(),type:e};$.ajax({url:"/wh/checkin",method:"post",data:t}).done(function(n){alert(n.message)})}},function(n,e){},function(n,e,t){t(0),n.exports=t(1)}]);