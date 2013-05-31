<?php

class SpotController extends MController {

  // Список отображаемых картинок
  public function getImageType(){
    return array('jpeg'=>'jpeg', 'jpg'=>'jpg', 'png'=>'png', 'gif'=>'gif');
  }

  // Действие по умолчанию - редикт на мобильную версию
  public function actionIndex() {
    if (Yii::app()->request->getQuery('url', 0)) {
      $url=Yii::app()->request->getQuery('url', 0);
      $this->redirect('http://m.tmp.mobispot.com/' . $url);
    }
  }

  // Загрузка файлов в спот
   public function actionUpload() {
    $error="yes";
    $content="";
    $key="";

    $discodes=(isset($_SERVER['HTTP_X_DISCODES']) ? $_SERVER['HTTP_X_DISCODES'] : false);
    $file=(isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : false);

    if ($file and $discodes) {
      $fileType=strtolower(substr(strrchr($file, '.'), 1));
      $file=md5(time().$discodes).'_'.$file;

      $patch=Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
      $file_name=$patch.$file;

      if (file_put_contents($file_name, file_get_contents('php://input'))){
        $images=$this->getImageType();

        if (isset($images[$fileType])){
          $type='image';

          $image=new CImageHandler();
          $image->load($file_name);
          if ($image->thumb(false, 300, true)) {
            $image->save($patch.'tmb_'.$file);
          }
        }
        else{
          $type='obj';
        }

        $spot=Spot::getSpot(array('discodes_id'=>$discodes));
        $spotContent=SpotContent::getSpotContent($spot);

        if(!$spotContent) {
          $spotContent=SpotContent::initPersonal($spot);
        }

        $content=$spotContent->content;
        $content['keys'][$content['counter']]=$type;
        $key=$content['counter'];
        $content['data'][$key]=$file;
        $content['counter']=$content['counter']+1;
        $spotContent->content=$content;
        $spotContent->save();
        $content=$this->renderPartial('//widget/spot/personal/new_'.$type,
          array(
            'content'=>$file,
            'key'=>$key,
          ),
        true);
        $error="no";
      }
    }
    echo json_encode(array('error'=>$error, 'content'=>$content, 'key'=>$key));
  }

