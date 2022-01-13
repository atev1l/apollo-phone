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
        <div href="#f-id-tel-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-tel-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-tel">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Номер телефона</label>
            </div>
        </div>
        <select id="f-id-tel" class="form-control" type="text" name="id_tel[]">
            <option value="0" title="">нет</option>
            {#tel_name}
        </select>
        <div id="f-id-tel-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите номер телефона, который хотите привязать к порту шлюза
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-port-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-port-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-port">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Порт шлюза</label>
            </div>
        </div>
        <select id="f-id-port" class="form-control" type="text" name="id_port_gateway[]">
            <option value="0" title="">нет</option>
            {#gateway_port_name}
        </select>
        <div id="f-id-port-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите порт шлюза, к которому хотите привязать номер телефона
            </div>
        </div>
    </div>

    <input type="hidden" name="id[]" value="{#id}">
    <input class="btn btn-success" type="submit" name="save_{#link}" value="Сохранить">
    {if id}<a class="btn btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>