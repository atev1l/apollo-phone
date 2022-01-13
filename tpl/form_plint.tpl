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

</style>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>

<form action="/phone/{#link}/{#id}" method="post" class="p-edit" >
    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-pl-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-pl-c">
            <div class="input-group-text input-hover-c w-100" for="f-pl">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Плинт</label>
            </div>
        </div>
        <input id="f-pl" class="form-control" type="text" maxlength="254" type="text" name="name" value="{#name}">
        <div id="f-pl-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Наименование плинта
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-count-port-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-count-port-c">
            <div class="input-group-text input-hover-c w-100" for="f-ip-out">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Количество портов плинта</label>
            </div>
        </div>
        <input id="f-count-port" class="form-control" type="number" max="250" min="{#count_port}" step="1" name="count_port" value="{#count_port}">
        <div id="f-count-port-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Количество портов
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-room-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-room-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-room">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Аудитория</label>
            </div>
        </div>
        <select id="f-id-room" class="form-control" type="text" name="id_room">
            <option value="0" title="">нет</option>
            {#room_name}
        </select>
        <div id="f-id-room-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите аудиторию, в которой установлен плинт
            </div>
        </div>
    </div>


    {if id}<input type="hidden" name="id" value="{#id}">
    <input class="btn btn-success" type="submit" name="save_{#link}" value="Сохранить">
    {if id}<a class="btn btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>