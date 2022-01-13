<div class="modal fade" id="{#link}" tabindex="-1" role="dialog" aria-labelledby="{#link}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formGateway">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="{#link}">Шлюз</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="f-gw" class="col-form-label">Наименование шлюза:</label>
                        <input id="f-gw" class="form-control" type="text" maxlength="254" type="text" name="gateway" value="{#name}">
                        <label for="f-ip" class="col-form-label">IP (ПГУ):</label>
                        <input id="f-ip" class="form-control" type="text" maxlength="254" type="text" name="ip" value="{#ip}" >
                        <label for="f-ip-out" class="col-form-label">IP (МТС):</label>
                        <input id="f-ip-out" class="form-control" type="text" maxlength="254" type="text" name="ip-out" value="{#ip_out}">
                        <label for="f-count-port" class="col-form-label">Количество портов:</label>
                        <input id="f-count-port" class="form-control" type="number" min="1" step="1" name="count-port" value="{#count_port}">
                        <label for="f-id-room" class="col-form-label">Аудитория:</label>
                        <select id="f-id-room" class="form-control" type="text" name="id_room">
                            <option value="0" title="">нет</option>
                            {#roomList}
                        </select>
                    </div>
                    <input type="hidden" name="id" class="id" value="{#id}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-danger" name="saveGateway">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>