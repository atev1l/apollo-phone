<link rel="stylesheet" type="text/css" href="/styles/module_phone.css">

<table class="table table-striped table-bordered" id="mainPhoneTable">
<thead>
{if tel}<tr class="ispguth"><th>№</th><th>Номер телефона</th><th>Внутренний номер</th><th>Выход на сотовую связь</th><th>Выход на межгород</th>{if !edit}<th></th>{/if}{if tel}</tr>
{if gateway}<tr class="ispguth"><th>№</th><th>Название</th><th>IP (ПГУ)</th><th>IP (МТС)</th><th>Количество портов</th><th>Аудитория</th>{if !edit}<th></th>{/if}{if gateway}</tr>
{if plint}<tr class="ispguth"><th>№</th><th>Название</th><th>Количество портов</th><th>Аудитория</th>{if !edit}<th></th>{/if}{if plint}</tr>
{if socket}<tr class="ispguth"><th>№</th><th>Название</th><th>Аудитория</th>{if !edit}<th></th>{/if}{if socket}</tr>
{if tel_gateway}<tr class="ispguth"><th>№</th><th>Телефон</th><th>Порт шлюза</th>{if !edit}<th></th>{/if}{if tel_gateway}</tr>
{if gateway_plint}<tr class="ispguth"><th>№</th><th>Порт шлюза<br>Шлюз / Порт [Телефон]</th><th>Порт плинта<br>Плинт / Порт [Розетка / Комната]</th>{if !edit}<th></th>{/if}{if gateway_plint}</tr>
{if gateway_port}<tr class="ispguth"><th>№</th><th>Шлюз</th><th>Порт шлюза</th>{if !edit}<th></th>{/if}{if gateway_port}</tr>
{if plint_port}<tr class="ispguth"><th>№</th><th>Плинт</th><th>Порт плинта</th>{if !edit}<th></th>{/if}{if plint_port}</tr>
{if plint_port_socket}<tr class="ispguth"><th>№</th><th>Плинт</th><th>Розетка</th><th>Аудитория</th>{if !edit}<th></th>{/if}{if plint_port_socket}</tr>
{if socket_execution}<tr class="ispguth"><th>№</th><th>Розетка</th><th>Сотрудник</th>{if !edit}<th></th>{/if}{if socket_execution}</tr>
</thead>

<tbody>
    {#rows}
</tbody>
</table>