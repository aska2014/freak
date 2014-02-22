<?php namespace Kareem3d\Freak\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Kareem3d\Freak\Freak;
use Kareem3d\Helper\Helper;
use Kareem3d\Images\Image;
use Kareem3d\Images\Version;
use Kareem3d\Membership\Account;
use Kareem3d\Membership\Role;
use Kareem3d\Membership\UserInfo;
use Kareem3d\Responser\Responser;

class RegisterController extends FreakBaseController {

    /**
     * @var \Kareem3d\Membership\Account
     */
    protected $users;

    /**
     * @var \Kareem3d\Membership\Role
     */
    protected $roles;

    /**
     * @var \Kareem3d\Membership\UserInfo
     */
    protected $userInfos;

    /**
     * @var \Kareem3d\Images\Image
     */
    protected $images;

    /**
     * @var \Kareem3d\Images\Version
     */
    protected $versions;

    /**
     * @var \Kareem3d\Freak\Freak
     */
    protected $freak;

    /**
     * @param \Kareem3d\Membership\Account $users
     * @param \Kareem3d\Membership\Role $roles
     * @param \Kareem3d\Membership\UserInfo $userInfos
     * @param \Kareem3d\Images\Image $images
     * @param \Kareem3d\Images\Version $versions
     * @param Freak $freak
     * @return \Kareem3d\Freak\Controllers\RegisterController
     */
    public function __construct( Account $users, Role $roles, UserInfo $userInfos, Image $images, Version $versions, Freak $freak )
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->userInfos = $userInfos;
        $this->images = $images;
        $this->versions = $versions;
        $this->freak = $freak;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return View::make('login.index');
    }

    /**
     * @return mixed
     */
    public function postIndex()
    {
        // Validate ControlPanel password and register user
        if($this->validateControlPanelPassword() && ($user = $this->registerUser()))
        {
            // Create administrator request
            $this->createAdminRequest( $user );
        }

        if(! $this->emptyErrors())
        {
            return Responser::errors($this->getErrors());
        }

        return Responser::success('You have registered successfully.<br /> An admin from you application has to <b>accept</b> you before you can login.');
    }

    /**
     * @return bool
     */
    protected function validateControlPanelPassword()
    {
        if($this->freak->checkPassword($this->getFreakPassword())) return true;

        $this->addErrors('Application password is incorrect');
    }

    /**
     * @return Account|bool
     */
    protected function registerUser()
    {
        $userInputs = $this->getUserInputs();

        // If we have this user in our database then check if he entered the correct password
        if($user = $this->users->getByEmail($userInputs['email']))
        {
            // If user has password and it's not the correct password
            if(!$user->checkPassword($userInputs['password']))
            {
                $this->addErrors('This email already exists but the password is incorrect');

                return false;
            }

            // Fill user with inputs
            $user->fill($userInputs);

            // Escape email rule (Because email already exists)
            $user->escapeRule('email');
        }
        else
        {
            $user = $this->users->newInstance($userInputs);
        }

        // If user is not valid
        if($user->validate())
        {
            // Create user info inputs
            $userInfo = $this->userInfos->newInstance($this->getUserInfoInputs());

            // If user is valid
            $user->setInfo($userInfo);

            $user->save();

            // Set default profile image
            $user->replaceImage( $this->getDefaultProfileImage(), 'profile' );

            return $user;
        }

        $this->addErrors($user->getValidatorMessages());

        return false;
    }

    /**
     * @return Image
     */
    protected function getDefaultProfileImage()
    {
        $image = $this->images->create(array('title' => 'Profile default image'));

        if($version = $this->versions->generate('http://s3.amazonaws.com/37assets/svn/765-default-avatar.png'))
        {
            $image->add($version);
        }

        return $image;
    }

    /**
     * @param \Kareem3d\Membership\Account $user
     */
    protected function createAdminRequest( Account $user)
    {
        $this->roles->makeSureRoleExists('administrator');
        $this->roles->makeSureRoleExists('developer');

        if($user->hasRole('administrator'))
        {
            $this->addErrors('You already are an administrator please log in to access the control panel.');
        }

        // Check if user has already requested to be an administrator ?
        elseif($request = $user->getRequested('administrator'))
        {
            $this->addErrors('You have requested to enter this control panel before and your request status is: ' . $request->status);
        }

        elseif($this->roles->noOneExistsIn('administrator'))
        {
            $user->addRoleForever('administrator');
            $user->addRoleForever('developer');
        }

        else
        {
            $user->addRoleRequest('administrator', 'Requested from the admin register panel.');
        }
    }

    /**
     * @return mixed
     */
    protected function getUserInputs()
    {
        return Helper::instance()->arrayGetKeys(Input::get('Register'), array('email', 'password'));
    }

    /**
     * @return mixed
     */
    protected function getUserInfoInputs()
    {
        return array('name' => Input::get('Register.name'));
    }

    /**
     * @return mixed
     */
    protected function getFreakPassword()
    {
        return Input::get('ControlPanel.password');
    }
}