<?php

/**
* Uniteller.php
*
* @author    pavel Lyashkov <bilbo.kem@gmail.com>
* @author    bigbag1983
* @link      http://uzelki.info/
* @package   Uniteller
* @version   0.2
* @category  ext
*
* orderId -Номер заказа в системе расчётов интернет-магазина, соответствующий данному платежу
* amount - Сумма покупки в валюте, оговоренной в договоре с банком-эквайером
* meanType - платёжная система банковской карты.
* eMoneyType - тип электронной валюты
* lifeTime - время жизни формы оплаты в секундах
* customerId - идентификатор покупателя
* cardId - идентификатор зарегистрированной карты
* lData - «длинная запись»
* paymenType - тип платежа
*/

class Uniteller extends CApplicationComponent
{
  /**
  * Идентификатор точки продажи в системе Uniteller.
  *
  * @var string
  */
  public $shopId='';
  public $testShopId='';

  /**
  * Логин из раздела "Параметры Авторизации" Личного кабинета системы Uniteller.
  *
  * @var string
  */
  public $login='';
  public $testLogin='';

  /**
  * Пароль из раздела "Параметры Авторизации" Личного кабинета системы Uniteller.
  *
  * @var string
  */
  public $pass='';
  public $testPass='';

  /**
  * Флаг для перехода в тестовый режим
  *
  * @var bool
  */
  public $isTest=false;

  /**
  * URL для отправки пакета.
  *
  * @var string
  */
  const PAYMENT_URL="wpay.uniteller.ru/pay/";

  /**
  * URL для получение результатов авторизации.
  *
  * @var string
  */
  const RESULT_URL="wpay.uniteller.ru/results/";

  /**
  * URL для отмены платежа.
  *
  * @var string
  */
   const UNBLOCK_URL="wpay.uniteller.ru/unblock/";

  /**
  * URL для автоплатежа.
  *
  * @var string
  */
   const AUTO_PAY_URL="wpay.uniteller.ru/recurrent/";

  /**
  * Значение по умолчанию - количество дней в течении которых статус платежа paid=2 может превратиться в canceled=-1.
  *
  * @var int
  */
  const TIME_PAID_CHANGE=14;

  /**
  * Значение по умолчанию - количество дней в течении которых статус заказа будет синхронизироваться.
  *
  * @var int
  */
  const TIME_ORDER_SYNC=30;

  /**
  * Код ответа: АВТОРИЗАЦИЯ УСПЕШНО ЗАВЕРШЕНА.
  *
  * @var string
  */
  const CODE_SUCCES='AS000';

  /**
  * Код статуса заказа в электронном магазине, соответствующего статусу "Paid" платежа в системе Uniteller.
  *
  * @var string
  */
  const PAID_STATUS=2;

  /**
   * Получаем URL для платежа
   * @return string
   */
  public function getPayUrl() {
    $test=($this->isTest)?"test.":"";
    return "https://".$test.self::PAYMENT_URL;
  }

  /**
   * Получаем URL для результатов авторизации
   * @return string
   */
  public function getResultUrl()  {
    $test=($this->isTest)?"test.":"";
    return "https://".$test.self::RESULT_URL;
  }

  /**
  * Получаем URL для отмены платежа
  * @return string
  */
  public function getUnblockUrl() {
    $test=($this->isTest)?"test.":"";
    return "https://".$test.self::UNBLOCK_URL;
  }

  /**
  * Получаем URL для автоплатежа
  * @return string
  */
  public function getAutoPayUrl() {
    if (!($this->isTest)) {
      return "https://".self::AUTO_PAY_URL;
    }
    else {
      return false;
    }
  }

  /**
   * Вычисляем сигнатуру платежной операции
   * @param  array $order
   * Обязательные элементы: orderId, amount
   * @return string
   */
  public function getPaySign($order)  {
    $keys=array(
      $this->shopId,
      (!empty($order['orderId']))?$order['orderId']:'',
      (!empty($order['amount']))?$order['amount']:'',
      (!empty($order['meanType']))?$order['meanType']:'',
      (!empty($order['eMoneyType']))?$order['eMoneyType']:'',
      (!empty($order['lifeTime']))?$order['lifeTime']:'',
      (!empty($order['customerId']))?$order['customerId']:'',
      (!empty($order['cardId']))?$order['cardId']:'',
      (!empty($order['lData']))?$order['lData']:'',
      (!empty($order['paymenType']))?$order['paymenType']:'',
      $this->pass,
    );

    foreach ($keys as $key => $value) {
      $keys[$key]=md5($value);
    }

    return strtoupper(md5(implode('&', $keys)));
  }

