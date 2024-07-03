<?php

namespace App\Http\Controllers;

use App\Services\PackagingService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(PackagingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {

        $boxes = $this->service->sortedBoxes();
        return view('products.index', ['boxes' => $boxes]);

    }

    public function store(request $request)
    {
        $processPackaging = $this->service->processPackaging($request);
        return view('products.store', $processPackaging);

    }

}
