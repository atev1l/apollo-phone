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
        <div href="#f-id-socket-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-socket-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-socket">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Розетка</label>
            </div>
        </div>
        <select id="f-id-socket" class="form-control" type="text" name="id_socket" multiple>
            <option value="0" title="">нет</option>
            {#socketList}
        </select>
        <div id="f-id-socket-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите розетку, которую необходимо привязать к аудитории. Возможен множественный выбор.
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
            {#roomList}
        </select>
        <div id="f-id-room-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите аудиторию, к которой необходимо привязать розетку
            </div>
        </div>
    </div>


    {if id}<input type="hidden" name="id" value="{#id}">
    <input class="btn btn-success" type="submit" name="save_{#link}" value="Сохранить">
    {if id}<a class="btn btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>