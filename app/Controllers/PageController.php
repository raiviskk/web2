<?php

namespace App\Controllers;

use App\Response;

class PageController
{
    public function index(): Response
    {
        $data = [
            'message' => 'Hello Human',
        ];
        $template = 'index';
        return new Response($template, $data);
    }


}