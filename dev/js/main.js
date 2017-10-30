function setDropdown(option) {
    const users = window.user;
    const company = option.value;
    const select = document.querySelector("select[name='name']");
    select.innerHTML = '';

    for(let i in users) {

        if(users[i].company == company) { // company && users[i].company = int
            let optionUser = document.createElement('option');
            optionUser.value = users[i].id;
            optionUser.innerHTML = users[i].name;
            select.appendChild(optionUser);
        }
    }
}

$('.datepicker').datepicker({autoclose: true});
$('.hidden-form').on('click', function () {
    $('#hidden-form').toggle();
});
$(document).ready(function() {
    if($('#holiday').length) $('#holiday').DataTable();
});

$('#company-selector').on('change', function () {
    setDropdown(this);
});



