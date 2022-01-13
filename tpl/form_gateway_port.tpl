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
        <div href="#f-id-gw-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-gw-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-gw">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Шлюз</label>
            </div>
        </div>
        <select id="f-id-gw" class="form-control" type="text" name="id_gateway[]">
            <option value="0" title="">нет</option>
            {#gateway_name}
        </select>
        <div id="f-id-gw-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите шлюз, которому необходимо назначить порт
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-port-name-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-port-name-c">
            <div class="input-group-text input-hover-c w-100" for="f-port-name">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Наименование порта шлюза</label>
            </div>
        </div>
        <input id="f-port-name" class="form-control" type="text" maxlength="254" type="text" name="name[]" value="{#name}">
        <div id="f-port-name-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Введите наименование порта шлюза
            </div>
        </div>
    </div>


    <input type="hidden" name="id[]" value="{#id}">
    <input class="btn btn-success" type="submit" name="save_{#link}" value="Сохранить">
    {if id}<a class="btn btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>