<script type="text/javascript" src="/scripts/components/datatables/datatables-ru.js"></script>
<script type="text/javascript" charset="utf8" src="/scripts/components/datatables/datatables.min.js"></script>

<script type="text/javascript" src="/js/datatables-bootstrap4/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="/js/datatables-bootstrap4/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="/js/datatables-bootstrap4/Responsive-2.2.2/js/responsive.bootstrap4.min.js"></script>

<link rel="stylesheet" href="/scripts/components/datatables/datatables.min.css"/>

<script>
    $(document).ready(function() {
        $("#mainPhoneTable").DataTable({
            language: tables_lang,
	    "pageLength": 25
        });
        //let str = "plint_port_name={#plint_port_name}";
        $('.add-item').on('click', function () {
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                url: "/ajax/phone/",
                data: "editform=1&link={#link}",
                success: function (response) {
                    if (response) {
                        $('.edit-form').html(response.form);
                    } else {

                    }
                },
                error: function (xhr, str) {
                    console.log(xhr);
                }
            });
        });
        $('.add-socket').on('click', function () {
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                url: "/ajax/phone/",
                data: "editform=1&link={#link}&add-socket=1",
                success: function (response) {
                    if (response) {
                        $('#added').html(response.form);
                    } else {

                    }
                },
                error: function (xhr, str) {
                    console.log(xhr);
                }
            });
        });
    });
    function editField(id = 0, par = 0, sel = 0, e = 0) {
        let elem = '#'+par+''+id;
        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/ajax/phone/",
            data: "editfield="+par+"&id="+id+"&link={#link}&selected="+sel,
            success: function (response) {
                if (response) {
                    $(e).html(response.content);
                } else {

                }
            },
            error: function (xhr, str) {
                console.log(xhr);
            }
        });
    }
    function editRow(row = 0, id = 0, num =0 ) {
        //let elem = '#'+par+''+id;
        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/ajax/phone/",
            data: "editrow="+row+"&id="+id+"&link={#link}&num="+num,
            success: function (response) {
                if (response) {
                    $(row).html(response.form);
                } else {

                }
            },
            error: function (xhr, str) {
                console.log(xhr);
            }
        });
    }
</script>

<style>

.btn:hover, .page-link:hover {
    text-decoration: none !important;
}

.form-control-sm, .page-item:first-child .page-link, .page-item:last-child .page-link {
    border-radius: 0;
}

.table thead th {
    border-bottom: 1px solid #dee2e6 !important;
}

.table.dataTable, table.dataTable {
    border-collapse: collapse !important;
}

.table select {
    min-height: 27px;
    width: 100%;
    margin: -2px;
    width: calc(100% + 4px);
    padding: 3px 0;
    border: 1px solid #adadad;
}

.pagination {
    list-style-type: none !important;
}

.page-item.active .page-link {
    background-color: #3f3c4e;
    border-color: #302e39;
}

.page-link:hover {
    color: #000;
    background: #eee;
}

#mainPhoneTable_info, #mainPhoneTable_paginate {
    margin-top: .4rem !important;
}

.page-link {
    padding: .4rem .7rem;
}

#mainPhoneTable tbody td, #mainPhoneTable thead th {
  vertical-align: middle;
}

.btn-save-custom {
    margin: 0px 0px -2px -2px;
    width: calc(100% + 4px);
    padding: 3px;
}

.edit-th {
    width: 80px !important;
    min-width: 80px;
}

.edit-btn {
    padding: 3px 16px;
    margin: 1px;
    width: calc(50% + 10px);
    height: 24px;
}

.edit-btn:hover {
    opacity: 0.5;
}

.edit-btn-p {
    background: #3f3c4e;
}

.edit-btn-d {
    background: #974242;
}

</style>


<div id="added"></div>

