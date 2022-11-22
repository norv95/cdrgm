<?php

namespace App\DataGateway\Client;

class GAClient
{
    const URL = 'https://analytics.google.com';

    /**
     * Get Auth token from analytics provider
     * @return string
     */
    public function getAuthToken(array $params): string
    {
        //implement authorization token receiving
        return '213sdfas324324324';
    }

    /**
     * Request Analytics from Google Analytics API (Mocked)
     * @param array $params
     * @return mixed
     */
    public function getAnalytics(array $params)
    {
        $sslContext = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ]
        ];

        $filterString = implode('=', $params);
        /*
         * $analyticsData = file_get_contents(
            self::URL . $id . '?' .  $filterString, false,
            context: stream_context_create($sslContext)
        );*/

        $analyticsData = '{
            "error": "",
            "message": "",
            "data": [
                {
                    "No.": "1",
                    "date": "Nov 22, 2021 (Tue)",
                    "sessions": "3,284",
                    "visitors": "2,929",
                    "first_time visitors": "2,443",
                    "returning": "486",
                    "referred": "2,233",
                    "searching": "2,187",
                    "exit_link": "7",
                    "pageviews": "8,193",
                    "segment": "",
                    "single_event_sessions": "1,324",
                    "total_duration_all_sessions": "262,813",
                    "sessionsWithMoreThanOneEvent": "1,960",
                    "google_analytics": "150",
                    "positive_guys": "5000"
                },
                {
                    "No.": "2",
                    "date": "Nov 22, 2022 (Tue)",
                    "sessions": "3,284",
                    "visitors": "2,929",
                    "first_time_visitors": "2,443",
                    "returning": "486",
                    "referred": "2,233",
                    "searching": "2,187",
                    "exit_link": "7",
                    "pageviews": "8,193",
                    "single_event_sessions": "1,324",
                    "total_duration_all_sessions": "262,813",
                    "segment": "",
                    "sessionsWithMoreThanOneEvent": "",
                    "google_analytics": "250",
                    "positive_guys": "6000"
                }
            ]
        }';

        return $analyticsData;
    }
}
