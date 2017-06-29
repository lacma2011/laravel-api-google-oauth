<?php

namespace App\Providers\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\AuthenticationException;

/**
 * A UserProvider used by our API
 * 
 * Implements Laravel's Auth\UserProvider interface to verify credentials of user
 */
class GoogleOAuthProvider implements UserProvider {

    /**
     * I will not provide a way to authenticate based on ID (it's Google OAuth, I can't)
     * 
     * @param type $identifier
     * @return null
     */
    public function retrieveById($identifier) {
        return NULL;
    }

    /**
     * Not doing retrieve by "remember me" token for Google OAuth
     * 
     * @param type $identifier
     * @param type $token
     * @return null
     */
    public function retrieveByToken($identifier, $token) {
        return NULL;
    }

    /**
     * Not doing "remember me" for google oauth
     * 
     * @param Authenticatable $user
     * @param type $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token) {
        // do nothing
    }

    /**
     * Check credentials of ID Token from Google OAuth
     * 
     * @param array $credentials
     * @throws AuthenticationException for various reasons the token is invalid
     * @return GoogleOAuthAuthenticable|void
     */
    public function retrieveByCredentials(array $credentials) {
        // api_token is Google API OAuth ID token
        $token = $credentials['api_token'];

        $client = new \Google_Client();

        if ($token === '1') {
            throw new AuthenticationException('Need valid API token.', ['api']);
        }

        if (!$oauth_credentials = $this->getOAuthCredentialsFile("./oauth-credentials.json")) {
            throw new AuthenticationException('Credentials file not found or not accessible.', ['api']);
        }

        $ticket = $client->verifyIdToken($token);
        if ($ticket) {
            // Must match the Google App ID
            if ($ticket['aud'] !== '1068162703133-rvuj8ej1i6navlouq356tduot1f88jjt.apps.googleusercontent.com') {
                throw new AuthenticationException('ID Token has invalid App ID.', ['api']);
            }
            // Must not have expired
            if ($ticket['exp'] < time()) {
                throw new AuthenticationException('ID Token expired.', ['api']);
            }
        } else {
            throw new AuthenticationException('ID Token failed validation.', ['api']);
        }

        // valid
        return new GoogleOAuthAuthenticable($ticket);
    }

    /**
     * The retrieveByCredentials method receives the array of credentials passed to the Auth::attempt 
     * method when attempting to sign into an application. The method should then "query" the 
     * underlying persistent storage for the user matching those credentials. Typically, this method will 
     * run a query with a "where" condition on $credentials['username']. The method should then return 
     * an implementation of Authenticatable. This method should not attempt to do any password validation 
     * or authentication.
     * 
     * @param Authenticatable $user
     * @param array $credentials
     * @return boolean
     */
    public function validateCredentials(Authenticatable $user, array $credentials) {
        $oauthAuthenticatable = $this->retrieveByCredentials($credentials);
        if ($oauthAuthenticatable->getAuthIdentifierName() === $user->getAuthIdentifierName() &&
                $oauthAuthenticatable->getAuthIdentifier() === $user->getAuthIdentifier()) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get path to OAuth credentials file if it exists.
     * 
     * @param type $file
     * @return null|string
     */
    private function getOAuthCredentialsFile($file) {
        // oauth2 creds
        $oauth_creds = base_path() . '/' . $file;
        if (file_exists($oauth_creds)) {
            return $oauth_creds;
        }
        return false;
    }
}
