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
            saveWorkHour('incoming');
        });

        $('#outgoing').on('click', function() {
            saveWorkHour('outgoing');
        });



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