<form action="/phone/{#link}" method="post" enctype="multipart/form-data">
    <div class="d-flex justify-content-begin mt-2 mb-2">
        <a class="btn btn-sm mr-1" href="/phone"><i class="fas fa-chevron-left mr-2"></i>В начало</a>
        {if !edit}<a class="btn btn-sm mr-1 btn-primary text-white" href="/phone/{#link}/edit"><i class="fas fa-edit mr-2"></i>Изменить все</a>
        {if edit}<a class="btn btn-sm mr-1" href="/phone/{#link}"><i class="fas fa-th-list mr-2"></i>Вернуться к списку</a>
        <a class="btn btn-sm btn-primary mr-1 text-white" href="/phone/{#link}/add"><i class="fas fa-window-restore mr-2"></i>Добавить в новом окне</a>
        {if !edit}{if !socket_execution}<button type="button" class="btn btn-sm btn-primary mr-1 add-item"><i class="fas fa-table mr-2"></i>Добавить в таблицу</button>
        {if !edit}{if plint_port_socket}<button type="button" class="btn btn-sm btn-primary mr-1 add-socket"><i class="fas fa-plug mr-2"></i>Добавить розетку</button>
        {if edit}<button class="btn btn-sm btn-success mr-1" type="submit" name="save_{#link}"><i class="fas fa-save mr-2"></i>Сохранить</button>
    </div>
    <div id="tableBody">
        <table class="table table-striped table-bordered table-sm" id="mainPhoneTable">
            <thead>
            {if tel}<tr class="ispguth"><th>№</th><th>Номер телефона</th><th>Внутренний номер</th><th>Выход на сотовую связь</th><th>Выход на межгород</th>{if !edit}<th class="edit-th"></th>{/if}{if tel}</tr>
            {if gateway}<tr class="ispguth"><th>№</th><th>Название</th><th>IP (ПГУ)</th><th>IP (МТС)</th><th>Количество портов</th><th>Аудитория</th>{if !edit}<th class="edit-th"></th>{/if}{if gateway}</tr>
            {if plint}<tr class="ispguth"><th>№</th><th>Название</th><th>Количество портов</th><th>Аудитория</th>{if !edit}<th class="edit-th"></th>{/if}{if plint}</tr>
            {if socket}<tr class="ispguth"><th>№</th><th>Название</th><th>Аудитория</th>{if !edit}<th class="edit-th"></th>{/if}{if socket}</tr>
            {if tel_gateway}<tr class="ispguth"><th>№</th><th>Телефон</th><th>Шлюз / Порт</th>{if !edit}<th class="edit-th"></th>{/if}{if tel_gateway}</tr>
            {if gateway_plint}<tr class="ispguth"><th>№</th><th>Порт шлюза<br>Шлюз / Порт [Телефон]</th><th>Порт плинта<br>Плинт / Порт [Розетка / Комната]</th>{if !edit}<th class="edit-th"></th>{/if}{if gateway_plint}</tr>
            {if gateway_port}<tr class="ispguth"><th>№</th><th>Шлюз</th><th>Порт шлюза</th>{if !edit}<th class="edit-th"></th>{/if}{if gateway_port}</tr>
            {if plint_port}<tr class="ispguth"><th>№</th><th>Плинт</th><th>Порт плинта</th>{if !edit}<th class="edit-th"></th>{/if}{if plint_port}</tr>
            {if plint_port_socket}<tr class="ispguth"><th>№</th><th>Плинт</th><th>Розетка</th><th>Аудитория</th>{if !edit}<th class="edit-th"></th>{/if}{if plint_port_socket}</tr>
            {if socket_execution}<tr class="ispguth"><th>№</th><th>Розетка</th><th>Сотрудник</th>{if !edit}<th class="edit-th"></th>{/if}{if socket_execution}</tr>
            </thead>

            <tbody>
                <tr class="edit-form no-sort">
                {if tel}<th></th><th></th><th></th><th></th><th></th>{if !edit}<th></th>
                {if gateway}<th></th><th></th><th></th><th></th><th></th><th></th>{if !edit}<th></th>
                {if plint}<th></th><th></th><th></th><th></th>{if !edit}<th></th>
                {if socket}<th></th><th></th><th></th>{if !edit}<th></th>
                {if tel_gateway}<th></th><th></th><th></th>{if !edit}<th></th>
                {if gateway_plint}<th></th><th></th><th></th>{if !edit}<th></th>
                {if gateway_port}<th></th><th></th><th></th>{if !edit}<th></th>
                {if plint_port}<th></th><th></th><th></th>{if !edit}<th></th>
                {if plint_port_socket}<th></th><th></th><th></th><th></th>{if !edit}<th></th>
                {if socket_execution}<th></th><th></th><th></th>{if !edit}<th></th>
                </tr>
                {#rows}
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-begin">
        {if !edit}<a class="btn btn-sm btn-primary mr-2 text-white" href="/phone/{#link}/edit"><i class="fas fa-edit mr-2"></i>Изменить все</a>
        <a class="btn btn-sm btn-primary mr-2 text-white" href="/phone/{#link}/add"><i class="fas fa-window-restore mr-2"></i>Добавить в новом окне</a>
        {if edit}<button class="btn btn-sm btn-success mr-2" type="submit" name="save_{#link}"><i class="fas fa-save mr-2"></i>Сохранить</button>
    </div>
</form>