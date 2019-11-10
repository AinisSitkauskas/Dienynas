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
     * @param string $userName
     * @return boolean
     */
    public function userExist($userName);

    /**
     *
     * @param User $user
     * @return boolean
     */
    public function saveUser($user);

    /**
     *
     * @param User $user
     * @return boolean
     */
    public function deleteUser($user);
}
