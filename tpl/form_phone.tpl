<link rel="stylesheet" type="text/css" href="/styles/module_phone.css" />

<a href="/phone/phonebook" class="adm-support-mail d-block p-2 mt-2 mb-2 alert border phonebook">
<h2><i class="fas fa-phone mx-3"></i>Электронный телефонный справочник ПГУ</h2>
</a>

<div class="d-flex">
<div class="col-6 p-0">
<div class="card card-body px-2 py-1 phone_block_device mr-2">
    <h2>Устройства</h2>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-1">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/tel/edit" title="Редактировать телефоны"><i class="fas fa-edit fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" id="phone-1" href="/phone/tel">Телефоны</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-2">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/gateway/add" title="Добавить шлюз"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/gateway">Шлюзы</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-3">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/plint/add" title="Добавить плинт"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/plint">Плинты</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn mb-1" id="phone-4">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/socket/add" title="Добавить розетку"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/socket">Розетки</a>
    </div>
</div>

<div class="card card-body px-2 py-1 mt-2 phone_block_connect mr-2">
    <h2>Связи устройств</h2>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-5">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/tel_gateway/add" title="Добавить связку телефона к портам шлюзов"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/tel_gateway">Связь телефона к портам шлюзов</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-6">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/gateway_plint/add" title="Добавить связку порта шлюза к порту плинта"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/gateway_plint">Связь порта шлюза к порту плинта</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-7">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/plint_port_socket/add" title="Добавить связку порта плинта к розетке"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/plint_port_socket">Связь портов плинтов и розеток</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-8">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/socket_execution/add" title="Добавить связку розетки с пользователем"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/socket_execution">Связь розеток с пользователями</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn" id="phone-9">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/gateway_port/add" title="Добавить связку портов шлюзов и шлюзов"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/gateway_port">Связь портов шлюзов и шлюзов, изменение названий портов</a>
    </div>
    <div class="p-0 d-flex justify-content-between phone-btn mb-1" id="phone-10">
        <a class="btn btn_ico_add d-flex align-items-center justify-content-center" href="/phone/plint_port/add" title="Добавить связку портов плинта и плинтов"><i class="fas fa-plus-circle fa-1x"></i></a><br>
        <a class="btn btn_block_add w-100 d-flex align-items-center" href="/phone/plint_port">Связь портов плинтов и плинтов, изменение названий портов</a>
    </div>
</div>
</div>

<div class="col-6 p-0 d-flex">
    <div class="col-12 card card-body px-2 py-1">
	    <h2>Схема устройства IP-телефонии</h2>
        <img id="phone-shema-img" src="/images/phone/0.png">
	<div id="phone-shema"></div>
    </div>
</div>

</div>

<div class="adm-support-mail p-2 mt-2 alert border">
<span class="m-0 p-0"><b>У вас возникли вопросы по актуальности данных электронного телефонного справочника ПГУ?</b><br />
Обращайтесь в Управление информатизации.<br/><a href="/portfolio/3809867">Заведующий лабораторией Степочкин А.С.</a> ком. 7a-217г, тел. <a class="badge badge-success text-white" href="tel:666-000">666-000</a>,
электронная почта <a class="badge badge-success text-white" href="mailto:stalex82@mail.ru">stalex82@mail.ru</a></span>
</div>


<script>
$('#phone-1').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/1.png");});
$('#phone-2').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/2.png");});
$('#phone-3').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/3.png");});
$('#phone-4').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/4.png");});
$('#phone-5').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/5.png");});
$('#phone-6').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/6.png");});
$('#phone-7').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/7.png");});
$('#phone-8').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/8.png");});
$('#phone-9').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/2.png");});
$('#phone-10').mouseover(function(){	$("#phone-shema-img").attr("src","/images/phone/3.png");});
$('#phone-1').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-2').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-3').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-4').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-5').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-6').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-7').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-8').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-9').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
$('#phone-10').on('mouseleave', function() {$('#phone-shema-img').attr('src', "/images/phone/0.png")})
</script>
