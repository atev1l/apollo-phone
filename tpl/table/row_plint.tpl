{if !ajax}<tr>
	{if !edit}<td>{#num}</td><td>{#name}</td><td>{#count_port}</td><td>{#room_name}</td><td class="text-center p-0"><div class="d-flex"><a href="{#link}/{#id}/edit" class="edit-btn edit-btn-p" title="Изменить"><i class="fa fa-pencil text-white" aria-hidden="true"></i></a><a href="{#link}/{#id}/del" class="edit-btn edit-btn-d" title="Удалить" onclick="if(!confirm('Элемент удаляется без возможности восстановления! Продолжить?')) return false;"><i class="fa fa-trash text-white" aria-hidden="true"></i></div></td>
	{if edit}<td>{#num}<input type="hidden" value="{#id}" name="id[{#id}]" id="id_{#link}#{#id}">
	{if edit}{part "modules/phone/tpl/chosen_injection.tpl"}</td>
	{if edit}<td><input type="text" value="{#name}" name="name[{#id}]" id="name_{#link}#{#id}"></td>
	{if edit}<td><input type="number" min="{#count_port}" value="{#count_port}" name="count_port[{#id}]" id="count_port_{#link}#{#id}"></td>
	{if edit}<td><select name="id_room[{#id}]"><option value="0">нет</option>{#room_name}</select></td>
	{if ajax}{if edit}<td class="text-center"><button type="submit" class="btn btn-sm btn-success mr-2" name="save_{#link}">Сохранить</button></td>
{if !ajax}</tr>