  /**
   * Вычисляем сигнатуру автоплатежа
   * @param  array $order
   * Обязательные элементы: orderId, amount, parentOrderId
   * @return string
   */
  public function getAutoPaySign($order)  {
    $keys=array(
      $this->shopId,
      (!empty($order['orderId']))?$order['orderId']:'',
      (!empty($order['amount']))?$order['amount']:'',
      (!empty($order['parentOrderId']))?$order['parentOrderId']:'',
      $this->pass,
    );

    foreach ($keys as $key => $value) {
      $keys[$key]=md5($value);
    }

    return strtoupper(md5(implode('&', $keys)));
  }

  /**
  * Посылает запрос и возвращает ответ в виде simplexml_object, строки с ошибкой или false.
  *
  * @param string $url
  * @param array $data
  * @return simplexml_object|string|boolean
  */
  public function setCurlRequest($url, $data) {
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, (string)$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, (array)$data);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

    $result=curl_exec($ch);
    $errno=curl_errno($ch);
    $error=curl_error($ch);
    curl_close($ch);

    if ($errno == 0) {
      libxml_use_internal_errors(true);
      $xml=simplexml_load_string($result);
      if ($xml !== false) {
          return $xml;
      }
     else {
        libxml_clear_errors();
        return $result;
      }
    }
    else {
      return false;
    }
  }

  /**
  * Посылает запрос на получение результатов авторизации по номеру заказа и возвращает массив данных для чека.
  *
  * @param int $orderId
  * @return array
  */
  public function getCheckData($orderId) {
    $data=array(
      'ShopOrderNumber'=>(int)$orderId,
      'Shop_ID'=>$this->shopId,
      'Login'=>$this->login,
      'Password'=>$this->pass,
      'Format'=>'4',
    );

    $xml=$this->setCurlRequest($this->getResultUrl(), $data);

    $array_xml = (array)$xml;
    if ($xml===false) {
      // oшибка при выполнении запроса.
      $return['error_protocol']=true;

    } elseif (isset($xml->orders->order)) {
      $xml_order=$xml->orders->order;

      $total=(array)$xml_order->total;
      $currency=(array)$xml_order->currency;
      $date=(array)$xml_order->date;
      $approvalcode=(array)$xml_order->approvalcode;
      $billnumber=(array)$xml_order->billnumber;
      $response_code=(array)$xml_order->response_code;
      $ordernumber=(array)$xml_order->ordernumber;
      $status=(array)$xml_order->status;
      $cardnumber=(array)$xml_order->cardnumber;
      $phone=(array)$xml_order->phone;
      $ipaddress=(array)$xml_order->ipaddress;

      $return['total']=((isset($total[0]))?$total[0]:'');
      $return['currency']=((isset($currency[0]))?$currency[0]:'');
      $return['date']=((isset($date[0]))?$date[0]:'');
      $return['approvalcode']=((isset($approvalcode[0]))?$approvalcode[0]:'');
      $return['billnumber']=((isset($billnumber[0]))?$billnumber[0]:'');
      $return['response_code']=((isset($response_code[0]))? $response_code[0]:'');
      $return['ordernumber']=((isset($ordernumber[0]))?$ordernumber[0]:'');
      $return['status']=((isset($status[0]))?$status[0]:'');
      $return['cardnumber']=((isset($cardnumber[0]))? $cardnumber[0]:'');
      $return['phone']=((isset($phone[0]))?$phone[0]:'');
      $return['ipaddress']=((isset($ipaddress[0]))?$ipaddress[0]:'');


    } elseif (isset($array_xml['@attributes']['count']) and (int)$array_xml['@attributes']['count'] == 0) {
      // платежа нет, но вернулся валидный xml с атрибутом count равным 0
      $return['error_count']=true;

    } else {
      // вернулась строка с ошибкой
      $return['error_message']=$xml;
      $return['error_authentication']=true;
    }

    return $return;
  }

    /**
  * Посылает запрос на выполнение автоплатежа по номеру родительского заказа и возвращает массив данных для чека.
  *
  * @param array $order
  * Обязательные поля: orderId, amount, parentOrderId
  * @return bool
  */
  public function setAutoPay($order) {
    $data=array(
      'Shop_IDP'=>$this->shopId,
      'Order_IDP'=>$order['orderId'],
      'Subtotal_P'=>$order['amount'],
      'Parent_Order_IDP'=>$order['parentOrderId'],
      'Signature'=>$this->getAutoPaySign($order),
      );
    $result=$this->setCurlRequest($this->getAutoPayUrl(), $data);
    $result=explode(';',$result);

    if (isset($result[28]) and $result[28]==self::CODE_SUCCES)  {
      return $result[1];
    }
    else {
      return false;
    }
  }
}
