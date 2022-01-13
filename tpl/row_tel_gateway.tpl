{if !ajax}<tr id="row_{#id}">
	{if !edit}<td>{#num}</td><td>{#tel_name}</td>
    {if !edit}<td>{#gateway_port_name}</td>    

    {if !edit}<td class="text-center p-0"><span class="d-flex"><span onclick="editRow('#row_{#id}', {#id}, {#num})" class="edit-btn edit-btn-p" title="Изменить"><i class="fa fa-pencil text-white" aria-hidden="true"></i></span><a class="edit-btn edit-btn-d" href="{#link}/{#id}/del" title="Удалить" onclick="if(!confirm('Элемент удаляется без возможности восстановления! Продолжить?')) return false;"><i class="fa fa-trash text-white" aria-hidden="true"></i></span></td>

    {if edit}<td>{#num}<input type="hidden" value="{#id}" name="id[{#id}]" id="id_{#link}#{#id}">
        {if edit}{part "modules/phone/tpl/chosen_injection.tpl"}
    {if edit}</td>
    {if edit}<td><select type="text" name="id_tel[{#id}]">{#tel_name}</select></td>
    {if edit}<td><select type="text" name="id_port_gateway[{#id}]">{#gateway_port_name}</select></td>
    {if ajax}{if edit}<td class="text-center"><button type="submit" class="btn btn-sm btn-success mr-2" name="save_{#link}">Сохранить</button></td>
{if !ajax}</tr>