  // Просмотр содержимого спота
  public function actionSpotView() {
  if (Yii::app()->request->isPostRequest) {
    $error="yes";
    $content="";

    $data=$this->getJson();
    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['discodes'])) {

        $spot=Spot::model()->findByPk($data['discodes']);
        if ($spot) {

          $spotContent=SpotContent::getSpotContent($spot);
          $content=$this->renderPartial('//widget/spot/'.$spot->spot_type->key,
            array(
              'spot'=>$spot,
              'spotContent'=>$spotContent,
            ),
            true);
          $error="no";
        }
      }
    }
      echo json_encode(array('error'=>$error, 'content'=>$content));
    }
  }

  // Добавление блока в спот
  public function actionSpotAddContent() {
    if (Yii::app()->request->isPostRequest) {
      $error="yes";
      $content="";
      $key="";
      $data=$this->getJson();

      if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

        if (isset($data['content']) and isset($data['user'])){

          if (isset($data['discodes'])){

            $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
            $spotContent=SpotContent::getSpotContent($spot);

            if(!$spotContent) {
              $spotContent=SpotContent::initPersonal($spot);
            }

            $content=$spotContent->content;
            $content['keys'][$content['counter']]='text';
            $key=$content['counter'];
            $content['data'][$key]=$data['content'];
            $content['counter']=$content['counter']+1;
            $spotContent->content=$content;
            $spotContent->save();
            $content=$this->renderPartial('//widget/spot/personal/new_text',
              array(
                'content'=>$data['content'],
                'key'=>$key,
              ),
              true);
            $error="no";
          }
        }
      }

      echo json_encode(array('error'=>$error, 'content'=>$content, 'key'=>$key));
    }
  }

  // Изменение атрибутов спота - приватность и возможность скачать визитку
  public function actionSpotAtributeSave() {
    $error="yes";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['discodes'])){

        $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
        if ($spot){
          $spotContent=SpotContent::getSpotContent($spot);

          if(!$spotContent) {
            $spotContent=SpotContent::initPersonal($spot);
          }

          $content=$spotContent->content;
          $content['private']=$data['private'];
          $content['vcard']=$data['vcard'];
          $spotContent->content=$content;
          if ($spotContent->save()){
            $error="no";
          }
          $error="no";
        }
      }
    }
    echo json_encode(array('error'=>$error));
  }

  // Удаление блока из спота
  public function actionSpotRemoveContent() {
    $error="yes";
    $keys="";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['discodes']) and isset($data['key'])){

        $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
        if ($spot){
          $spotContent=SpotContent::getSpotContent($spot);

          if($spotContent) {
            $content=$spotContent->content;

            if ($content['keys'][$data['key']]!='text'){
              $patch=Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
              @unlink($patch.$content['data'][$data['key']]);
              @unlink($patch.'tmb_'.$content['data'][$data['key']]);
            }

            unset($content['keys'][$data['key']]);
            unset($content['data'][$data['key']]);
            $spotContent->content=$content;
            if ($spotContent->save()){
              $error="no";
              $keys=array();
              foreach ($content['keys'] as $key => $value) {
                $keys[]=$key;
              }
            }
          }
        }
      }
    }
    echo json_encode(array('error'=>$error, 'keys'=>$keys));
  }

  // Редактирование содержимого блока
  public function actionSpotEditContent() {
    $error="yes";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['discodes']) and isset($data['key'])){

        $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
        if ($spot){
          $spotContent=SpotContent::getSpotContent($spot);

          if($spotContent) {}
        }
      }
    }
    echo json_encode(array('error'=>$error));
  }

  // Сохранение содержимого блока
  public function actionSpotSaveContent() {
    $error="yes";
    $content='';
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
      if (isset($data['discodes']) and isset($data['key'])){
        $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
        if ($spot){
          $spotContent=SpotContent::getSpotContent($spot);

          if($spotContent) {
            $content=$spotContent->content;
            $content['data'][$data['key']]=$data['content_new'];

            $spotContent->content=$content;
            if ($spotContent->save()){
              $content=$this->renderPartial('//widget/spot/personal/new_text',
              array(
                'content'=>$data['content_new'],
                'key'=>$data['key'],
              ),
              true);
              $error="no";
            }
          }
        }
      }
    }
    echo json_encode(array('error'=>$error, 'content'=>$content));
  }

  //Привязка соцсетей
  public function actionBindSocial() {
    $error="yes";
    $content='';
    $data=$this->getJson();
    $netName='no';
    $isSocLogged=false;

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['discodes']) and isset($data['key'])){

        $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
        if ($spot)  {

          $spotContent=SpotContent::getSpotContent($spot);
          if($spotContent) {

            $SocInfo=new SocInfo;
            $netName=$SocInfo->detectNetByLink($spotContent->content['data'][$data['key']]);

            if($netName!='no'){
              $content=$spotContent->content;

              if(isset(Yii::app()->session[$netName])
                and (Yii::app()->session[$netName]=='auth')){

                $isSocLogged=true;
                $content['keys'][$data['key']]='socnet';
                $spotContent->content=$content;

                if ($spotContent->save()) {
                  $content=$this->renderPartial('//widget/spot/personal/new_socnet',
                  array(
                    'content'=>$content['data'][$data['key']],
                    'key'=>$data['key'],
                  ),
                  true);
                }
				        unset(Yii::app()->session['bind_discodes']);
                unset(Yii::app()->session['bind_key']);
              }
              else {
                Yii::app()->session['bind_discodes']= $data['discodes'];
                Yii::app()->session['bind_key']=$data['key'];
              }
              $error="no";
            }
          }
        }
      }
    }
    echo json_encode(
      array(
        'error'=>$error,
        'content'=>$content,
        'socnet'=>$netName,
        'loggedIn'=>$isSocLogged
        )
      );
  }

  //Отвязка соцсети
  public function actionUnBindSocial(){
    $error="yes";
    $content='';
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['discodes']) and isset($data['key'])){

        $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
        if ($spot){

          $spotContent=SpotContent::getSpotContent($spot);
          if($spotContent) {

            $content=$spotContent->content;
            if($content['keys'][$data['key']]=='socnet'){
              $content['keys'][$data['key']]='text';
              $spotContent->content=$content;

              if ($spotContent->save()){
                $content=$this->renderPartial('//widget/spot/personal/new_text',
                array(
                  'content'=>$content['data'][$data['key']],
                  'key'=>$data['key'],
                ),
                true);
                $error="no";
              }
            }
          }
        }
      }
    }
    echo json_encode(array('error'=>$error, 'content'=>$content));
  }


  // Добавление нового спота
  public function actionAddSpot() {
    $error="yes";
    $content="";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['code'])) {

        $spot=Spot::model()->findByAttributes(array('code'=>$data['code']));
        if ($spot) {
          $spot->status=Spot::STATUS_REGISTERED;
          $spot->lang=$this->getLang();
          $spot->user_id=Yii::app()->user->id;

          if (isset($data['name'])) {
            $spot->name=$data['name'];
          }
          $spot->spot_type_id=Spot::TYPE_PERSONAL;

          if ($spot->save()) {
            $content=$this->renderPartial('//user/block/spots',
              array(
                'data'=>$spot,
              ),
              true);
            $error="no";
          }
        }
      }
      echo json_encode(array('error'=>$error, 'content'=>$content));
    }
  }

  // Удаление спота
  public function actionRemoveSpot() {
    $error="yes";
    $discodes="";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {

      if (isset($data['discodes'])) {
        $spot=Spot::model()->findByPk($data['discodes']);
        if ($spot) {
          $spot->status=Spot::STATUS_REMOVED_USER;
          if ($spot->save()) {
            $discodes=$data['discodes'];
            $error="no";
          }
        }
      }
      echo json_encode(array('error'=>$error, 'discodes'=>$discodes));
    }
  }

  // Очистка спота
  public function actionCleanSpot() {
    $error="yes";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
      if (isset($data['discodes'])) {
        $spot=Spot::model()->findByPk($data['discodes']);
        if ($spot) {

          $spotContent=SpotContent::getSpotContent($spot);
          $spotContent=SpotContent::initPersonal($spot, $spotContent);

          if ($spotContent->save()){
            $error="no";
          }
        }
      }
      echo json_encode(array('error'=>$error));
    }
  }

  //Делаем спот невидимым
  public function actionInvisibleSpot() {
    $error="yes";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
      if (isset($data['discodes'])) {
        $spot=Spot::model()->findByPk($data['discodes']);

        if ($spot) {
          if ($spot->status==Spot::STATUS_INVISIBLE)
            $spot->status=Spot::STATUS_REGISTERED;
          else
            $spot->status=Spot::STATUS_INVISIBLE;

          if ($spot->save()) {
            $error="no";
          }
        }
      }
      echo json_encode(array('error'=>$error));
    }
  }

  //Переименовываем спот
  public function actionRenameSpot() {
    $error="yes";
    $data=$this->getJson();
    $name='';

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
      if (isset($data['newName']) and isset($data['discodes'])) {
        $spot=Spot::model()->findByPk($data['discodes']);
        if ($spot) {
          $spot->name=CHtml::encode($data['newName']);
          if ($spot->save(false)) {
            $name=mb_substr($spot->name, 0, 45, 'utf-8');
            $error="no";
          }
        }
      }
      echo json_encode(array('error'=>$error, 'name'=>$name));
    }
  }

  //Сохраняем
  public function actionSaveOrder() {
    $error="yes";
    $data=$this->getJson();

    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
      if (isset($data['discodes']) and isset($data['keys'])){

        $spot=Spot::getSpot(array('discodes_id'=>$data['discodes']));
        if ($spot){

          $spotContent=SpotContent::getSpotContent($spot);
          if($spotContent) {

            $content=$spotContent->content;
            $newkeys=[];
            foreach ($data['keys'] as $key) {
              if(isset($content['keys'][$key])) {
                $newkeys[$key]=$content['keys'][$key];
              }
            }
            $content['keys']=$newkeys;
            $spotContent->content=$content;

            if ($spotContent->save()){
              $error="no";
            }
          }
        }
      }
      echo json_encode(array('error'=>$error));
    }
  }

  // public function actionSpotRetype() {
  //   $error="yes";
  //   $discodes="";
  //   $type="";
  //   $type_id="";
  //   $data=$this->getJson();

  //   if (isset($data['type_id']) and isset($data['discodes'])) {
  //     $spot=Spot::model()->findByPk($data['discodes']);
  //     $spot_type_id=$data['type_id'];
  //     if ($spot) {
  //       $spot->spot_type_id=$spot_type_id;
  //       if ($spot->save()) {
  //         $all_type=SpotType::getSpotTypeArray();

  //         $discodes=$spot->discodes_id;
  //         $type_id=$spot_type_id;
  //         $type=$all_type[$spot_type_id];
  //         $error="no";
  //       }
  //     }
  //     echo json_encode(array('error'=>$error, 'discodes'=>$discodes, 'type'=>$type));
  //   }
  // }

  // public function actionSpotCopy() {
  //   $error="yes";
  //   $name="";
  //   $type="";
  //   $discodes="";
  //   $data=$this->getJson();

  //   if (isset($data['discodes_from']) and isset($data['discodes_to'])) {
  //     $spot_id_from=$data['discodes_from'];
  //     $spot_id_to=trim($data['discodes_to']);

  //     $spot_from=Spot::model()->findByAttributes(
  //             array(
  //                 'discodes_id'=>$spot_id_from,
  //                 'user_id'=>Yii::app()->user->id
  //     ));
  //     $spot_to=Spot::model()->findByAttributes(
  //             array(
  //                 'discodes_id'=>$spot_id_to,
  //                 'user_id'=>Yii::app()->user->id
  //     ));
  //     if ($spot_from and $spot_to) {
  //       $spot_to->name=$spot_from->name;
  //       $spot_to->spot_type_id=$spot_from->spot_type_id;
  //       $spot_to->status=Spot::STATUS_CLONES;
  //       if ($spot_to->save()) {
  //         $to=SpotModel::model()->findAllByAttributes(array('spot_id'=>$spot_id_to));
  //         foreach ($to as $row) {
  //           $row->delete();
  //         }
  //         $from=SpotModel::model()->findAllByAttributes(array('spot_id'=>$spot_id_from));
  //         foreach ($from as $row) {
  //           $to=new SpotModel();
  //           $to->attributes=$row->attributes;
  //           $to->spot_id=$spot_id_to;
  //           $to->initSoftAttributes(SpotLinkTypeField::getSpotFieldSlug($row->spot_type_id));

  //           $soft_field=SpotLinkTypeField::getSpotFieldSlug($row->spot_type_id);
  //           foreach ($soft_field as $slug) {
  //             $to->__set($slug, $row->__get($slug));
  //           }

  //           $to->save();
  //         }

  //         $type=$spot_to->spot_type->name;
  //         $name=$spot_to->name;
  //         $discodes=$spot_to->discodes_id;
  //         $error="no";
  //       }
  //     }
  //     echo json_encode(array('error'=>$error, 'discodes'=>$discodes, 'name'=>$name, 'type'=>$type));
  //   }
  // }

  // public function actionSpotEdit() {
  //   if (isset($_POST['SpotModel']) and isset($_POST['SpotModel']['spot_id']) and isset($_POST['SpotModel']['spot_type_id'])) {

  //     $spot_id=$_POST['SpotModel']['spot_id'];
  //     $spot_type_id=($_POST['SpotModel']['spot_type_id']);
  //     $spot=Spot::model()->findByPk($spot_id);

  //     $content=SpotModel::getContent($spot->lang, $spot_id, Yii::app()->user->id, $spot_type_id);
  //     if ($content) {
  //       $content=SpotModel::setField($content, $_POST['SpotModel']);

  //       if ($content->update()) {
  //         echo json_encode(array('discodes_id'=>$content->spot_id));
  //       }
  //     }
  //   }
  // }

  // public function actionSpotFeedbackContent() {
  //   $error="yes";
  //   $content="";

  //   $data=$this->getJson();
  //   if (isset($data['discodes'])) {
  //     $spot=FeedbackContent::model()->findAllByAttributes(array('spot_id'=>$data['discodes']));
  //     $content=$this->renderPartial('//widget/spot/feedback_content', array(
  //         'discodes_id'=>$data['discodes'],
  //         'spot'=>$spot,
  //             ), true);
  //     $error="no";
  //     echo json_encode(array('error'=>$error, 'content'=>$content));
  //   }
  // }

  // public function actionSpotPersonalContent() {
  //   if (isset($_POST['discodes_id']) and isset($_POST['type_id'])) {
  //     $select_field=UserPersonalField::getField($_POST['discodes_id']);

  //     if (!$select_field)
  //       $select_field=false;

  //     $all_field=SpotPersonalField::getPersonalField((int) $_POST['type_id']);
  //     $txt=$this->renderPartial('//widget/spot/personal_field', array(
  //         'discodes_id'=>(int) $_POST['discodes_id'],
  //         'all_field'=>$all_field,
  //         'select_field'=>$select_field,
  //         'type_id'=>(int) $_POST['type_id'],
  //             ), true);
  //     echo $txt;
  //   }
  // }

  // public function actionSpotPersonalField() {
  //   if (isset($_POST['discodes_id']) and isset($_POST['Fields']) and isset($_POST['type_id'])) {

  //     $data=array();
  //     foreach ($_POST['Fields'] as $key=>$value) {
  //       $data[]=$key;
  //     }

  //     UserPersonalField::setField($_POST['discodes_id'], $_POST['type_id'], $data);
  //     Yii::app()->cache->delete('spot_personal_field_'.$_POST['discodes_id']);
  //     echo true;
  //   }
  // }

  // public function actionSpotPersonalPhoto() {
  //   if (isset($_POST['user_id']) and isset($_POST['file_name'])) {
  //     $user_id=$_POST['user_id'];

  //     $photo=UserPersonalPhoto::getPhoto($user_id);
  //     if (count($photo) > 9)
  //       unset($photo[0]);
  //     $photo[]=$_POST['file_name'];
  //     echo UserPersonalPhoto::setPhoto($user_id, array_values($photo));
  //   }
  // }

  // public function actionSpotGetGallery() {
  //   if (isset($_POST['user_id'])) {
  //     $user_id=$_POST['user_id'];

  //     $text=$this->renderPartial('/widget/spot/personal_gallery', array(
  //         'photo'=>UserPersonalPhoto::getPhoto($user_id),
  //         'user_id'=>$user_id,
  //             ), true);
  //     echo $text;
  //   }
  // }

  // public function actionSpotRemovePhoto() {
  //   if (isset($_POST['user_id']) and isset($_POST['file'])) {
  //     #UserPersonalPhoto::removePhoto($_POST['user_id'], $_POST['file']);
  //     echo $_POST['file'];
  //   }
  // }

}
