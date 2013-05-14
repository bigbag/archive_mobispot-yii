<?php
/**
* Controller is the customized base controller class.
* All controller classes for this application should extend from this base class.
*/
class MController extends Controller{

  public $pageDescription;
  public $pageKeywords;

  public $sliderImage;
  public $sliderText;

  public $pageClass;
  /**
  * @var string the default layout for the controller view. Defaults to '//layouts/column1',
  * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
  */
  public $layout = '//layouts/all';
  /**
  * @var array context menu items. This property will be assigned to {@link CMenu::items}.
  */
  public $menu = array();
  /**
  * @var array the breadcrumbs of the current page. The value of this property will
  * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
  * for more details on how to specify this property.
  */
  public $breadcrumbs = array();

  public function beforeRender(){

    if (!empty($this->pageDescription)) $description = $this->pageDescription;
  else $description = Yii::app()->par->load('siteDesc');

    Yii::app()->clientScript->registerMetaTag($description, 'description');

    if (!empty($this->pageKeywords)) $keywords = $this->pageKeywords;
  else  $keywords = Yii::app()->par->load('siteKeywords');

    Yii::app()->clientScript->registerMetaTag($keywords, 'keywords');

    Yii::app()->cache->flush();

    return true;
  }

  public function userInfo(){
    if (Yii::app()->user->id) {
      $id = Yii::app()->user->id;
      $info = Yii::app()->cache->get('user_' . $id);
      if ($info == false) {
        $info = UserProfile::model()->findByPk($id);
        $user = User::model()->findByPk($id);
        if (empty($info->name)) $info->name = $user->email;

        Yii::app()->cache->set('user_' . $id, $info, 3600);
      }

      return $info;
    } else return false;
  }

  public function lastVisit(){
    Yii::app()->db->createCommand()
    ->update('user',
      array(
        'lastvisit' => new CDbExpression('NOW()'),
      ),
      'id=:id',
    array(':id' => Yii::app()->user->id));
    return true;
  }

  public function setAccess(){
    throw new CHttpException(403, Yii::t('user', 'У вас не хватает прав для доступа.'));
  }

  public function init(){
    if (isset(Yii::app()->request->cookies['lang'])) {
      $lang = Yii::app()->request->cookies['lang']->value;
      $all_lang = Lang::getLangArray();
      if (isset($all_lang[$lang])) Yii::app()->language = $lang;
      else  Yii::app()->language = 'en';
    }
    else if (Yii::app()->user->id) {
      $user = User::model()->findByPk(Yii::app()->user->id);
      Yii::app()->request->cookies['lang'] = new CHttpCookie('lang', $user->lang);
      Yii::app()->language = $user->lang;
    }
    else  Yii::app()->language = 'en';
  }

  public function  getLang(){
    return (Yii::app()->request->cookies['lang']) ? Yii::app()->request->cookies['lang']->value : 'en';
  }

  public function getJson (){
    $post = file_get_contents("php://input");
    return CJSON::decode($post, true);
  }

  public function getCart () {
     if(Yii::app()->session['itemsInCart'] and Yii::app()->session['itemsInCart'] > 0){
      return Yii::app()->session['itemsInCart'];
     }
     else {
      return false;
     }
  }
}
