<<<<<<< HEAD
!function(e){function o(r){if(n[r])return n[r].exports;var a=n[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,o),a.l=!0,a.exports}var n={};o.m=e,o.c=n,o.i=function(e){return e},o.d=function(e,n,r){o.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:r})},o.n=function(e){var n=e&&e.__esModule?function o(){return e.default}:function o(){return e};return o.d(n,"a",n),n},o.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},o.p="",o(o.s=2)}([function(e,o,n){"use strict";function r(e){var o=window.user,n=parseInt(e.value),r=document.querySelector("select[name='name']");r.innerHTML="";var a=user.filter(function(e){var o=!1;for(var a in e.company_list)if(o=e.company_list[a].id===n){var t=document.createElement("option");t.value=e.id,t.innerHTML=e.name,r.appendChild(t);break}return o})}window.testerPermission=function(e){return confirm("Valóban?")&&(window.location=e),!1},$(".datepicker").datepicker({autoclose:!0,days:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"],daysShort:["vas","hét","ked","sze","csü","pén","szo"],daysMin:["V","H","K","Sze","Cs","P","Szo"],months:["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],monthsShort:["jan","feb","már","ápr","máj","jún","júl","aug","sze","okt","nov","dec"],today:"ma",weekStart:1,clear:"töröl",titleFormat:"yyyy. MM",format:"yyyy-mm-dd"}),$(".hidden-form").on("click",function(){$("#hidden-form").toggle(),$("#holiday-table").toggle(),$(this).html("lenyitva")}),$(document).ready(function(){$("#holiday").length&&$("#holiday").DataTable(),$("#workhours").length&&$("#workhours").DataTable(),$("#wh-ci-container").length&&($("#incoming").on("click",function(){if(!confirm("Menthetem?"))return!1;a("incoming")}),$("#outgoing").on("click",function(){if(!confirm("Menthetem?"))return!1;a("outgoing")})),$(document).on("click","#searchRange",function(){var e=void 0,o=void 0,n=void 0,r=void 0,a=void 0;e=$('[name="year-start"]').val(),n=$('[name="month-start"]').val(),o=$('[name="year-end"]').val(),r=$('[name="month-end"]').val(),a="/workhours/date-range/"+e+"-"+n+"/"+o+"-"+r,location.href=a}).on("click","sendMessage",function(){console.log("chatform",$('[name="chatForm"]'))});for(var e=[],o=["07","08","09","10","11","12","13","14","15","16","17","18"],n=0;n<o.length;n++)for(var r=o[n],t=["00","15","30","45"],i=0;i<t.length;i++){var s=t[i];e.push(r+":"+s)}var l={allowTimes:e,format:"Y-m-d H:i:s",onChangeDateTime:function e(o,n){$("#"+n[0].dataset.target).val(n.val())}};$(".datetimepicker.incoming").datetimepicker(l),$(".datetimepicker.outgoing ").datetimepicker(l),window.submitUpdateWorkhourForm=function(){return document.querySelector("#whForm").submit(),!1},window.confirmDelete=function(e){confirm("valóban törli??")&&(location.href="/workhours/delete/"+e)},window.checkUserCheckin=function(){var e=$('[name="user"]').val(),o=e.length>0;console.log("a prop",o),$("#incoming").prop("disabled",!o),$("#outgoing").prop("disabled",!o)}}),$("#company-selector").on("change",function(){r(this)});var a=function e(o){var n={uid:$("#user").val(),type:o};$.ajax({url:"/wh/checkin",method:"post",data:n}).done(function(e){alert(e.message)})}},function(e,o){throw new Error('Module build failed: ModuleBuildError: Module build failed: \r\n    color: $font-base-color;\r\n          ^\r\n      Undefined variable: "$font-base-color".\r\n      in D:\\projects\\muszerfal\\holiday\\dev\\sass\\messages.scss (line 7, column 12)\n    at runLoaders (D:\\projects\\muszerfal\\holiday\\node_modules\\webpack\\lib\\NormalModule.js:192:19)\n    at D:\\projects\\muszerfal\\holiday\\node_modules\\webpack\\node_modules\\loader-runner\\lib\\LoaderRunner.js:364:11\n    at D:\\projects\\muszerfal\\holiday\\node_modules\\webpack\\node_modules\\loader-runner\\lib\\LoaderRunner.js:230:18\n    at context.callback (D:\\projects\\muszerfal\\holiday\\node_modules\\webpack\\node_modules\\loader-runner\\lib\\LoaderRunner.js:111:13)\n    at Object.asyncSassJobQueue.push [as callback] (D:\\projects\\muszerfal\\holiday\\node_modules\\sass-loader\\lib\\loader.js:55:13)\n    at Object.<anonymous> (D:\\projects\\muszerfal\\holiday\\node_modules\\sass-loader\\node_modules\\async\\dist\\async.js:2257:31)\n    at Object.callback (D:\\projects\\muszerfal\\holiday\\node_modules\\sass-loader\\node_modules\\async\\dist\\async.js:958:16)\n    at options.error (D:\\projects\\muszerfal\\holiday\\node_modules\\node-sass\\lib\\index.js:294:32)')},function(e,o,n){n(0),e.exports=n(1)}]);
=======
!function(e){function n(o){if(t[o])return t[o].exports;var a=t[o]={i:o,l:!1,exports:{}};return e[o].call(a.exports,a,a.exports,n),a.l=!0,a.exports}var t={};n.m=e,n.c=t,n.i=function(e){return e},n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function n(){return e.default}:function n(){return e};return n.d(t,"a",t),t},n.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},n.p="",n(n.s=2)}([function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}function a(e){var n=window.user,t=parseInt(e.value),o=document.querySelector("select[name='name']");o.innerHTML="";var a=user.filter(function(e){var n=!1;for(var a in e.company_list)if(n=e.company_list[a].id===t){var i=document.createElement("option");i.value=e.id,i.innerHTML=e.name,o.appendChild(i);break}return n})}var i=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}();window.testerPermission=function(e){return confirm("Valóban?")&&(window.location=e),!1},$(".datepicker").datepicker({autoclose:!0,days:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"],daysShort:["vas","hét","ked","sze","csü","pén","szo"],daysMin:["V","H","K","Sze","Cs","P","Szo"],months:["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],monthsShort:["jan","feb","már","ápr","máj","jún","júl","aug","sze","okt","nov","dec"],today:"ma",weekStart:1,clear:"töröl",titleFormat:"yyyy. MM",format:"yyyy-mm-dd"}),$(".hidden-form").on("click",function(){$("#hidden-form").toggle(),$("#holiday-table").toggle(),$(this).html("lenyitva")}),$(document).ready(function(){$("#holiday").length&&$("#holiday").DataTable(),$("#workhours").length&&$("#workhours").DataTable(),$("#wh-ci-container").length&&($("#incoming").on("click",function(){if(!confirm("Menthetem?"))return!1;r("incoming")}),$("#outgoing").on("click",function(){if(!confirm("Menthetem?"))return!1;r("outgoing")})),$(document).on("click","#searchRange",function(){var e=void 0,n=void 0,t=void 0,o=void 0,a=void 0;e=$('[name="year-start"]').val(),t=$('[name="month-start"]').val(),n=$('[name="year-end"]').val(),o=$('[name="month-end"]').val(),a="/workhours/date-range/"+e+"-"+t+"/"+n+"-"+o,location.href=a}).on("click","sendMessage",function(){console.log("chatform",$('[name="chatForm"]'))});for(var e=[],n=["07","08","09","10","11","12","13","14","15","16","17","18"],t=0;t<n.length;t++)for(var o=n[t],a=["00","15","30","45"],i=0;i<a.length;i++){var c=a[i];e.push(o+":"+c)}var l={allowTimes:e,format:"Y-m-d H:i:s",onChangeDateTime:function e(n,t){$("#"+t[0].dataset.target).val(t.val())}};$(".datetimepicker.incoming").datetimepicker(l),$(".datetimepicker.outgoing ").datetimepicker(l),window.submitUpdateWorkhourForm=function(){return document.querySelector("#whForm").submit(),!1},window.confirmDelete=function(e){confirm("valóban törli??")&&(location.href="/workhours/delete/"+e)},window.checkUserCheckin=function(){var e=$('[name="user"]').val(),n=e.length>0;console.log("a prop",n),$("#incoming").prop("disabled",!n),$("#outgoing").prop("disabled",!n)},window.chat=new s}),$("#company-selector").on("change",function(){a(this)});var r=function e(n){var t={uid:$("#user").val(),type:n};$.ajax({url:"/wh/checkin",method:"post",data:t}).done(function(e){alert(e.message)})},s=function(){function e(){switch(o(this,e),this.conversation={messages:[],conversationData:{created:"",id:"",title:"",sender:{name:"",id:""},receiver:{name:"",id:""}}},this.getAllEndpoint="/api/messages/all",this.getSingleEndpoint="",this.saveEndpoint="",this.createEndpoint="",this.url=window.location.pathname,this.url){case"/messages":this.getAllconversations()}}return i(e,[{key:"getAllconversations",value:function e(){var n=this;$.ajax({url:this.getAllEndpoint,method:"get"}).done(function(e){console.log("done run"),n.listConversations(e)})}},{key:"conversationsTemplate",value:function e(n){return'<a href="/message/'+n.conversationData.id+'" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">\n                    '+n.conversationData.receiver.name+" - "+n.conversationData.title+'\n                    <span class="badge badge-primary badge-pill">'+n.messages.length+"</span>\n                </a>"}},{key:"listConversations",value:function e(n){var t,o=this,a=[];n.map(function(e){a.push(o.conversationsTemplate(e))}),(t=$("#conversation-list").html("")).append.apply(t,a)}}]),e}()},function(e,n){},function(e,n,t){t(0),e.exports=t(1)}]);
>>>>>>> origin/message_with_ajax_refactor
