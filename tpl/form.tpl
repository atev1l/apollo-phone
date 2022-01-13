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
    })
</script>
<script type="text/javascript" src="/core/lib/fckeditor/fckeditor.js"></script>

<form action="/phone/{#link}/{#id}" method="post" class="p-edit" >
    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-name-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-name-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-name">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Название</label>
            </div>
        </div>
        <input id="f-name" class="form-control" type="text" maxlength="254" type="text" name="name" value="{#name}">
        <div id="f-id-name-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Наименование оборудования.<br>{if name} URL: <a href="/ckp/{#id}">{#url}</a><br>URL: <a href="/ckp#{#id}">{#url2}</a> {/if}
            </div>
        </div>
    </div>
    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-id-type-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-type-c">
            <div class="input-group-text input-hover-c w-100" for="f-id-type">
                <i class="fas fa-clipboard-list mr-2"></i>
                <label class="mb-0">Тип</label>
            </div>
        </div>
        <select id="f-id-type" class="form-control" type="text" name="id_type">
            <option value="0" title="">нет</option>
            {#itemList}
        </select>
        <div id="f-id-type-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Тип.
            </div>
        </div>
    </div>
    {if !device}<div class="input-group input-group-sm margin-bottom-sm my-1">
        {if !device}<div href="#f-id-device-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-device-c">
            {if !device}<div class="input-group-text input-hover-c w-100" for="f-id-device">
                {if !device}<i class="fas fa-clipboard-list mr-2"></i>
                {if !device}<label class="mb-0">Тип оборудования</label>
        {if !device}</div>
        {if !device}</div>
        {if !device}<select id="f-id-device" class="form-control" type="text" name="id_device">
            {if !device}<option value="0" title="">нет</option>
            {if !device}{#deviceList}
        {if !device}</select>
        {if !device}<div id="f-id-device-c" class="collapse mt-1 w-100">
            {if !device}<div class="card p-2">Тип оборудования.</div>
        {if !device}</div>
    {if !device}</div>
    {if !service}<div class="input-group input-group-sm margin-bottom-sm my-1">
        {if !service}<div href="#f-id-service-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-service-c">
            {if !service}<div class="input-group-text input-hover-c w-100" for="f-id-service">
                {if !service}<i class="fas fa-clipboard-list mr-2"></i>
                {if !service}<label class="mb-0">Тип услуги</label>
            {if !service}</div>
        {if !service}</div>
        {if !service}<select id="f-id-service" class="form-control" type="text" name="id_service">
            {if !service}<option value="0" title="">нет</option>
            {if !service}{#serviceList}
        {if !service}</select>
        {if !service}<div id="f-id-service-c" class="collapse mt-1 w-100">
            {if !service}<div class="card p-2">Тип услуги.</div>
        {if !service}</div>
    {if !service}</div>
    {if !method}<div class="input-group input-group-sm margin-bottom-sm my-1">
        {if !method}<div href="#f-id-method-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-id-method-c">
            {if !method}<div class="input-group-text input-hover-c w-100" for="f-id-method">
                {if !method}<i class="fas fa-clipboard-list mr-2"></i>
                {if !method}<label class="mb-0">Тип методики</label>
            {if !method}</div>
        {if !method}</div>
        {if !method}<select id="f-id-method" class="form-control" type="text" name="id_method">
            {if !method}<option value="0" title="">нет</option>
            {if !method}{#methodList}
        {if !method}</select>
        {if !method}<div id="f-id-method-c" class="collapse mt-1 w-100">
            {if !method}<div class="card p-2">Тип методики.</div>
        {if !method}</div>
    {if !method}</div>
    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-keywords-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-keywords-c">
		<span class="input-group-text input-hover-c w-100" for="f-keywords">
		    <i class="fas fa-tags mr-2"></i>
		    <label class="mb-0">Ключевые слова</label>
		 </span>
        </div>
        <textarea id="f-keywords" class="form-control" rows="5" cols="90" name="keywords"/>{#keywords}</textarea>
        <div id="f-keywords-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Ключевые слова. Необходимо для поиска, указываются через запятую.
            </div>
        </div>
    </div>
    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-content-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-content-c">
            <div class="input-group-text input-hover-c w-100" for="f-content">
                <i class="fas fa-align-left mr-2"></i>
                <label class="mb-0">Содержимое</label>
            </div>
        </div>
        <textarea id="f-content" class="form-control" rows="25" cols="190" name="content" id="content"/>{#content}</textarea>
        <div id="f-content-c" class="collapse mt-1 w-100">
            <div class="card p-2">

            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-comment-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-comment-c">
            <div class="input-group-text input-hover-c w-100" for="f-comment">
                <i class="fas fa-align-left mr-2"></i>
                <label class="mb-0">Комментарии</label>
            </div>
        </div>
        <textarea id="f-comment" class="form-control" rows="5" cols="90" name="comment" />{#comment}</textarea>
        <div id="f-comment-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Техническое поле для дополнительных замечаний
            </div>
        </div>
    </div>

    {if id}<input type="hidden" name="id" value="{#id}">
    {if id}<input type="hidden" name="is_check_keywords" value="{#is_check_keywords}">
    <input class="btn btn-success" type="submit" name="save" value="Сохранить">
    {if id}<a class="btn btn-danger" href="/ckp/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>

<script type="text/javascript">
    var sBasePath = '/core/lib/fckeditor/';
    var sSkinPath = sBasePath + 'editor/skins/office2003/' ;
    var oFCKeditor = new FCKeditor( 'content' ) ;
    oFCKeditor.BasePath	= sBasePath ;
    oFCKeditor.Height	= 600 ;
    oFCKeditor.Config['SkinPath'] = sSkinPath ;
    oFCKeditor.Config['PreloadImages'] =
        sSkinPath + 'images/toolbar.start.gif' + ';' +
        sSkinPath + 'images/toolbar.end.gif' + ';' +
        sSkinPath + 'images/toolbar.bg.gif' + ';' +
        sSkinPath + 'images/toolbar.buttonarrow.gif' ;

    oFCKeditor.ToolbarSet	= 'PNews' ;
    oFCKeditor.ReplaceTextarea() ;
</script>