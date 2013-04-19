<form id="registerForm">
<div id="register">
  <div class="row">
    <div class="column six centered">
      <div class="singlebox-margin">
        <h3 class="color text-center">Я хочу:</h3>
        <ul class="form-list">
          <li id="self" class="toggle-box onlyOpen">
          <a href="javascript:;" class="radio-link choice">
            <i class="large"></i>
            Установить Корпоративные сервисы для собственных нужд
          </a>
          </li>
          <li id="rent" class="toggle-box onlyOpen">
            <a href="javascript:;" class="radio-link choice">
              <i class="large"></i>
              Установить Корпоративные сервисы для оказания услуг сторонним компаниям
            </a>
          </li>
          <li id="connection" class="toggle-box onlyOpen">
            <a href="javascript:;" class="radio-link choice">
              <i class="large"></i>
              Подключиться к уже установленному оборудованию
            </a>
          </li>
          <li>
            <br />
            <div id="content"></div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="column twelve text-center toggle-active">
      <a href="javascript:;" class="go-button button round">Отправить</a>
    </div>
  </div>
</div>
<input style="display:none" type="text" class="span4" name="RegisterSelfForm[email2]" autocomplete="off" placeholder="Email" >
<input type="hidden" name="choice" value="">
</form>