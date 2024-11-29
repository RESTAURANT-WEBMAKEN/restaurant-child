<?php

namespace App\Http\Controllers;

use App\Services\PageEditService;
use Illuminate\Http\Request;

class PageEditController extends Controller
{
    protected $pageEditService;

    public function __construct(PageEditService $pageEditService){
        $this->pageEditService = $pageEditService;
    }
}
