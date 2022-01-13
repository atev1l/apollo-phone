<tr {if is_hidden}class="bg-secondary text-white" title="Номер скрыт"{/if}>
    <td>{#number1}{if inner_number}<br/><span class="text-secondary badge pl-0">{#inner_number}</span>{/if}<span style="display: none;">{#number}</span></td>
    <td>{if is_photo}<a href="https://lk.pnzgu.ru/portfolio/{#id_user}" target="_blank" class="phonebook-photo" style="background: url('https://lk.pnzgu.ru/files/lk/photo/a_{#id_user}.jpg') no-repeat;"></a>{/if}</td>
    <td>{if user_name}<a href="https://lk.pnzgu.ru/portfolio/{#id_user}" target="_blank"><b>{#user_name}</b></a><br/>{#position_name}<i class="ico_username fas fa-external-link-alt ml-1"></i>{/if}</td>
    <td>{#dep_name}</td><td>{#room_name}{if admin}{if socket_name} / {#socket_name}{/if}</td>
    {if admin}<td>{#ip_out} / {#gateway_port_name}<br/><span class="text-secondary badge pl-0">{#gateway_name}</span><br/><span class="text-secondary badge pl-0">{#gateway_room_name}</span></td>
    {if admin}<td>{#plint_name} / {#plint_port_name}</td>
    {if admin}<td>{#id_socket_execution}</td>{/if}
</tr>