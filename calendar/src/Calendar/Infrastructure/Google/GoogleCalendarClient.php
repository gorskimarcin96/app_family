<?php

namespace App\Calendar\Infrastructure\Google;

use Google_Client;
use Google_Service_Calendar;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GoogleCalendarClient
{
    private Google_Client $client;

    public function __construct(SessionInterface $session)
    {
        $this->client = new Google_Client();
        $this->client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        if ($session->has('google_access_token')) {
            $this->client->setAccessToken($session->get('google_access_token'));
        }
    }

    public function getClient(): Google_Client
    {
        return $this->client;
    }

    public function getService(): Google_Service_Calendar
    {
        return new Google_Service_Calendar($this->client);
    }
}
