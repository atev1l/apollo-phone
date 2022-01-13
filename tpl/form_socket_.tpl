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
    });

    function selectRoom(val) {
        //alert(val);
        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/ajax/phone/",
            data: "selectRoom="+val+"&link={#link}",
            success: function (response) {
                if (response) {
                    $("#tableBody").html(response.table);
                } else {

                }
            },
            error: function (xhr, str) {
                console.log("ERROR ");
                console.log(xhr);
            }
        });
    }
</script>

<form action="/phone/{#link}/{#id}" method="post" class="p-edit" >
    {if ajax}<div class="input-group input-group-sm margin-bottom-sm my-1">
        {if ajax}<div href="#f-id-port-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-port-c">
            {if ajax}<div class="input-group-text input-hover-c w-100" for="f-id-port">
                {if ajax}<i class="fas fa-clipboard-list mr-2"></i>
                {if ajax}<label class="mb-0">Порт плинта</label>
                {if ajax}</div>
            {if ajax}</div>
        {if ajax}<select id="f-id-port" class="form-control" type="text" name="id_port_plint">
            {if ajax}<option value="0" title="">нет</option>
            {if ajax}{#plint_port_name}
            {if ajax}</select>
        {if ajax}<div id="f-id-port-c" class="collapse mt-1 w-100">
            {if ajax}<div class="card p-2">Выберите порт плинта, к которому необходимо подключить розетка</div>
            {if ajax}</div>
        {if ajax}</div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-socket-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-socket-c">
            <div class="input-group-text input-hover-c w-100" for="f-socket">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Розетка</label>
            </div>
        </div>
        <input id="f-socket" class="form-control" type="text" maxlength="254" type="text" name="name" value="{#name}">
        <div id="f-socket-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Наименование розетки
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
        <select id="f-id-room" class="form-control" type="text" name="id_room" onchange="selectRoom($(this).val())">
            <option value="0" title="">нет</option>
            {#room_name}
        </select>
        <input type="text" name="name_room">
        <div id="f-id-room-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Выберите аудиторию, в которой установлена розетка
            </div>
        </div>
    </div>


    {if id}<input type="hidden" name="id" value="{#id}">
    {if save_from_ajax}<input type="hidden" name="save_from_ajax" value="{#save_from_ajax}">
    <input class="btn btn-sm btn-success" type="submit" name="save_{#link}" value="Сохранить">
    {if id}<a class="btn btn-sm btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>