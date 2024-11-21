<?php

namespace app\controllers;


use Exception;
use Yii;
use yii\web\Controller;
use app\models\User;
class UserController extends Controller {

    public function actionNew()
    {
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->session->setFlash("warning", "No puedes crear usuario en estado logueado");
            return$this->goHome();
        }
        $user = new User;
        if($user->load(Yii::$app->request->post())){
            if($user->validate())
            {
                if($user->save())
                {
                    Yii::$app->session->setFlash("success", 'usuario guardado correctamente');
                    return $this->redirect(['site/login']);
                } else {
                    throw new Exception("Error al salvar el usuario");
                    return;
                }
            }
            $user->password = '';
            $user->password_repeat = '';
        }
        return $this->render('new.tpl',['user'=>$user]);
    }
}