$(document).ready(function () {

    $.pjax.defaults.timeout = false;

    var keys = [];

    $('body').on('click', 'th :checkbox', function () {
        var che = $(this).is(':checked') ? true : false;
        var parent = $(this).closest('.grid-view').parent();
        $('td :checkbox',parent).each(function (i, o) {
            $(o).prop('checked', che);
        });
        setKeys(parent);
    });

    $('body').on('click', 'td :checkbox', function () {
        var parent = $(this).closest('.grid-view').parent();
        headerCheckbox(parent);
        setKeys(parent);
    });

    $(document).on('pjax:complete', function(xhr) {
        var parent = $(xhr.target);
        setChecked(parent);
        headerCheckbox(parent);
    });

    $(document).on('pjax:timeout', function(e) {
        var addusersContainer = $(xhr.target).closest('.addusers-container');
        e.preventDefault();
        $('.timeout-error',addusersContainer).show(1);
        $('html,body').animate({scrollTop: $('.timeout-error',addusersContainer).offset()}, 250);
    });

    $('.timeout-error .close').on('click',function(){
        $(this).closest('.timeout-error').hide(1);
    });

    function setKeys(parent) {
        var addusersContainer = parent.closest('.addusers-container');

        keys = currentArray(parent);

        $('td :checkbox',parent).each(function (i, o) {
            var index = $.inArray($(o).val(),keys);

            if ($(o).is(':checked')) {
                if(index == -1) keys.push($(o).val());
            } else {
                if(index != -1) keys.splice(index, 1);
            }
        });

        $('[name=users_to_add]',addusersContainer).val(keys);

        $('.btn-users',addusersContainer).prop('disabled',keys.length == 0);

    }

    function setChecked(parent){
        var addusersContainer = parent.closest('.addusers-container');

        keys = currentArray(parent);


        $('td :checkbox',parent).each(function (i, o) {
            if($.inArray($(o).val(),keys) > -1) $(o).prop('checked',true);
        });
    }

    function headerCheckbox(parent){
        var checkHeaderCheckbox = true;
        $(' td :checkbox',parent).each(function (i, o) {
            if (!$(o).prop('checked')) checkHeaderCheckbox = false;
        });
        checkHeaderCheckbox ? $('th :checkbox',parent).prop('checked', true) : $('th :checkbox',parent).prop('checked', false);
    }

    function currentArray(parent){
        var addusersContainer = parent.closest('.addusers-container');
        return $('[name=users_to_add]',addusersContainer).val() == "" ? [] : $('[name=users_to_add]',addusersContainer).val().split(',');
    }
});