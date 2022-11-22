<?php

namespace App\Model;

class GAItemModel
{
    /**
     * @param int $id
     * @param int $userId
     * @param string $title
     * @param string $body
     */
    public function __construct(

            private ?string $date = null,
            private ?string $sessions = null,
            private ?string $visitors = null,
            private ?string $first_time_visitors = null,
            private ?string $returning = null,
            private ?string $referred = null,
            private ?string $searching = null,
            private ?string $exit_link = null,
            private ?string $pageviews = null,
            private ?string $single_event_sessions = null,
            private ?string $total_duration_all_sessions = null,
            private ?string $segment = null,
            private ?string $sessionsWithMoreThanOneEvent = null,
            private ?string $google_analytics = null,
            private ?string $positive_guys = null,
    ){
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getSessions(): ?string
    {
        return $this->sessions;
    }

    /**
     * @return string|null
     */
    public function getVisitors(): ?string
    {
        return $this->visitors;
    }

    /**
     * @return string|null
     */
    public function getFirstTimeVisitors(): ?string
    {
        return $this->first_time_visitors;
    }

    /**
     * @return string|null
     */
    public function getReturning(): ?string
    {
        return $this->returning;
    }

    /**
     * @return string|null
     */
    public function getReferred(): ?string
    {
        return $this->referred;
    }

    /**
     * @return string|null
     */
    public function getSearching(): ?string
    {
        return $this->searching;
    }

    /**
     * @return string|null
     */
    public function getExitLink(): ?string
    {
        return $this->exit_link;
    }

    /**
     * @return string|null
     */
    public function getPageviews(): ?string
    {
        return $this->pageviews;
    }

    /**
     * @return string|null
     */
    public function getSingleEventSessions(): ?string
    {
        return $this->single_event_sessions;
    }

    /**
     * @return string|null
     */
    public function getTotalDurationAllSessions(): ?string
    {
        return $this->total_duration_all_sessions;
    }

    /**
     * @return string|null
     */
    public function getSegment(): ?string
    {
        return $this->segment;
    }

    /**
     * @return string|null
     */
    public function getSessionsWithMoreThanOneEvent(): ?string
    {
        return $this->sessionsWithMoreThanOneEvent;
    }

    /**
     * @return string|null
     */
    public function getGoogleAnalytics(): ?string
    {
        return $this->google_analytics;
    }

    /**
     * @return string|null
     */
    public function getPositiveGuys(): ?string
    {
        return $this->positive_guys;
    }

}
