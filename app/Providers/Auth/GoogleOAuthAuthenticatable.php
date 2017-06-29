<?php

namespace App\Providers\Auth;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use \Illuminate\Auth\Authenticatable;

/**
 * Implements Laravel's Auth\Authenticatable interface to store authenticated user
 */
class GoogleOAuthAuthenticable implements AuthenticatableContract {

    use Authenticatable;

    /**
     * Name in the google plus profile
     * 
     * @var string 
     */
    public $name;

    /**
     * ID of the google plus profile
     * 
     * @var string 
     */
    private $google_id;

    function __construct($ticket) {
        $this->name = $ticket['name'];
        $this->google_id = $ticket['sub'];
    }

    public function getAuthIdentifierName(){
        return "google_name";
    }

    public function getAuthIdentifier(){
        return $this->google_id;
    }

    /**
     * Not really doing anything because our API does not need this
     */
    public function getAuthPassword() {
        return "ssdfsdf!!saf";
    }

    /**
     * Get the token value for the "remember me" session.
     * 
     * Not really doing anything because our API does not need this
     *
     * @return string
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return $this->{$this->getRememberTokenName()};
        }
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * Not really doing anything because our API does not need this
     * 
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

}
