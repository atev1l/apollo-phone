<link rel="stylesheet" type="text/css" href="/styles/module_phone.css">
<link href="/js/bootstrap-4-chosen/dist/css/component-chosen.css" rel="stylesheet">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script>

<style>

    .page-edit-txt-l {
        width: 20%;
        float: left;
        text-align: left;
    }

    .page-edit-input-r {
        width: 80%;
        float: left;
    }

    .page-edit-row {
        display: table-cell;
        width: 100%;
    }

    .input-hover-c {
        cursor: help;
    }

    .input-hover-c:hover {
        background-color: #022d46;
        color: #fff;
    }

    #content {
	height: 100vh;
    }

</style>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover();

    })
    $( window ).on( "load", function() {
        $.ajax({
            url: "/ajax/phone/edituser/{#id}",
            type: 'GET',
            cache: false,
            success: function(html){
                $("#content").html(html);
                $( "#user" ).autocomplete({
                    source: "/ajax/phone/getusers",
                    minLength: 3,
                    select: function( event, ui ) {
                        $('#selected_user').val(ui.item.value);
                    }
                });
            },
            error: function(){
                //$("#content").html('<p class="validateTips">Ошибка при загрузке.</p>');
            }
        });
    });


</script>

<div id="content">

<form action="/phone/{#link}/{#id}" method="post" class="p-edit pt-2">

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-socket-c" class="input-group-prepend col-12 col-lg-3 col-sm-6 p-0" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-socket-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-socket">
                <i class="fas fa-ethernet mr-2"></i>
                <label class="mb-0">Розетка</label>
            </div>
        </div>
        <select id="f-id-socket" class="form-control" type="text" name="id_socket">
            <option value="0" title="">нет</option>
            {#socket_name}
        </select>
        <div id="f-id-socket-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите розетку, для которой хотите закрепить пользователя телефонным аппаратом.  Для упрощения поиска, для создания связи, в списке также добавлен телефонный номер рядом с розеткой и аудиторией.
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-user-c" class="input-group-prepend col-12 col-lg-3 col-sm-6 p-0" data-toggle="collapse" aria-expanded="false" aria-controls="f-user-c">
            <div class="input-group-text input-hover-c w-100" for="f-user">
                <i class="fas fa-user-tie mr-2"></i>
                <label class="mb-0">Пользователь</label>
            </div>
        </div>
        <input id="user" name="user" placeholder='Введите ФИО сотрудника' class="form-control form-control-sm" {if user}value='{#user}'{/if}>
        <div class="input-group-append">
            <button type="button" class="btn btn-secondary-outline btn-sm" title="Очистить поле ввода" onclick="$('#user').val(''); $('#selected_user').val('');"><i class='fas fa-times'></i></button>
        </div>
        <input type='hidden' name='selected_user' id='selected_user' {if user}value='{#user}'{/if}>
        <div id="f-user-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите пользователя, для которого назначаете телефонную розетку. Пользователя необходимо выбирать в соответствии с занимаемой административной должностью. Если она не указана, как может быть например для декана, необходимо выбрать строку, где указан факультет без должности. В случае, если вы выберите для декана строку, где он преподаватель, то в телефонном справочнике пользователь на отобразится.
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-comment" class="input-group-prepend col-12 col-lg-3 col-sm-6 p-0" data-toggle="collapse" aria-expanded="false" aria-controls="f-comment">
            <div class="input-group-text input-hover-c w-100">
                <i class="fas fa-comment-dots mr-2"></i>
                <label class="mb-0" for="f-comment-c">Комментарий</label>
            </div>
        </div>
            <input is="f-comment-c" class="form-control" type="text" name="text" value="{#text}">
        <div id="f-comment" class="collapse mt-1 w-100">
            <div class="card p-2">
                Если за розеткой не закреплён пользователь, тогда напишите комментарий о том, что закреплено за этой розеткой. Например, Преподавательская кафедры Вычислительной техники.
            </div>
        </div>
    </div>

    {if id}<input type="hidden" name="id" value="{#id}">
    <div class="d-flex col-12 col-lg-3 col-sm-6 p-0 my-3">
    <button class="btn btn-sm btn-success w-50 text-nowrap" type="submit" name="save_{#link}"><i class="fas fa-save mr-2"></i>Сохранить</button>
    {if id}<a class="btn btn-sm btn-danger w-50 text-nowrap" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')"><i class="far fa-trash-alt mr-2"></i>Удалить</a>
    </div>
</form>
</div>
{part "modules/phone/tpl/chosen_injection.tpl"}