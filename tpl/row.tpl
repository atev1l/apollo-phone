<div class="depnametd">
    <div class="d-flex align-items-stretch">
{if admin}<div class="card flex-shrink-1 d-flex align-items-stretch m-1 p-0"><a class="ico-dep d-flex h-100 collapsed" data-toggle="collapse" href="#c{#id}" aria-expanded="true" aria-controls="c{#id}"><i id="ico{#id}" class="far fa-plus-square my-2"></i></a></div>
	  <div class="card d-flex w-100 flex-row align-items-stretch">
		<div class="ckp-item w-100" data-item="{#id}" data-table="{#table}">
		    <a name="{#id}"></a>
		    <div class="d-flex align-items-center row-inner card-header p-0" role="tab" id="h{#id}" style="cursor: pointer;">
			<h6 class="mb-0 w-100 d-flex align-items-center"><div class="row-inner card-header w-100 p-0 collapsed" data-target="#con{#id}" data-toggle="collapse" aria-expanded="true" aria-controls="dc{#id}"><div class="depname pl-1 w-100 p-2 row-inner-ico">{#name}{if keywords}<span class="d-none">{#keywords}</span>{/if}</div></div></h6>
		    </div>
		    <div id="con{#id}" class="ckp-item-content" class="collapse"></div>
		    
{if admin}    <div id="c{#id}" class="collapse" role="tabpanel" aria-labelledby="h{#id}">
{if admin}    		<div class="card-body">
{if admin}    			<div class="list-group list-dep-site">
{if admin}    				<div id="id-e{#id}" class="list-group-item p-0 d-flex align-items-stretch">
{if admin}    					<div class="d-flex align-items-center justify-content-center list-dep-ico"><i class="fas fa-pencil-alt"></i></div>
{if admin}    					<div class="w-100 d-flex align-items-center"><a class="d-flex h-100 w-100 align-items-center pl-2 hover-link" href="/ckp/{#link}/{#id}/edit">Изменить</a></div>
{if admin}    				</div>
{if admin}    				<div id="id-d{#id}" class="list-group-item p-0 d-flex align-items-stretch">
{if admin}    					<div class="d-flex align-items-center justify-content-center list-dep-ico"><i class="fas fa-trash-alt"></i></div>
{if admin}    					<div class="w-100 d-flex align-items-center"><a class="d-flex h-100 w-100 align-items-center pl-2 hover-link" href="/ckp/{#link}/{#id}/del" onclick="return confirm('Запись удаляется без возможности восстановления! Продолжить?')">Удалить</a></div>
{if admin}    				</div>
{if admin}    				<div id="id-f{#id}" class="list-group-item p-0 d-flex align-items-stretch">
{if admin}    					<div class="d-flex align-items-center justify-content-center list-dep-ico"><i class="fa fa-link"></i></div>
{if admin}    					<div class="w-100 d-flex align-items-center"><a class="d-flex h-100 w-100 align-items-center pl-2 hover-link" href="{#url}">{#url}</a></div>
{if admin}    				</div>
{if admin}    				<div id="id-g{#id}" class="list-group-item p-0 d-flex align-items-stretch">
{if admin}    					<div class="d-flex align-items-center justify-content-center list-dep-ico"><i class="fa fa-hashtag"></i></div>
{if admin}    					<div class="w-100 d-flex align-items-center"><a class="d-flex h-100 w-100 align-items-center pl-2 hover-link" href="{#url2}">{#url2}</a></div>
{if admin}    				</div>
{if admin}    			</div>
{if admin}    		</div>
{if admin}    </div>

		</div>
	    </div>
        </div>
</div>


