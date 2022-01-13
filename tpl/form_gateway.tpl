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
        <div href="#f-gw-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-gw-c">
            <div class="input-group-text input-hover-c w-100" for="f-gw">
                <i class="fas fa-server mr-2"></i>
                <label class="mb-0">Шлюз</label>
            </div>
        </div>
        <input id="f-gw" class="form-control" type="text" maxlength="254" type="text" name="name" value="{#name}">
        <div id="f-gw-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Наименование шлюза (gateway), пример для 7 корпуса - 7/1(7 Корпус)
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-ip-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-ip-c">
            <div class="input-group-text input-hover-c w-100" for="f-ip">
                <i class="fas fa-network-wired mr-2"></i>
                <label class="mb-0">IP (ПГУ)</label>
            </div>
        </div>
        <input id="f-ip" class="form-control" type="text" maxlength="254" type="text" name="ip" value="{#ip}" >
        <div id="f-ip-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Укажите IP-адрес (ПГУ) в формате XXX.XX.XXX.XXX, пример для 7 корпуса - 172.16.207.133
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-ip-out-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-ip-out-c">
            <div class="input-group-text input-hover-c w-100" for="f-ip-out">
                <i class="fas fa-network-wired mr-2"></i>
                <label class="mb-0">IP (МТС)</label>
            </div>
        </div>
        <input id="f-ip-out" class="form-control" type="text" maxlength="254" type="text" name="ip_out" value="{#ip_out}">
        <div id="f-ip-out-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Укажите IP-адрес (МТС) в формате XX.XXX.XXX.XX, пример для 7 корпуса - 10.107.100.3
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-count-port-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-count-port-c">
            <div class="input-group-text input-hover-c w-100" for="f-ip-out">
                <i class="fas fa-ethernet mr-2"></i>
                <label class="mb-0">Количество портов</label>
            </div>
        </div>
        <input id="f-count-port" class="form-control" type="number" min="{#count_port}" step="1" name="count_port" value="{#count_port}">
        <div id="f-count-port-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Укажите количество портов шлюза, 16, 24 или 32.
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-room-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-room-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-room">
                <i class="fas fa-door-open mr-2"></i>
                <label class="mb-0">Аудитория</label>
            </div>
        </div>
        <select id="f-id-room" class="form-control" type="text" name="id_room">
            <option value="0" title="">нет</option>
            {#roomList}
        </select>
        <div id="f-id-room-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите аудиторию, в которой установлен шлюз
            </div>
        </div>
    </div>


    {if id}<input type="hidden" name="id" value="{#id}">
    <button class="btn btn-sm btn-success my-2" type="submit" name="save_{#link}"><i class="fas fa-save mr-2"></i>Сохранить</button>
    {if id}<a class="btn btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>