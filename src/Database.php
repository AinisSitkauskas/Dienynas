<?php

interface Database {

    function __construct();

     /**
     * 
     * @param User $user
     * @return User
     */
    public function getUser($user);

    /**
     * 
     * @param User $user
     * @return boolean
     */
    public function userExist($user);

    /**
     * 
     * @param User $user
     * @return boolean
     */
    public function registerUser($user);

    /**
     * 
     * @param User $user
     * @return boolean
     */
    public function deleteUser($user);
}
