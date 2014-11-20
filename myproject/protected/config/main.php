<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Первое web-приложение!',
    'language'=>'ru',
	// preloading 'log' component
	'preload'=>array('log'),


    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.message.*',
        'bootstrap.helpers.TbHtml',
        //'application.modules.messages.models.*',
        //'application.modules.messages.components.*',
        /*'application.modules.rights.*',
        'application.modules.rights.models.*',
        'application.modules.rights.components.*',*/
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'mypassword',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
            //'generatorPaths' => array('bootstrap.gii'),
		),

        'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => true,
            # allow access for non-activated users
            'loginNotActiv' => false,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
            # automatically login from registration
            'autoLogin' => true,
            # registration path
            'registrationUrl' => array('/user/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            'loginUrl' => array('/user/login'),
            # page after login
            'returnUrl' => array('/user/profile'),
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
        'friend' => array(
            'userModel' => 'User',
            'getNameMethod' => 'getFullName',
            'getSuggestMethod' => 'getSuggest',
        ),
        'mchat' => array(
            'userModel' => 'User',
        ),
        'message' => array(
            'userModel' => 'User',
            'getNameMethod' => 'getFullName',
            'getSuggestMethod' => 'getSuggest',
        ),

        /*'rights'=>array(
            'install'=>false, // Enables the installer.
        ),*/


	),

	// application components
	'components'=>array(

        'widgetFactory' => array(
            'widgets' => array(
                'CLinkPager' => array(
                    'header' => '',
                    'nextPageLabel'=>'→',
                    'prevPageLabel'=>'←',
                    'lastPageLabel'=>'»',
                    'firstPageLabel'=>'«',
                    'selectedPageCssClass' => 'active',
                    'hiddenPageCssClass' => 'disabled',
                    'htmlOptions' => array(
                        'class' => 'pagination pagination-centered',
                        'style' => 'padding-left: 33% !important',
                    ),
                ),
            ),
        ),

        'curl' => array(
            'class' => 'ext.curl.Curl',
            'options' => array(/* additional curl options */),
        ),
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache'.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'services' => array(
                /*'google' => array(
                    'class' => 'GoogleOpenIDService',
                ),
                'google-oauth' => array(
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'GoogleOAuthService',
                    'client_id' => '',
                    'client_secret' => '',
                    'title' => 'Google (OAuth2)',
                ),
                'yandex' => array(
                    'class' => 'YandexOpenIDService',
                    'title' => 'Yandex',
                ),
                'yandex-oauth' => array(
                    // register your app here: https://oauth.yandex.ru/client/my
                    'class' => 'YandexOAuthService',
                    'client_id' => '',
                    'client_secret' => '',
                    'title' => 'Yandex (OAuth)',
                ),*/
                'twitter' => array(
                    // register your app here: https://dev.twitter.com/apps/new
                    'class' => 'TwitterOAuthService',
                    'key' => 'lo19ugFMqDNqllWdUT5nHdyW9',
                    'secret' => 'szRTVVFLi5yipQsngh0W1Oy5CB8BFlaPuuhEgHqeUmPvI7h4Ky',
                ),
                /*'linkedin' => array(
                    // register your app here: https://www.linkedin.com/secure/developer
                    'class' => 'LinkedinOAuthService',
                    'key' => '',
                    'secret' => '',
                ),*/
                'facebook' => array(
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'CustomFacebookService',
                    'client_id' => '687121514736993',
                    'client_secret' => '2a8946642859488c347afd15b037b21d',
                ),
                /*'yahoo' => array(
                    'class' => 'YahooOpenIDService',
                ),
                'steam' => array(
                    'class' => 'SteamOpenIDService',
                ),
                'live' => array(
                    // register your app here: https://manage.dev.live.com/Applications/Index
                    'class' => 'LiveOAuthService',
                    'client_id' => '',
                    'client_secret' => '',
                ),*/
                'vkontakte' => array(
                    // register your app here: https://vk.com/editapp?act=create&site=1
                    'class' => 'CustomVKontakteService',
                    'client_id' => '4637575',
                    'client_secret' => 'SG8Sb3hoIcBPYV4Worpi',
                    'title' => 'VKontakte',
                ),
                /*'mailru' => array(
                    // register your app here: http://api.mail.ru/sites/my/add
                    'class' => 'MailruOAuthService',
                    'client_id' => '',
                    'client_secret' => '',
                ),
                'moikrug' => array(
                    // register your app here: https://oauth.yandex.ru/client/my
                    'class' => 'MoikrugOAuthService',
                    'client_id' => '',
                    'client_secret' => '',
                    //'title' => 'Moi Krug',
                ),
                'github' => array(
                    // register your app here: https://github.com/settings/applications
                    'class' => 'GitHubOAuthService',
                    'client_id' => '',
                    'client_secret' => '',
                ),
                'odnoklassniki' => array(
                    // register your app here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
                    'class' => 'OdnoklassnikiOAuthService',
                    'client_id' => '...',
                    'client_public' => '...',
                    'client_secret' => '...',
                    'title' => 'Odnokl.',
                ),*/
            ),
        ),
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
        'cache' => array(
            //'class' => 'CApcCache',
            'class' => 'CFileCache',
        ),


        /*'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),*/

        /*'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),*/

        'user'=>array(
            'class' => 'AuthWebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),
        /*'authManager'=>array(
            'class'=>'RDbAuthManager',
            'defaultRoles' => array('Guest') // дефолтная роль
        ),*/

		// uncomment the following to enable URLs in path-format

        // uncomment the following to enable URLs in path-format
        /*'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(

            ),
        ),  */

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => false,
			'rules'=>array(
                'login/<service:(google|google-oauth|yandex|yandex-oauth|twitter|linkedin|vkontakte|facebook|steam|yahoo|mailru|moikrug|github|live|odnoklassniki)>' => 'user/login',
                'login' => 'user/login',
                'logout' => 'user/logout',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

                //'' => 'site/index',


			),
		),

        /*'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        ),*/
        // uncomment the following to use a MySQL database

        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=myproject',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);