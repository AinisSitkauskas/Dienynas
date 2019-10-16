<?php

interface Database {

     /**
     * 
     * @param string $userName
     * @return User
     */
    public function getUser($userName);

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
