!function(e){function t(a){if(n[a])return n[a].exports;var o=n[a]={i:a,l:!1,exports:{}};return e[a].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var n={};t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,a){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:a})},t.n=function(e){var n=e&&e.__esModule?function t(){return e.default}:function t(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=2)}([function(e,t,n){"use strict";function a(e){if(Array.isArray(e)){for(var t=0,n=Array(e.length);t<e.length;t++)n[t]=e[t];return n}return Array.from(e)}function o(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function i(e){var t=window.user,n=parseInt(e.value),a=document.querySelector("select[name='name']");a.innerHTML="";var o=user.filter(function(e){var t=!1;for(var o in e.company_list)if(t=e.company_list[o].id===n){var i=document.createElement("option");i.value=e.id,i.innerHTML=e.name,a.appendChild(i);break}return t})}var r=function(){function e(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}return function(t,n,a){return n&&e(t.prototype,n),a&&e(t,a),t}}();window.testerPermission=function(e){return confirm("Valóban?")&&(window.location=e),!1},$(".datepicker").datepicker({autoclose:!0,days:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"],daysShort:["vas","hét","ked","sze","csü","pén","szo"],daysMin:["V","H","K","Sze","Cs","P","Szo"],months:["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],monthsShort:["jan","feb","már","ápr","máj","jún","júl","aug","sze","okt","nov","dec"],today:"ma",weekStart:1,clear:"töröl",titleFormat:"yyyy. MM",format:"yyyy-mm-dd"}),$(".hidden-form").on("click",function(){$("#hidden-form").toggle(),$("#holiday-table").toggle(),$(this).html("lenyitva")}),$(document).ready(function(){if($("#holiday").length&&$("#holiday").DataTable(),$("#workhours").length&&$("#workhours").DataTable(),$("#contacts").length)var e=new c;$("#wh-ci-container").length&&($("#incoming").on("click",function(){if(!confirm("Menthetem?"))return!1;s("incoming")}),$("#outgoing").on("click",function(){if(!confirm("Menthetem?"))return!1;s("outgoing")})),$(document).on("click","#searchRange",function(){var e=void 0,t=void 0,n=void 0,a=void 0,o=void 0;e=$('[name="year-start"]').val(),n=$('[name="month-start"]').val(),t=$('[name="year-end"]').val(),a=$('[name="month-end"]').val(),o="/workhours/date-range/"+e+"-"+n+"/"+t+"-"+a,location.href=o}).on("click","sendMessage",function(){console.log("chatform",$('[name="chatForm"]'))});for(var t=[],n=["07","08","09","10","11","12","13","14","15","16","17","18"],a=0;a<n.length;a++)for(var o=n[a],i=["00","15","30","45"],r=0;r<i.length;r++){var u=i[r];t.push(o+":"+u)}var d={allowTimes:t,format:"Y-m-d H:i:s",onChangeDateTime:function e(t,n){$("#"+n[0].dataset.target).val(n.val())}};$(".datetimepicker.incoming").datetimepicker(d),$(".datetimepicker.outgoing ").datetimepicker(d),window.submitUpdateWorkhourForm=function(){return document.querySelector("#whForm").submit(),!1},window.confirmDelete=function(e){confirm("valóban törli??")&&(location.href="/workhours/delete/"+e)},window.checkUserCheckin=function(){var e=$('[name="user"]').val(),t=e.length>0;console.log("a prop",t),$("#incoming").prop("disabled",!t),$("#outgoing").prop("disabled",!t)},$(".message-detail-container").length&&(window.chat=new l),$("#conversation-list").length&&(window.chat=new l)}),$("#company-selector").on("change",function(){i(this)});var s=function e(t){var n={uid:$("#user").val(),type:t};$.ajax({url:"/wh/checkin",method:"post",data:n}).done(function(e){alert(e.message)})},c=function(){function e(){o(this,e),this.data={},this.contacts=[],this.table=$("#contacts").DataTable({ajax:{url:"/api/contacts",dataSrc:"contacts"},columns:[{data:"contact_name"},{data:"contact_phone"},{data:"contact_email"},{data:"contact_address"}]}),$("#saveContact").on("click",this.createNewContact.bind(this))}return r(e,[{key:"collectData",value:function e(){return this.data={contact_name:$("#contact_name").val(),contact_email:$("#contact_email").val(),contact_phone:$("#contact_phone").val(),contact_address:$("#contact_address").val()},this.checkData()}},{key:"checkData",value:function e(){var t=0;return console.log("a data",this.data),this.data.contact_name.length||(alert("Kötelező a név mező"),t++),this.data.contact_email.length||(alert("Kötelező az email mező"),t++),0===t}},{key:"createNewContact",value:function e(){var t=this;this.collectData()&&$.ajax({url:"/api/contact/new",data:this.data,method:"post",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done(function(e){e.status&&(t.table.ajax.reload(null,!1),t.data={},$("#contact_name, #contact_email, #contact_phone, #contact_address").val(""))})}}]),e}();window.cont=c;var l=function(){function e(){var t=this;o(this,e),this.users=[],this.conversation={messages:[],conversationData:{created:"",id:"",title:"",sender:{name:"",id:""},receiver:{name:"",id:""}}},this.getAllEndpoint="/api/messages/all",this.getSingleEndpoint="/api/message",this.formEndpoint="",this.getUsersEndpoint="",this.url=window.location.pathname,this.handleUrl(),$("#send-message").on("click",function(){console.log("form send"),t.sendFormData()}),this.timer=null,this.autoScroll=!0,document.getElementById("autoscroll").checked=!0,$("#autoscroll").on("change",this.handleAutoScroll.bind(this)),$(document).on("keydown",function(e){e.ctrlKey&&"Enter"===e.key&&(console.log("ctrl+enter"),t.sendFormData())})}return r(e,[{key:"handleAutoScroll",value:function e(t){var n=document.getElementById("autoscroll").checked;this.autoScroll=n}},{key:"handleUrl",value:function e(){switch(!0){case/\/messages$/.test(this.url):console.log("list"),this.getAllconversations();break;case/\/messages\/new/.test(this.url):console.log("new"),this.formEndpoint="/api/messages/new",this.listUsers(),$("#message-list-container").remove();break;case/\/message\/[\d+]/.test(this.url):var t=new RegExp(/[\d]+/),n=t.exec(this.url);console.log("single"),this.getSingleConversation(n[0]),this.runRefresh();break;default:console.log("default")}}},{key:"getAllconversations",value:function e(){var t=this;$(".lds-dual-ring").show(),$.ajax({url:this.getAllEndpoint,method:"get"}).done(function(e){t.listConversations(e),$(".lds-dual-ring").hide()},function(e){return console.log(e)})}},{key:"conversationsTemplate",value:function e(t){var n=t.conversationData.sender.id===window.me?t.conversationData.receiver.name:t.conversationData.sender.name;return'<a href="/message/'+t.conversationData.id+'" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">\n                    \n                    <span>'+n+" - "+t.conversationData.title+"</span>\n                    "+(t.conversationData.unread?'<span class="badge badge-primary badge-danger">!</span>':"")+'\n                    <span class="badge badge-primary badge-pill">'+t.conversationData.messagesLength+"</span>\n                </a>"}},{key:"listConversations",value:function e(t){var n,a=this,o=[];t.map(function(e){o.push(a.conversationsTemplate(e))}),(n=$("#conversation-list").html("")).append.apply(n,o)}},{key:"getSingleConversation",value:function e(t){var n=this,a=!(arguments.length<=1||void 0===arguments[1])&&arguments[1];a||$(".lds-dual-ring").show();var o=this.getSingleEndpoint+"/"+t;$.ajax({url:o,method:"get"}).done(function(e){a||$(".lds-dual-ring").hide(),Object.assign(n.conversation,e.conversation),n.showSingleConversation(),n.setAnswerFormData()})}},{key:"listUsers",value:function e(){var t=this;$(".lds-dual-ring").show(),$.ajax({url:"/api/users"}).done(function(e){var n;t.users=e;var o=t.users.users.map(function(e){return'<option value="'+e.id+'">'+e.name+"</option>"});(n=$('[name="receiver"]')).append.apply(n,a(o)),$(".lds-dual-ring").hide()})}},{key:"messageTemplate",value:function e(t){return'<li class=" '+("sender"===t.by?"text-left":"text-right")+' item">\n                <p>\n                    <small>'+new Date(t.date.date).toLocaleString()+"</small>\n                    <br>\n                    "+t.content+"\n                </p>\n            </li>"}},{key:"showSingleConversation",value:function e(){var t,n=this,o=this.conversation.messages.map(function(e){return n.messageTemplate(e)});(t=$("#message-list").html("")).append.apply(t,a(o)),this.autoScroll&&(document.querySelector("#message-list-container").scrollTop=document.querySelector("#message-list-container").scrollHeight),this.setHtmlData()}},{key:"sendFormData",value:function e(){var t=this,n={},a=$('[name="chat-form"]').serializeArray();$.each(a,function(e,t){n[t.name]=t.value}),$(".lds-dual-ring").show(),$.ajax({url:this.formEndpoint,data:n,method:"post",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}).done(function(e){$(".lds-dual-ring").hide(),t.handleResponse(e)})}},{key:"setAnswerFormData",value:function e(){this.formEndpoint="/api/messages/answer",$("#user-list, #title-container").remove(),$('[name="cid"]').val(this.conversation.conversationData.id)}},{key:"handleResponse",value:function e(t){switch(t.code){case 1:location.href=t.data.url;break;case 2:this.conversation=t.data.conversation,this.showSingleConversation(),$('[name="msgContent"]').val("")}}},{key:"setHtmlData",value:function e(){$("#conversation-date").html(new Date(this.conversation.conversationData.created.date).toLocaleString()),$("#contact").html(window.me===this.conversation.conversationData.sender.id?this.conversation.conversationData.receiver.name:this.conversation.conversationData.sender.name)}},{key:"runRefresh",value:function e(){var t=this;clearInterval(this.timer),setInterval(function(){t.getSingleConversation(t.conversation.conversationData.id,!0)},5e3)}}]),e}(),u=function(){function e(){o(this,e),this.init()}return r(e,[{key:"init",value:function e(){var t=this;$.ajax({url:"/api/messages/check",method:"get",data:{uid:window.me}}).done(function(e){t.alertNewMessage(e)})}},{key:"alertNewMessage",value:function e(t){t>0?$("#messageDropdown span").show().html(t):$("#messageDropdown span").hide().html("")}}]),e}(),d=new u;window.checkInfo=u},function(e,t){},function(e,t,n){n(0),e.exports=n(1)}]);