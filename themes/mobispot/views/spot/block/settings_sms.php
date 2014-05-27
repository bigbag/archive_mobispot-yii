<h4>SMS информирование</h4>
<div class="set-item sms" ng-class="smsActive">
    <div class="control">
        <div class="columns large-5">
            <div class="control-item">
                <input ng-model="number" type="text" placeholder="Номер телефона">
                <div class="toggle-active">
                    <a href="javascript:;" class="checkbox agree">
                        <i class="large"></i>
                        <span>Включить для все кошельков</span>
                    </a>
                </div>
            </div>
            <a href="javascript:;" class="form-button on" ng-click="showPop('sms'); countdown()">Включить</a>
            <a href="javascript:;" class="form-button off" ng-click="smsActive = ''">Отключить/Изменить</a>
        </div>
        <div class="columns large-7">
            <p class="set-description">Смс информирование включается для всех кошельков сразу. Смс пока высылается только в том случае когда баланс любой карты меньше 40 руб.<br>
            <br>
            Установил галочку вы привязываете все кошельки к sms информированнию на данный номер.
            </p>
        </div>
    </div>
</div>