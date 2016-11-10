<?php

namespace components;

class FlashMessage extends \Component
{
    protected function checkProperty()
    {
        if (!isset($this->app->session->flashMessages) || !is_array($this->app->session->flashMessages)) {
            $this->app->session->flashMessages = [];
        }
    }

    public function add($message)
    {
        $this->checkProperty();

        $this->app->session->flashMessages = array_merge($this->app->session->flashMessages, [$message]);
    }

    public function getAll()
    {
        $this->checkProperty();

        $messages = $this->app->session->flashMessages;
        $this->app->session->flashMessages = [];

        return $messages;
    }
}