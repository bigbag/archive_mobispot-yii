<?php

class Uniteller
{

    private $shopId = '7208758777-2667';
    private $pass = 'PgJhDRtqXcDDSsYATWN5yuKlQKnEI0zU7JPY3hjKmNr5EETDMwBZQKy8VT1us7lOgGDeMUuHlG4qILxM';
    private $login = 1629;

    public function getData($Order_ID)
    {
        // Параметры могут извлекаться из БД или из других хранилищ данных, либо содержаться внутри кода
        $Shop_ID = $this->shopId; // идентификатор точки продажи
        $Login = $this->login; // логин из ЛК Uniteller
        $Password = $this->pass; // пароль из ЛК Uniteller
        /* Format=1 - получить данные в виде строки с разделителем ";", можно получать
          данные и в других форматах (см. Технический порядок), например, XML, тогда обработка
          полученного ответа изменится */
        $sPostFields = "Shop_ID=" . $Shop_ID . "&Login=" . $Login . "&Password=" . $Password . "&Format=1&ShopOrderNumber=" .
                $Order_ID . "&S_FIELDS=Status;ApprovalCode;BillNumber";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://test.wpay.uniteller.ru/results/");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sPostFields);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        $curl_response = curl_exec($ch);
        $curl_error = curl_error($ch);
        $data = array(); // результат для возврата
        if ($curl_error) {
            // обработка ошибки обращения за статусом платежа
        } else {
            // данные получены
            // обработка данных из переменной $curl_response
            $arr = explode(";", $curl_response);
            if (count($arr) > 2) {
                $data = array(
                    "Status" => $arr[0]
                    , "ApprovalCode" => $arr[1]
                    , "BillNumber"
                    => $arr[2]
                );
            } else {
                // что-то не так, обработчик полученного ответа
            }
        }
        return $data;
    }

    public function checkSignature($Order_ID, $Status, $Signature)
    {
        $password = "PgJhDRtqXcDDSsYATWN5yuKlQKnEI0zU7JPY3hjKmNr5EETDMwBZQKy8VT1us7lOgGDeMUuHlG4qILxM"; // пароль из ЛК Uniteller
        // проверка подлинности подписи и данных
        return ( $Signature == strtoupper(md5($Order_ID . $Status . $password)) );
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function signOrder($order)
    {
        $idShop = '';
        if (isset($order['idShop']) && (strlen($order['idShop']) > 0))
            $idShop = $order['idShop'];
        $idOrder = '';
        if (isset($order['idOrder']) && (strlen($order['idOrder']) > 0))
            $idOrder = $order['idOrder'];
        $subtotal = '';
        if (isset($order['subtotal']) && (strlen($order['subtotal']) > 0))
            $subtotal = $order['subtotal'];
        $MeanType = '';
        if (isset($order['MeanType']) && (strlen($order['MeanType']) > 0))
            $MeanType = $order['MeanType'];
        $EMoneyType = '';
        if (isset($order['EMoneyType']) && (strlen($order['EMoneyType']) > 0))
            $EMoneyType = $order['EMoneyType'];
        $Lifetime = '';
        if (isset($order['Lifetime']) && (strlen($order['Lifetime']) > 0))
            $Lifetime = $order['Lifetime'];
        $idCustomer = '';
        if (isset($order['idCustomer']) && (strlen($order['idCustomer']) > 0))
            $idCustomer = $order['idCustomer'];
        $Card_IDP = '';
        if (isset($order['Card_IDP']) && (strlen($order['Card_IDP']) > 0))
            $Card_IDP = $order['Card_IDP'];
        $IData = '';
        if (isset($order['IData']) && (strlen($order['IData']) > 0))
            $IData = $order['IData'];
        $PT_Code = '';
        if (isset($order['PT_Code']) && (strlen($order['PT_Code']) > 0))
            $PT_Code = $order['PT_Code'];

        $sign = strtoupper(
                md5(
                        md5($idShop) . "&" .
                        md5($idOrder) . "&" .
                        md5($subtotal) . "&" .
                        md5($MeanType) . "&" .
                        md5($EMoneyType) . "&" .
                        md5($Lifetime) . "&" .
                        md5($idCustomer) . "&" .
                        md5($Card_IDP) . "&" .
                        md5($IData) . "&" .
                        md5($PT_Code) . "&" .
                        md5($this->pass)
                )
        );
        return $sign;
    }

    /*
      public function getPass()
      {
      return $this->pass;
      }
     */
}
