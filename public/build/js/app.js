!function(e){function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}var t={};n.m=e,n.c=t,n.i=function(e){return e},n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function n(){return e.default}:function n(){return e};return n.d(t,"a",t),t},n.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},n.p="",n(n.s=2)}([function(e,n,t){"use strict";function o(e){var n=window.user,t=parseInt(e.value),o=document.querySelector("select[name='name']");o.innerHTML="";var r=user.filter(function(e){var n=!1;for(var r in e.company_list)if(n=e.company_list[r].id===t){var a=document.createElement("option");a.value=e.id,a.innerHTML=e.name,o.appendChild(a);break}return n})}window.testerPermission=function(e){return confirm("Valóban?")&&(window.location=e),!1},$(".datepicker").datepicker({autoclose:!0,days:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"],daysShort:["vas","hét","ked","sze","csü","pén","szo"],daysMin:["V","H","K","Sze","Cs","P","Szo"],months:["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],monthsShort:["jan","feb","már","ápr","máj","jún","júl","aug","sze","okt","nov","dec"],today:"ma",weekStart:1,clear:"töröl",titleFormat:"yyyy. MM",format:"yyyy-mm-dd"}),$(".hidden-form").on("click",function(){$("#hidden-form").toggle(),$("#holiday-table").toggle(),$(this).html("lenyitva")}),$(document).ready(function(){$("#holiday").length&&$("#holiday").DataTable(),$("#workhours").length&&$("#workhours").DataTable(),$("#wh-ci-container").length&&($("#incoming").on("click",function(){r("incoming")}),$("#outgoing").on("click",function(){r("outgoing")})),$(document).on("click","#searchRange",function(){var e=void 0,n=void 0,t=void 0,o=void 0,r=void 0;e=$('[name="year-start"]').val(),t=$('[name="month-start"]').val(),n=$('[name="year-end"]').val(),o=$('[name="month-end"]').val(),r="/workhours/date-range/"+e+"-"+t+"-01/"+n+"-"+o+"-31",location.href=r});for(var e=[],n=["07","08","09","10","11","12","13","14","15","16","17","18"],t=0;t<n.length;t++)for(var o=n[t],a=["00","15","30","45"],i=0;i<a.length;i++){var c=a[i];e.push(o+":"+c)}var u={allowTimes:e,format:"Y-m-d H:i:s",onChangeDateTime:function e(n,t){$("#"+t[0].dataset.target).val(t.val())}};$(".datetimepicker.incoming").datetimepicker(u),$(".datetimepicker.outgoing ").datetimepicker(u),window.submitUpdateWorkhourForm=function(){return document.querySelector("#whForm").submit(),!1},window.confirmDelete=function(e){confirm("valóban törli??")&&(location.href="/workhours/delete/"+e)}}),$("#company-selector").on("change",function(){o(this)});var r=function e(n){var t={uid:$("#user").val(),type:n};$.ajax({url:"/wh/checkin",method:"post",data:t}).done(function(e){alert(e.message)})}},function(e,n){},function(e,n,t){t(0),e.exports=t(1)}]);