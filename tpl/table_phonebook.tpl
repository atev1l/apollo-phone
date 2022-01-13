<script type="text/javascript" src="/scripts/components/datatables/datatables-ru.js"></script>
<script type="text/javascript" charset="utf8" src="/scripts/components/datatables/datatables.min.js"></script>

<script type="text/javascript" src="/js/datatables-bootstrap4/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="/js/datatables-bootstrap4/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="/js/datatables-bootstrap4/Responsive-2.2.2/js/responsive.bootstrap4.min.js"></script>

<link rel="stylesheet" href="/scripts/components/datatables/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="/styles/module_phone.css" />

<div class="phonebook-page">
    <div class="phonebook-edit-wrapper">
        <div class="{if admin}phonebook-edit{/if}{if !admin}phonebook-edit-notadm{/if}">
            {if admin}<a href="/phone" class="badge badge-primary">Редактировать справочник</a>{/if}<span class="badge badge-primary ml-3" id="phonebook-size">Минимизировать таблицу</span><span class="badge badge-primary ml-3" id="phonebook-size2">Полный вид</span>
        </div>
    </div>

    <table id="phonebook" class="table dataTable no-footer dt-responsive" style="width: 100%;">
        <thead>
        <tr>
            <th>Телефон</th>
            <th>Фото</th>
            <th>Сотрудник</th>
            <th>Подразделение</th>
            <th>Аудитория{if admin}/розетка{/if}</th>
            <th>IP шлюза/порт</th>
            <th>Плинт</th>
            <th>ID</th>
            <th>is_hidden</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    tables_lang = {
        "decimal": ",",
        "thousands": " ",
        "lengthMenu": "Показывать _MENU_ записей",
        "zeroRecords": "Значение не найдено",
        "info": "Страница _PAGE_ из _PAGES_",
        "infoFiltered": "(найдено из _MAX_ записей)",
        "emptyTable": "Нет записей",
        "info": "Загружено _START_ - _END_ из _TOTAL_ записей",
        "infoEmpty": "Показано 0 из 0 записей",
        "infoPostFix": "",
        "loadingRecords": "Загрузка...",
        "processing": "Обработка...",
        "search": "Поиск:",
        "paginate": {
            "first": "Первая",
            "last": "Последняя",
            "next": "Следующая",
            "previous": "Предыдущая"
        },
        "aria": {
            "sortAscending": ": сортировать по возрастанию",
            "sortDescending": ": сортировать по убыванию"
        }
    };


    $(document).ready(function()  {
        var table = $('#phonebook').DataTable(
            {

                "serverSide": true,
                "processing": true,
                "ajax": '/ajax/phone/dataPhoneBook',
                "data": JSON,

                "columns": [
                    { "id": "2", "data": "Телефон" , "width":"0.3%" },
                    { "id": "1", "data": "Фото" , "width":"0.1%" },
                    { "id": "0", "data": "Сотрудник" , "width":"15.5%" },
                    { "id": "3", "data": "Подразделение" , "width":"16.5%" },
                    { "id": "4", "data": "Аудитория/розетка" , "width":"10%" },
                    { "id": "5", "data": "IP шлюза/порт" , "width":"10%" },
                    { "id": "6", "data": "Плинт" , "width":"10%" },
                    { "id": "7", "data": "ID" , "width":"10%" },
                    { "id": "8", "data": "is_hidden" , "width":"10%" },

                ],

                language: tables_lang,
                pageLength: 25,
                orderCellsTop: true,
                fixedHeader: true,
                order: [[2, 'asc']],
                "rowCallback": function( row, data ) {
                    if (data.is_hidden === "1") {
                        $('td', row ).addClass( "bg-secondary text-white d-none{if admin}d-block{/if}" );
                    }
                }

            });


        // делает поле поиска под каждым столбцом
        // $('#audience thead tr').clone(true).appendTo( '#audience thead' );
        // $('#audience thead tr:eq(1) th').each( function (i) {
        //     var title = $(this).text();
        //     $(this).html( '<input type="text" id="search" name="search" placeholder="Поиск" />' );
        //
        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( table.column(i).search() !== this.value ) {
        //             table
        //                 .column(i)
        //                 .search( this.value )
        //                 .draw();
        //         }
        //     } );
        // } );


        table.state.clear();
        table.draw();
        {if !admin}table.columns( [5,6,7] ).visible( false );{/if}
        table.columns( [8] ).visible( false );

    });

    $("#phonebook-size").click(function(e) {
        e.preventDefault();
        $("#phonebook").addClass('table-sm table-bordered');
        $("#phonebook-size").addClass('table-sm table-bordered');
    })

    $("#phonebook-size2").click(function(e) {
        e.preventDefault();
        $("#phonebook").removeClass('table-sm table-bordered');
        $("#phonebook-size2").addClass('badge-danger');
    })
</script>
