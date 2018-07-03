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



