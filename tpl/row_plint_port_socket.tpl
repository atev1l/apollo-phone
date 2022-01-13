{if !ajax}<tr id="row_{#id}">
	{if !edit}<td>{#num}</td>
    {if !edit}<td ondblclick="editField({#id}, 'id_port_plint', '{#id_port_plint}', $(this))" id="td_port_plint{#id}">{#plint_port_name}</td>
    {if !edit}<td ondblclick="editField({#id}, 'name', '{#socket_name}', $(this))" id="td_socket_name{#id}">{#socket_name}</td>
    {if !edit}<td><a href="{#link}/id_room/{#id_room}">{#room_name}</a></td>

    {if !edit}<td class="text-center p-0"><span class="d-flex"><span onclick="editRow('#row_{#id}', {#id}, {#num})" class="edit-btn edit-btn-p" title="Изменить"><i class="fa fa-pencil text-white" aria-hidden="true"></i></span><a class="edit-btn edit-btn-d" href="{#link}/{#id}/del" title="Удалить" onclick="if(!confirm('Элемент удаляется без возможности восстановления! Продолжить?')) return false;"><i class="fa fa-trash text-white" aria-hidden="true"></i></span></td>

	{if edit}<td>{#num}<input type="hidden" value="{#id}" name="id[{#id}]" id="id_{#link}#{#id}">
        {if edit}{part "modules/phone/tpl/chosen_injection.tpl"}
    {if edit}</td>
    {if edit}<td><select name="id_port_plint[{#id}]">{#plint_port_name}</select></td>
    {if edit}<td><select name="id_socket[{#id}]">{#socket_name}</select></td>
    {if edit}<td>{#room_name}</td>
    {if ajax}{if edit}<td class="text-center"><button type="submit" class="btn btn-sm btn-success mr-2" name="save_{#link}">Сохранить</button></td>
{if !ajax}</tr>