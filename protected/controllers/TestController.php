<?php

class TestController extends MController {

  public function actionIndex() {

	$email = 'dionicii@mail.ru';
	$lang = 'en';
	
	$order = array();
	$order['id'] = 12;
	$order['target_first_name'] = 'Иван';
	$order['target_last_name'] = 'Иванов';
	$order['address'] = 'Семеновская 7';
	$order['city'] = 'Москва';
	$order['zip'] = '123456';
	
	$order['delivery'] = 'DHL';
	$order['delivery_id'] = '';
	
	$order['subtotal'] = '46';	
	$order['tax'] = '0.00';
	$order['shipping'] = 16;
	$order['total'] = 62;
	
	$items = array();
	$item = array();
	$item['name'] = 'Business card spot';
	$item['code'] = '31279F112001';
	$item['size_name'] = str_replace('single', '-', 'single');
	$item['price'] = '15';
	$item['color'] = '';
	$item['surface'] = 'For drawing';
	$item['quantity'] = 2;
	$items[] = $item;
	$item['name'] = 'Wristband spot';
	$item['code'] = '31279F112001';
	$item['size_name'] = str_replace('single', '-', 'M');
	$item['price'] = '16';
	$item['color'] = 'yellow';
	$item['surface'] = '';	
	$item['quantity'] = 1;
	$items[] = $item;
	$order['items'] = $items;


	
	$this->render('index', array('order'=>$order));
  }

	public function actionSpot(){
		$discodes = 100198;
        $spot=Spot::model()->findByPk($discodes);
        if ($spot) {
          $spotContent=SpotContent::getSpotContent($spot);
          $content=$this->render('//widget/spot/'.$spot->spot_type->key,
            array(
              'spot'=>$spot,
              'spotContent'=>$spotContent,
            ),
            true);
        }		
	}

}