<?php

namespace App\Helpers;

class NotificationHelper
{
    /**
     * Flash a success message to the session
     *
     * @param string $message
     * @return void
     */
    public static function success(string $message): void
    {
        session()->flash('success', $message);
    }

    /**
     * Flash an error message to the session
     *
     * @param string $message
     * @return void
     */
    public static function error(string $message): void
    {
        session()->flash('error', $message);
    }

    /**
     * Flash an info message to the session
     *
     * @param string $message
     * @return void
     */
    public static function info(string $message): void
    {
        session()->flash('info', $message);
    }

    /**
     * Flash a warning message to the session
     *
     * @param string $message
     * @return void
     */
    public static function warning(string $message): void
    {
        session()->flash('warning', $message);
    }

    /**
     * Flash a message for SweetAlert2
     *
     * @param string $message
     * @param string $title
     * @param string $type
     * @return void
     */
    public static function alert(string $message, string $title = '', string $type = 'success'): void
    {
        if ($type === 'error') {
            session()->flash('toast_error', $message);
            session()->flash('alert_title', $title ?: 'Error');
            session()->flash('alert_type', 'error');
        } else {
            session()->flash('toast_success', $message);
        }
    }
} 