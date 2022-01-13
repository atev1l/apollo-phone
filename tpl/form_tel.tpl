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

<form action="/phone/{#link}/{#id}" method="post" class="p-edit" >
    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-number-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-number-c">
            <div class="input-group-text input-hover-c w-100" for="f-number">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Номер телефона</label>
            </div>
        </div>
        <input id="f-number" class="form-control" type="text" maxlength="254" type="text" name="number" value="{#number}">
        <div id="f-number-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Номер телефона
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-inner-number-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-inner-number-c">
            <div class="input-group-text input-hover-c w-100" for="f-inner-number">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Номер телефона (внутренний)</label>
            </div>
        </div>
        <input id="f-inner-number" class="form-control" type="text" maxlength="254" type="text" name="inner_number" value="{#inner_number}">
        <div id="f-inner-number-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Внутренний номер телефона в ПГУ
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-cell-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-cell-c">
            <div class="input-group-text input-hover-c w-100" for="f-cell">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Выход на сотовую связь</label>
            </div>
        </div>
        <input id="f-cell" class="form-control" type="checkbox" name="is_cell" {if is_cell} checked {/if}>
        <div id="f-cell-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Отметьте, если необходим выход на сотовую связь
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-intercity-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-intercity-c">
            <div class="input-group-text input-hover-c w-100" for="f-intercity">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Выход на межгород</label>
            </div>
        </div>
        <input id="f-intercity" class="form-control" type="checkbox" name="is_intercity" {if is_intercity} checked {/if}>
        <div id="f-intercity-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Отметьте, если необходим выход на междугороднюю связь
            </div>
        </div>
    </div>

    <div class="input-group input-group-sm margin-bottom-sm my-1">
        <div href="#f-hidden-c" class="input-group-prepend w-25" data-toggle="collapse" aria-expanded="false" aria-controls="f-hidden-c">
            <div class="input-group-text input-hover-c w-100" for="f-hidden">
                <i class="fas fa-heading mr-2"></i>
                <label class="mb-0">Скрыть</label>
            </div>
        </div>
        <input id="f-hidden" class="form-control" type="checkbox" name="is_hidden" {if is_hidden} checked {/if}>
        <div id="f-hidden-c" class="collapse mt-1 w-100">
            <div class="card p-2">
                Отметьте, если необходимо скрыть номер телефона из общего списка отображения (например, для многоканальных телефонов)
            </div>
        </div>
    </div>





    {if id}<input type="hidden" name="id" value="{#id}">
    <input class="btn btn-success" type="submit" name="save_{#link}" value="Сохранить">
    {if id}<a class="btn btn-danger" href="/phone/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a>
</form>