function setDropdown(option) {

    const users = window.user;
    const company = parseInt(option.value);
    const select = document.querySelector("select[name='name']");
    select.innerHTML = '';


    let all = user.filter(item => {
        let c = false;
        for(let i in item.company_list) {
             c = (item.company_list[i].id === company);
             if(c) {
                 let optionUser = document.createElement('option');
                 optionUser.value = item.id;
                 optionUser.innerHTML = item.name;
                 select.appendChild(optionUser);
                 break;
             }

        }
        return c;
    });

}


window.testerPermission = (url) => {
    if(confirm('Valóban?')) window.location = url;
    return false;
};


$('.datepicker').datepicker({
    autoclose: true,
    days:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"],
    daysShort:["vas","hét","ked","sze","csü","pén","szo"],
    daysMin:["V","H","K","Sze","Cs","P","Szo"],
    months:["január","február","március","április","május","június","július","augusztus","szeptember","október","november","december"],
    monthsShort:["jan","feb","már","ápr","máj","jún","júl","aug","sze","okt","nov","dec"],
    today:"ma",
    weekStart:1,
    clear:"töröl",
    titleFormat:"yyyy. MM",
    format:"yyyy-mm-dd"
});


$('.hidden-form').on('click', function () {
    $('#hidden-form').toggle();
    $('#holiday-table').toggle();
    $(this).html('lenyitva')

});
$(document).ready(function() {
    if($('#holiday').length) $('#holiday').DataTable();
    if($('#workhours').length) $('#workhours').DataTable();
    if($('#contacts').length) {
        let c = new Contact();
    }



    if($('#wh-ci-container').length) {
        $('#incoming').on('click', function() {
            if(confirm('Menthetem?')) {
                saveWorkHour('incoming');
            } else {
                return false;
            }

        });

        $('#outgoing').on('click', function() {

            if(confirm('Menthetem?')) {
                saveWorkHour('outgoing');
            } else {
                return false;
            }
        });
    }


    $(document).on('click','#searchRange', () => {
        let ys, ye, ms, me, url;
        ys = $('[name="year-start"]').val();
        ms = $('[name="month-start"]').val();
        ye = $('[name="year-end"]').val();
        me = $('[name="month-end"]').val();
        url = `/workhours/date-range/${ys}-${ms}/${ye}-${me}`;
        // console.log(`/workhours/date-range/${ys}-${ms}-01/${ye}-${me}-31`)
       location.href = url;
    }).on('click', 'sendMessage', () => {
        console.log('chatform', $('[name="chatForm"]'));
    });





    let h = [];
    for(let i of ['07','08','09','10','11','12','13','14','15','16','17','18']) {
        for(let q of ['00','15','30','45']) {
            h.push(`${i}:${q}`);
        }
    }

    let pickerConfig = {
        allowTimes: h,
        format:'Y-m-d H:i:s',
        onChangeDateTime:function(dp,$input){
            $(`#${$input[0].dataset.target}`).val($input.val());
        }

    };

    $('.datetimepicker.incoming').datetimepicker(pickerConfig);
    $('.datetimepicker.outgoing ').datetimepicker(pickerConfig);

    window.submitUpdateWorkhourForm = () => {
        document.querySelector('#whForm').submit();
        return false;
    };

    window.confirmDelete = (id) => {
        if(confirm('valóban törli??')) {
            location.href = `/workhours/delete/${id}`;
        }
    };

    window.checkUserCheckin = () => {
        let user = $('[name="user"]').val();
        let prop = (user.length > 0);
        console.log('a prop', prop);
        $('#incoming').prop('disabled', !prop);
        $('#outgoing').prop('disabled', !prop);
    };


    if($('.message-detail-container').length) {
        window.chat = new Chat();
    }



});

$('#company-selector').on('change', function () {
    setDropdown(this);
});




let saveWorkHour = (type) => {
    let data = {
        uid: $('#user').val(),
        type
    };
    $.ajax({
        url: '/wh/checkin',
        method: 'post',
        data
    }).done((res) => {
        alert(res.message)

    })
};

class Contact {

    constructor() {
        this.data = {};
        this.contacts = [];

        this.table = $('#contacts').DataTable( {
            ajax: {
                url: '/api/contacts',
                dataSrc: 'contacts'
            },
            columns: [
                { data: 'contact_name' },
                { data: 'contact_phone' },
                { data: 'contact_email' },
                { data: 'contact_address' },
            ],
        } );

        $('#saveContact').on('click', this.createNewContact.bind(this));

    }

    collectData() {
        this.data = {
            contact_name: $('#contact_name').val(),
            contact_email: $('#contact_email').val(),
            contact_phone: $('#contact_phone').val(),
            contact_address: $('#contact_address').val(),
        };

        return this.checkData();
    }

    checkData( ) {
        let errors = 0;
        console.log('a data', this.data);
        if(!this.data.contact_name.length) {
            alert('Kötelező a név mező');
            errors++;
        }
        if(!this.data.contact_email.length) {
            alert('Kötelező az email mező');
            errors++;
        }

        return (errors === 0);

    }

