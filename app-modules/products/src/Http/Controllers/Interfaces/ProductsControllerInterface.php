<?php

namespace Modules\Products\Http\Controllers\Interfaces;

use Illuminate\Http\Request;

interface ProductsControllerInterface
{
    public function index();

    public function edit(string $id);

    public function store(Request $request);

    public function update(Request $request, string $id);

    public function destroy(string $id);
}