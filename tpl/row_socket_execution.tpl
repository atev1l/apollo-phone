<tr>
	{if !edit}<td>{#num}</td><td>{#socket_name}</td><td>{if id_user}<a href="/portfolio/{#id_user}" target="_blank">{/if}{if !edit}{#user_name}{if id_user}</a>{/if}{if !edit}</td><td class="text-center p-0"><div class="d-flex"><a href="{#link}/{#id}/edit" class="edit-btn edit-btn-p" title="Изменить"><i class="fa fa-pencil text-white" aria-hidden="true"></i></a><a href="{#link}/{#id}/del" class="edit-btn edit-btn-d" title="Удалить" onclick="if(!confirm('Элемент удаляется без возможности восстановления! Продолжить?')) return false;"><i class="fa fa-trash text-white" aria-hidden="true"></i></div></td>
	{if edit}<td>{#num}<input type="hidden" value="{#id}" name="id[{#id}]" id="id_{#link}#{#id}"></td><td><select type="text" name="id_socket[{#id}]">{#socket_name}</select></td><td><input type="text" value="{#user_name}" name="name[{#id}]" id="name_{#link}#{#id}"></td>
</tr>