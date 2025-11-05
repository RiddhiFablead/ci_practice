<?php

namespace App\Controllers;

class Hello extends BaseController
{
    public function index()
    {
        return "Start ci Practice.";
    }

    public function about()
    {
        return "About us page.";
    }
}
