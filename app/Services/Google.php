<?php

namespace App\Services;

class Google
{
    protected $client;

    function __construct()
    {
        $client = new \Google_Client();
        $client->setClientId(config('services.google-api.client_id'));
        $client->setClientSecret(config('services.google-api.client_secret'));
        $client->setRedirectUri(config('services.google-api.redirect_uri'));
        $client->setScopes(config('services.google-api.scopes'));
        $client->setApprovalPrompt(config('services.google-api.approval_prompt'));
        $client->setAccessType(config('services.google-api.access_type'));
        $client->setIncludeGrantedScopes(config('services.google-api.include_granted_scopes'));
        $this->client = $client;
    }
    public function connectUsing($token)
    {
        $this->client->setAccessToken($token);

        return $this;
    }

    public function service($service)
    {
        $classname = "Google_Service_$service";

        return new $classname($this->client);
    }

    public function __call($method, $args)
    {
        if (! method_exists($this->client, $method)) {
            throw new \Exception("Call to undefined method '{$method}'");
        }

        return call_user_func_array([$this->client, $method], $args);
    }
}