    createNewContact() {
        if(this.collectData()) {
            $.ajax({
                url: '/api/contact/new',
                data: this.data,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(res => {
                if(res.status) {
                    this.table.ajax.reload( null, false );
                    this.data = {};
                    $('#contact_name, #contact_email, #contact_phone, #contact_address').val('');

                }

            });
        }

    }



}


window.cont = Contact;

class Chat {

    constructor() {

        this.users = [];

        this.conversation = {
            messages: [],
            conversationData: {
                created: '',
                id: '',
                title: '',
                sender: {
                    name: '',
                    id: '',
                },
                receiver: {
                    name: '',
                    id: '',
                },
            }
        };

        this.getAllEndpoint = '/api/messages/all';
        this.getSingleEndpoint = '/api/message';
        this.formEndpoint = '';
        this.getUsersEndpoint = '';


        this.url = window.location.pathname;

        this.handleUrl();

        $('#send-message').on('click', () => {
            console.log('form send');
            this.sendFormData();
        });

        this.timer = null;
        this.autoScroll = true;
        document.getElementById("autoscroll").checked = true;

        $('#autoscroll').on('change', this.handleAutoScroll.bind(this));

        $(document).on('keydown', (e) => {
            if(e.ctrlKey && e.key === 'Enter') {
                console.log('ctrl+enter');
                this.sendFormData();
            }
        })


    }

    handleAutoScroll(e) {
        let c = document.getElementById("autoscroll").checked;
        this.autoScroll = c;
    }

    handleUrl() {
        switch (true) {
            case /\/messages$/.test(this.url):
                console.log('list');
                this.getAllconversations();
                break;
            case /\/messages\/new/.test(this.url):
                console.log('new');
                this.formEndpoint = '/api/messages/new';
                this.listUsers();
                $('#message-list-container').remove();
                break;
            case /\/message\/[\d+]/.test(this.url):
                var r = new RegExp(/[\d]+/);
                var b = r.exec(this.url);
                console.log('single');
                this.getSingleConversation(b[0]);
                this.runRefresh();
                break;
            default:
                console.log('default');
                break;


        }
    }

    getAllconversations() {
        $('.lds-dual-ring').show();
        $.ajax({
            url: this.getAllEndpoint,
            method: 'get'
        }).done((res) => {
            console.log('done run');
            this.listConversations(res);
            $('.lds-dual-ring').hide();
        });
    }

    conversationsTemplate(conversation) {

        let receiver = (conversation.conversationData.sender.id === window.me) ? conversation.conversationData.receiver.name : conversation.conversationData.sender.name;
        return `<a href="/message/${conversation.conversationData.id}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    ${receiver} - ${conversation.conversationData.title}
                    <span class="badge badge-primary badge-pill">${conversation.conversationData.messagesLength}</span>
                </a>`;
    }

    listConversations(res) {
        let conversations = [];
        res.map((conversation) => {
            conversations.push(this.conversationsTemplate(conversation))
        });

        $('#conversation-list').html('').append(...conversations);
    }

    getSingleConversation(id, fresh = false) {
        if(!fresh)
            $('.lds-dual-ring').show();
        const url = `${this.getSingleEndpoint}/${id}`;
        $.ajax({
            url,
            method: 'get'
        }).done((res) => {
            if(!fresh)
                $('.lds-dual-ring').hide();
            Object.assign(this.conversation, res.conversation);
            this.showSingleConversation();
            this.setAnswerFormData();
        });
    }

    listUsers() {
        $('.lds-dual-ring').show();
        $.ajax({
            url: '/api/users'
        }).done( (users) => {
            this.users = users;
            let usersData = this.users.users.map(user => `<option value="${user['id']}">${user['name']}</option>`);

            $('[name="receiver"]').append(...usersData)
            $('.lds-dual-ring').hide();

        });
    }


    messageTemplate(message) {
        return  `<li class=" ${(message.by === 'sender') ? 'text-left' : 'text-right' } item">
                <p>
                    <small>${new Date(message.date.date).toLocaleString()}</small>
                    <br>
                    ${message.content}
                </p>
            </li>`;
    }

    showSingleConversation() {
        let messages = this.conversation.messages.map(message => this.messageTemplate(message) );
        $('#message-list').html('').append(...messages);
        if(this.autoScroll)
            document.querySelector('#message-list-container').scrollTop = document.querySelector('#message-list-container').scrollHeight;

        this.setHtmlData();

    }


    sendFormData() {
        let formData = {};
        let data = $('[name="chat-form"]').serializeArray();
        $.each( data, function( i, field ) {
            formData[field.name] = field.value;
        });
        $('.lds-dual-ring').show();
        $.ajax({
            url: this.formEndpoint,
            data: formData,
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(
            (res)=>{
                $('.lds-dual-ring').hide();
                this.handleResponse(res);

            });
    }


    setAnswerFormData() {
        this.formEndpoint = '/api/messages/answer';
        $('#user-list, #title-container').remove();
        $('[name="cid"]').val(this.conversation.conversationData.id);
    }

    handleResponse(res) {
        switch(res.code) {
            case 1:
                location.href = res.data.url;
                break;
            case 2:
                this.conversation=res.data.conversation;
                this.showSingleConversation();
                $('[name="msgContent"]').val('');
                break;
        }

    }

    setHtmlData() {
        $('#conversation-date').html(new Date(this.conversation.conversationData.created.date).toLocaleString());
        $('#contact').html((window.me === this.conversation.conversationData.sender.id) ? this.conversation.conversationData.receiver.name : this.conversation.conversationData.sender.name);

    }

    runRefresh() {
        clearInterval(this.timer);
        setInterval(()=> {
            this.getSingleConversation(this.conversation.conversationData.id, true);
        },5000);
    }


}


