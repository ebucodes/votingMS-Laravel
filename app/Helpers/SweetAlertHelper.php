<?php

namespace App\Helpers;

class SweetAlertHelper
{
    public static function showAlert($title, $message, $type)
    {
        session()->flash('sweetAlert', [
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }
}
