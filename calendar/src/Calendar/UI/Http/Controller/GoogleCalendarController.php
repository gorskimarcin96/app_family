<?php

namespace App\Calendar\UI\Http\Controller;

use App\Calendar\Infrastructure\Google\GoogleCalendarClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleCalendarController extends AbstractController
{
    #[Route('/oauth2/start', name: 'google_oauth_start')]
    public function start(Request $request): Response
    {
        $google = new GoogleCalendarClient($request->getSession());

        return $this->redirect($google->getClient()->createAuthUrl());
    }

    #[Route('/oauth2/callback', name: 'google_oauth_callback')]
    public function callback(Request $request): Response
    {
        $google = new GoogleCalendarClient($request->getSession());
        $client = $google->getClient();
        $code = $request->query->get('code');

        if ($code) {
            $token = $client->fetchAccessTokenWithAuthCode($code);
            $request->getSession()->set('google_access_token', $token);
        }

        return $this->redirectToRoute('calendar_events_list');
    }

    #[Route('/calendar/events', name: 'calendar_events_list')]
    public function list(Request $request): Response
    {
        $google = new GoogleCalendarClient($request->getSession());
        $service = $google->getService();

        $events = $service->events->listEvents(
            'primary',
            [
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date(DATE_RFC3339),
            ],
        );

        return $this->json($events->getItems());
    }

    #[Route('/calendar/events/create', name: 'calendar_event_create')]
    public function create(Request $request): Response
    {
        $google = new GoogleCalendarClient($request->getSession());
        $service = $google->getService();

        $event = new \Google_Service_Calendar_Event(
            [
                'summary' => 'Testowe wydarzenie',
                'start' => ['dateTime' => '2025-06-01T10:00:00+02:00'],
                'end' => ['dateTime' => '2025-06-01T11:00:00+02:00'],
            ],
        );

        $created = $service->events->insert('primary', $event);

        return $this->json($created);
    }

    #[Route('/calendar/events/update/{id}', name: 'calendar_event_update')]
    public function update(string $id, Request $request): Response
    {
        $google = new GoogleCalendarClient($request->getSession());
        $service = $google->getService();
        $event = $service->events->get('primary', $id);

        $event->setSummary('Zmieniony tytuł');
        $updated = $service->events->update('primary', $event->getId(), $event);

        return $this->json($updated);
    }

    #[Route('/calendar/events/delete/{id}', name: 'calendar_event_delete')]
    public function delete(string $id, Request $request): Response
    {
        $google = new GoogleCalendarClient($request->getSession());
        $service = $google->getService();
        $service->events->delete('primary', $id);

        return $this->json(['status' => 'deleted']);
    }
}
