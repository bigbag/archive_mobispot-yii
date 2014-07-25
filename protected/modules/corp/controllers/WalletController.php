<?php

class WalletController extends MController
{
        public $layout = '//corp/layouts/all';

    //Список кошельков
    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) MHttp::setAccess();

        $user_id = Yii::app()->user->id;
        if (!$user_id) MHttp::setAccess();

        $user = User::model()->findByPk($user_id);
        if ($user->status != User::STATUS_VALID)  $this->redirect('/corp');

        $this->render('index', array(
            'wallets' => PaymentWallet::getActiveByUserId($user_id),
        ));
    }

    // Просмотр кошелька
    public function actionGetView()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => 'yes', 'content' => '');

        if (!isset($data['wallet_id']))
            MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByPk($data['wallet_id']);
        if (!$wallet or Yii::app()->user->id != $wallet->user_id)
            MHttp::getJsonAndExit($answer);

	Spot::curentSpot($wallet->discodes_id, true);
        Spot::curentViews('wallet', true);

        $historyList = PaymentHistory::getListWithPagination($data['wallet_id']);
        $history = $historyList['history'];

        $answer['content'] = $this->renderPartial('//corp/wallet/block/wallet_view', array(
            'wallet' => $wallet,
            'history' => $history,
            'pagination' => $historyList['pagination'],
            'filter' => $historyList['filter'],
            ), true);
        $answer['error'] = "no";

        echo json_encode($answer);
    }


    public function actionGetHistory()
    {
        $data = MHttp::validateRequest();
        $answer = array();
        $answer['error'] = "yes";

        if (!isset($data['id']))
            MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByPk($data['id']);
        if (!$wallet or Yii::app()->user->id != $wallet->user_id)
            MHttp::getJsonAndExit($answer);

        $page = 1;
        if (isset($data['page']) and $data['page'] > 1)
            $page = $data['page'];

        $filterDate = '';
        if (isset($data['date']) and preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $data['date']))
            $filterDate = $data['date'];

        $filterTerm = '';
        if (isset($data['term']) and $data['term'])
            $filterTerm = $data['term'];

        $historyList = PaymentHistory::getListWithPagination(
            $data['id'],
            $page,
            $filterDate,
            $filterTerm
        );

        $answer['content'] = $this->renderPartial('//corp/wallet/block/history', array(
            'wallet' => $wallet,
            'history' => $historyList['history'],
            'pagination' => $historyList['pagination'],
            'filter' => $historyList['filter'],
            ), true);
        $answer['error'] = "no";

        echo json_encode($answer);
    }

     // Блокировка кошелька
    public function actionBlockWallet()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => 'yes', 'content' => '');

        if (!isset($data['id']))
            MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByPk($data['id']);
        if ($wallet->status == PaymentWallet::STATUS_BANNED) {
            $wallet->status = PaymentWallet::STATUS_ACTIVE;
            $answer['content'] = 'Заблокировать';
        } elseif ($wallet->status == PaymentWallet::STATUS_ACTIVE) {
            $wallet->status = PaymentWallet::STATUS_BANNED;
            $answer['content'] = 'Разблокировать';
        }

        $wallet->save(false);
        $answer['error'] = "no";
        $answer['status'] = $wallet->status;

        echo json_encode($answer);
    }
}
