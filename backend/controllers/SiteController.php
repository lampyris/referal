<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex(){    
        $user = \Yii::$app->user->identity;
        $parent = null;
        $child = null;
        
        if (!\Yii::$app->user->can('admin')){
            $user->parent_id ? $parent = \common\models\User::findOne(['id'=>$user->parent_id]) : '';
            $child = new \yii\data\ActiveDataProvider([
                'query' => \common\models\User::find()->where(['parent_id'=>$user->id])
            ]);
        } else {            
            $userList = \common\models\User::find()->where(['parent_id' => null])->orderBy('id')->all();
            $tree = [];
            foreach ($userList as $key => $item){
                $tree[] = $item;
                $branch = $this->makeTree($item->id, 0, array());
                $tree = array_merge($tree, $branch);       
            }
            $userList = $tree;
//            print_r('<pre>');
//            print_r($userList);
//            print_r('</pre>');
//            die();
            
        }
        
        $crypt = openssl_encrypt($user->email, 'aes-128-ecb', '304c6528f659c77866a510d9c1d6ae5e', false);
        return $this->render('index',[
            'parent' => $parent,
            'child' => $child,
            'crypt' => $crypt,
            'userList' => $userList
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function makeTree($parent, $level, $tree){
        $array = \common\models\User::find()->where(['parent_id'=>$parent])->orderBy('id')->all();
        if(isset($array)){
            foreach ($array as $item){
                $level = $level + 1;
                $tree[] = ['user'=> $item, 'level' => $level];
                $tree = $this->makeTree($item->id, $level, $tree);
                $level = $level - 1;
            }
        }
        return $tree;
    }
}
