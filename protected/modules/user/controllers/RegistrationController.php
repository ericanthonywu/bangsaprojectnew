<?php

class RegistrationController extends RController
{
	public $defaultAction = 'registration';
	
	public function filters()
	{
		return array(
			'rights'
			/*'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request*/
		);
	}
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration() {
            $model = new RegistrationForm;
            $profile=new Profile;
            $profile->regMode = true;
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model,$profile));
				Yii::app()->end(); 
			}
			
		    if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
		    	if(isset($_POST['RegistrationForm'])) {
		    		// disable register 
		    		// $this->redirect(Yii::app()->createUrl('auth/thankyou'));
			    	Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
			    	$this->redirect(Yii::app()->createUrl('user/registration'));
			    	exit; 

					$model->attributes=$_POST['RegistrationForm'];
					$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
					if($model->validate()&&$profile->validate())
					{
						$model->scenario = NULL;
						$profile->scenario = NULL;
						$soucePassword = $model->password;
						$model->activkey=md5("azzamedia".microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
						$model->superuser=0; 
						// $model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						$model->status=( User::STATUS_NOACTIVE );
						
						if ($model->save()) {
							$profile->user_id=$model->id;
							$profile->save();
							if (Yii::app()->controller->module->sendActivationMail) {
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
								UserModule::sendMail($model->email,UserModule::t("Anda mendaftar pada situs {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Klik link berikut {activation_url} agar proses registrasi anda lengkap",array('{activation_url}'=>$activation_url)));
							}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(Yii::app()->controller->module->returnUrl);
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
								} else {
									$mail = new YiiMailer();
									//$mail->clearLayout();//if layout is already set in config
									$mail->setTo($model->email);
									//$mail->setTo(array('xxx@qq.com'=>'Scott QQ','WWSP_NOREPLY@qq.com'=>'WWSP QQ'));
									//$mail->setCC('xxx@gmail.com');
									$mail->setSubject('Konfirmasi Pendaftaran Harian Bangsa Online');
									$aw = Yii::app()->getBaseUrl(true).'/auth/activation/'.$model->activkey."-".$model->id;
									$mail->setBody("Klik link dibawah ini untuk konfirmasi pendaftaran user Harian Bangsa Online.<br /><a href='$aw'>Link</a>");
									//$mail->setAttachment(array('something.pdf'=>'Some file','something_else.pdf'=>'Another file'));
									$mail->IsSMTP();
									if ($mail->send()) {} else {}
									Yii::app()->user->setFlash('success',UserModule::t("Terimakasih data anda sudah tersimpan. Untuk bisa login, mohon tunggu paling lambat 1x12 jam untuk verifikasi dari kami"));
								}
								$this->redirect(Yii::app()->createUrl('auth/thankyou'));
							}
							
						}
					} else $profile->validate();
				}
			    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
		    }
	}
}