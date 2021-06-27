<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommerceRequest;
use App\Models\Commerce;
use App\Repositories\CommerceRepository;
use Illuminate\Http\Request;

class CommerceController extends Controller
{
    /**
     * Get all the commerces or get the commerces for a given authenticated user.
     *
     * @param  Illuminate\Http\Request  $request
     * @return object response
     */
    public function index(Request $request, CommerceRepository $repository)
    {
        return $repository->getAll($request->all(), $request->user());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Commerce $commerce, CommerceRepository $repository)
    {
        return $repository->getOne($commerce, $request->user());
    }

    /**
     * Show the commerce for a given commerce name.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  string  $commerceName
     * @return object response
     */
    public function showByName(Request $request, string $commerceName, CommerceRepository $repository)
    {
        return $repository->getByName($request->all(), $commerceName);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommerceRequest $request, CommerceRepository $repository)
    {
        $user = $request->user();

        return $repository->save($request->all(), $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commerce $commerce, CommerceRepository $repository)
    {
        $commerceRequest = new CommerceRequest;

        $validatedData = $request->validate([
            'fullname' => $commerceRequest->rules()['fullname'],
        ]);

        return $repository->update($validatedData, $commerce);
    }

    /**
     * Upload commerce avatar/cover to storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Commerce $commerce, CommerceRepository $repository): Commerce
    {
        // todo: create request to validate it (size, extension...)

        if (
            (!$request->hasFile('avatar') || !$request->file('avatar')->isValid()) &&
            (!$request->hasFile('cover')  || !$request->file('cover')->isValid())
        ) {
            return response()->json(['error' => 'No se encuentra imagen en la request'], 500);
        }

        $input = [];

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $path = $request->file('avatar')->store('images', 'public');

            // $commerce->avatar_dirname = env('APP_URL', 'https://api.onion.ar') . '/storage/' . $path;
            $input['avatar_dirname'] = 'https://api.onion.ar/storage/' . $path;
        }

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $path = $request->file('cover')->store('images', 'public');

            // $commerce->cover_dirname = env('APP_URL', 'https://api.onion.ar') . '/storage/' . $path;
            $input['cover_dirname'] = 'https://api.onion.ar/storage/' . $path;
        }

        return $repository->update($input, $commerce);
    }
}
