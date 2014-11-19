<?php
/**
 * EAuthUserIdentity class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * EAuthUserIdentity is a base User Identity class to authenticate with EAuth.
 *
 * @package application.extensions.eauth
 */
class EAuthUserIdentity extends CBaseUserIdentity {

	const ERROR_NOT_AUTHENTICATED = 3;
    const ERROR_REPEAT_EMAIL = 11;

	/**
	 * @var EAuthServiceBase the authorization service instance.
	 */
	protected $service;

	/**
	 * @var string the unique identifier for the identity.
	 */
	protected $id;

	/**
	 * @var string the display name for the identity.
	 */
	protected $name;

	/**
	 * Constructor.
	 *
	 * @param EAuthServiceBase $service the authorization service instance.
	 */
	public function __construct($service) {
		$this->service = $service;
	}

	/**
	 * Authenticates a user based on {@link service}.
	 * This method is required by {@link IUserIdentity}.
	 *
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
        //echo "xttt";
		if ($this->service->isAuthenticated) {

            $email=null;
            $identity=null;
            //echo $this->service->getServiceName();
            //exit();

            if ($this->service->getServiceName()=="vkontakte"){
                //var_dump($this->service->id, $this->service, $this->service->getAttribute('name'), $this->service->getAttribute('email'), Yii::app()->user->id);exit;
                $identity=$this->service->id;
                $email=$this->service->getAttribute('email');
            }
            else
            if ($this->service->getServiceName()=="facebook"){
                $email=$this->service->getAttribute('email');
                $identity=$this->service->id;
            }

            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
            if (!$email) return !$this->errorCode;

            //var_dump($this->service->id, $this->service, $this->service->getAttribute('name'), $this->service->getAttribute('email'), Yii::app()->user->id);exit;
            //var_dump($this->service->id); exit;
            $this->errorCode = self::ERROR_NONE;

            $userModel = User::model()->Find(
                array('condition'=>"email=:email", 'params'=>array(
                    ":email"=>$email,
                    //":identity"=>$this->service->id,

                ))
            );

            if ($userModel != null) {
                $userServiceModel = UserService::model()->Find(
                    array('condition'=>"service=:service AND identity=:identity AND uid=:uid", 'params'=>array(
                        ":service"=>$this->service->getServiceName(),
                        ":identity"=>$identity,
                        ":uid"=>$userModel->id,
                    ))
                );

                //print_r($userServiceModel);

                if ($userServiceModel== null) {
                    $userServiceModel=new UserService;
                    $userServiceModel->uid=$userModel->id;
                    $userServiceModel->service=$this->service->getServiceName();
                    $userServiceModel->identity=$identity;
                    if (!$userServiceModel->save()){
                        //$this->errorCode = self::ERROR_INSERT_USER_SERVICE;
                        print_r($userServiceModel->getErrors());
                    }
                }
                //echo "yeessss";
                //exit();

            }
            else {
                $userModel = new User;
                $profile=new Profile;
                Profile::$regMode = true;

                $profile->firstname=$this->service->getAttribute('first_name');
                $profile->lastname=$this->service->getAttribute('last_name');

                $userModel->superuser=0;
                $userModel->status=(User::STATUS_ACTIVE);
                $userModel->username="userauth".substr(md5(microtime()),0,10);
                $userModel->password=md5(microtime()."lion");
                $userModel->create_at=date("Y-m-d h:i:s");
                $userModel->lastvisit_at=date("Y-m-d h:i:s");
                $userModel->email=$email;//substr(md5(microtime()),0,5)."@mail.ru";//$this->service->getAttribute('email');


                //$userModel->service=$this->service->getServiceName();
                //$userModel->identity=$this->service->id;//$this->service->id;

                //print_r($userModel);
                //exit;

                if (!$userModel->save()){
                    $this->errorCode = self::ERROR_INSERT_USER_SERVICE;
                    print_r($userModel->getErrors());
                }
                //echo "step 1";
                $profile->user_id=$userModel->id;
                //$profile->save();
                $profile->date_birth=NULL;//"1993-12-12";
                if (!$profile->save()){
                    //echo $profile->date_birth;
                    //echo "step 2";
                    //$this->errorCode = self::ERROR_INSERT_USER_SERVICE;
                    print_r($profile->getErrors());
                }
                //exit();
                Profile::$regMode = false;


                $userServiceModel=new UserService;
                $userServiceModel->uid=$userModel->id;
                $userServiceModel->service=$this->service->getServiceName();
                $userServiceModel->identity=$identity;
                if (!$userServiceModel->save()){
                    //$this->errorCode = self::ERROR_INSERT_USER_SERVICE;
                    print_r($userServiceModel->getErrors());
                }

            }

            //echo "alling!"; exit();




            /*
            $userModel = User::model()->Find(
                array('condition'=>"service=:service AND identity=:identity", 'params'=>array(
                    ":service"=>$this->service->getServiceName(),
                    ":identity"=>$this->service->id,

                ))
            );
            //print_r($userModel);
            if ($userModel != null) {

            } else {
                $userModel = new User;
                $profile=new Profile;
                Profile::$regMode = true;

                $profile->firstname=$this->service->getAttribute('first_name');
                $profile->lastname=$this->service->getAttribute('last_name');


                $userModel->superuser=0;
                $userModel->status=(User::STATUS_ACTIVE);
                $userModel->username="userauth".substr(md5(microtime()),0,10);
                $userModel->password=md5(microtime()."lion");
                $userModel->create_at=date("Y-m-d h:i:s");
                $userModel->lastvisit_at=date("Y-m-d h:i:s");
                $userModel->email=substr(md5(microtime()),0,5)."@mail.ru";//$this->service->getAttribute('email');
                $userModel->service=$this->service->getServiceName();
                $userModel->identity=$this->service->id;//$this->service->id;

                //print_r($userModel);
                //exit;

                if (!$userModel->save()){
                    $this->errorCode = self::ERROR_INSERT_USER_SERVICE;
                    print_r($userModel->getErrors());
                }
                //echo "step 1";
                $profile->user_id=$userModel->id;
                //$profile->save();
                $profile->date_birth="1993-12-12";
                if (!$profile->save()){
                    //echo $profile->date_birth;
                    //echo "step 2";
                    //$this->errorCode = self::ERROR_INSERT_USER_SERVICE;
                    print_r($profile->getErrors());
                }
                //exit();
                Profile::$regMode = false;

            }*/

            //----------------------------------------------------------

            //exit();
            //eee

            if (!$this->errorCode) {
                //echo "xuy";
                $this->id = $userModel->id; //$this->service->id;
                $this->name = $this->service->getAttribute('name'); //$this->service->getAttribute('name');

                $this->setState('id', $this->id);
                $this->setState('name', $this->name);
                //$this->setState('username', $this->name);
                $this->setState('service', $this->service->serviceName);
                //echo "xuy2";

                //echo $this->name;
                //exit();

            }

			// You can save all given attributes in session.
			//$attributes = $this->service->getAttributes();
			//$session = Yii::app()->session;
			//$session['eauth_attributes'][$this->service->serviceName] = $attributes;

			//$this->errorCode = self::ERROR_NONE;
		}
		else {
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}
        //echo "yeees";
        //$this->errorCode = self::ERROR_REPEAT_EMAIL;
		return !$this->errorCode;
	}

	/**
	 * Returns the unique identifier for the identity.
	 * This method is required by {@link IUserIdentity}.
	 *
	 * @return string the unique identifier for the identity.
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the display name for the identity.
	 * This method is required by {@link IUserIdentity}.
	 *
	 * @return string the display name for the identity.
	 */
	public function getName() {
		return $this->name;
	}
}
