<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {

            $serviceName = Yii::app()->request->getQuery('service');
            if (isset($serviceName)) {
                /** @var $eauth EAuthServiceBase */
                $eauth = Yii::app()->eauth->getIdentity($serviceName);
                $eauth->redirectUrl = Yii::app()->user->returnUrl;
                $eauth->cancelUrl = $this->createAbsoluteUrl('/login');

                try {
                    if ($eauth->authenticate()) {
                        $identity = new EAuthUserIdentity($eauth);
                        //echo "step 2: identity=";
                        //exit();
                        //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());

                        // successful authentication
                        if ($identity->authenticate()) {
                            //echo $identity->errorCode;
                           // echo "step 3: identity=";//.$identity->id;
                           // exit();
                            Yii::app()->user->login($identity);
                            //Yii::app()->user->name="12";
                            //var_dump($identity->id, $identity->name, Yii::app()->user->id);exit;
                           // echo "step 4: identity=";
                            //exit();
                            // Save the attributes to display it in layouts/main.php
                            $session = Yii::app()->session;
                            $session['eauth_profile'] = $eauth->attributes;
                            //exit();
                            // redirect and close the popup window if needed
                            $eauth->redirect();
                            //$this->redirect(Yii::app()->user->returnUrl);
                        }
                        else {
                            //echo $identity->errorCode;
                            //exit();
                            // close popup window and redirect to cancelUrl
                            //if ($identity->errorCode === EAuthUserIdentity::ERROR_REPEAT_EMAIL){
                            //    Yii::app()->user->setFlash('error', 'Данный e-mail уже используется в другом аккуанте.');
                            //}

                            $eauth->cancel();
                            //$eauth->redirect(Yii::app()->BaseUrl.'/login');
                            //$this->redirect(Yii::app()->controller->module->returnUrl);
                        }
                    }

                    // Something went wrong, redirect back to login page
                    //$this->redirect(array('user/login'));
                    //echo "xuy";
                    //exit();
                }
                catch (EAuthException $e) {
                    // save authentication error to session
                    Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

                    // close popup window and redirect to cancelUrl
                    $eauth->redirect($eauth->getCancelUrl());
                }
            }


			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
            if (isset($_POST['modal'])) $this->renderPartial('/user/login',array('model'=>$model));
			// display the login form
			else $this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}

}