<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<link href="/js/bootstrap-4-chosen/dist/css/component-chosen.css" rel="stylesheet">

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
    .chosen-container{
        height: calc(1.8125rem + 2px);
    }
    .chosen-drop {
        overflow: hidden;
    }

</style>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
<form action="/phone/{#link}/{#id}" method="post" class="p-edit" >
    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-port-pl-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-port-pl-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-port-pl">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Порт плинта</label>
            </div>
        </div>
        <select id="f-id-port-pl" class="form-control" type="text" name="id_port_plint[]">
            <option value="0" title="">нет</option>
            {#plint_port_name}
        </select>
        <div id="f-id-port-pl-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите порт плинта, который необходимо привязать к розетке
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-socket-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-socket-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-socket">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Розетка</label>
            </div>
        </div>
        <select id="f-id-socket" class="form-control" type="text" name="id_socket[]">
            <option value="0" title="">нет</option>
            {#socket_name}
        </select>
        <div id="f-id-socket-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите розетку, которую необходимо привязать к порту плинта. Возможен множественный выбор.
            </div>
        </div>
    </div>


    <input type="hidden" name="id[]" value="{#id}">
    <input class="btn btn-success" type="submit" name="save_{#link}" value="Сохранить">
    {if id}<a class="btn btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>

