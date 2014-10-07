<?php

class SiteController extends Controller
{
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->redirect(array('mainPage/mainPage/index'));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->getReturnUrl(array('site/index')));
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Panorama
     */
    public function actionPanorama()
    {
        $this->render('panorama');
    }

    /**
     * Карта
     */
    public function actionMap()
    {
        $areas = MapArea::model()->findAll();
        $this->render('map', array(
            'areas' => $areas
        ));
    }

    /**
     * Презентация
     */
    public function actionPresentation()
    {
        $this->render('presentation');
    }

    /**
     * Тест
     */
    public function actionTest()
    {
        $this->render('test');
    }

    /**
     * Upload image
     */
    public function actionUploadImage()
    {
        $isOk = isset($_FILES['upload']) && $_FILES['upload']['error']==0 && $_FILES['upload']['size']>0;
        if (!$isOk)
            throw new CHttpException(404, 'Page not found');

        // Check tmp image
        $result = getimagesize($_FILES['upload']['tmp_name']);
        $isOk = false;
        if ($result !== false)
        {
            // width & height
            if ($result[0] != 0  &&  $result[1] != 0)
            {
                switch ($result['mime'])
                {
                    case 'image/jpeg':
                    case 'image/jpg':
                    case 'image/png':
                        $isOk = true;
                        break;
                }
            }
        }
        if (!$isOk)
            throw new CHttpException(404, 'Image incorrect');

        // Upload file
        $path = Yii::getPathOfAlias('webroot.store.upload').'/';

        $imageName = basename($_FILES['upload']['name']);
        $ext = strrchr($imageName, '.');
        $imageName = md5(time().$imageName).($ext?$ext:'');

        // Create folder if not exists
        if (!is_dir($path))
            mkdir($path, 755);

        $res = move_uploaded_file($_FILES['upload']['tmp_name'], $path.$imageName);
        if ($res === false)
            $msg = 'Image not loaded';
        else
            $msg = 'Image is loaded';

        $funcNum = $_GET['CKEditorFuncNum'] ;
        $url = CHtml::normalizeUrl('/store/upload/'.$imageName);

        $output = '<html><body><script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'","'.$msg.'");</script></body></html>';
        echo $output;
        Yii::app()->end();
    }


    /**
     * Upload image
     */
    public function actionUploadFile()
    {
        $isOk = isset($_FILES['upload']) && $_FILES['upload']['error']==0 && $_FILES['upload']['size']>0;
        if (!$isOk)
            throw new CHttpException(404, 'Page not found');

        // TODO: check MIME-type

        // Upload file
        $path = Yii::getPathOfAlias('webroot.store.uploadFiles').'/';

        $fileName = basename($_FILES['upload']['name']);
        $ext = strrchr($fileName, '.');
        $fileName = md5(time().$fileName).($ext?$ext:'');

        // Create folder if not exists
        if (!is_dir($path))
            mkdir($path, 755);

        $res = move_uploaded_file($_FILES['upload']['tmp_name'], $path.$fileName);
        if ($res === false)
            $msg = 'File not loaded';
        else
            $msg = 'File is loaded';

        $funcNum = $_GET['CKEditorFuncNum'] ;
        $url = CHtml::normalizeUrl('/store/uploadFiles/'.$fileName);

        $output = '<html><body><script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'","'.$msg.'");</script></body></html>';
        echo $output;
        Yii::app()->end();
    }
}