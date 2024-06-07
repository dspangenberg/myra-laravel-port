<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

abstract class Controller
{
    protected $recordsPerPage;

    public function __construct()
    {
        $this->recordsPerPage = $value = Config::get('app.records_per_page', 20);
    }
}
