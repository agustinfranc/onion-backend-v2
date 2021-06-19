<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Repositories\CommerceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommerceController extends Controller
{
    /**
     * Get all the commerces or get the commerces for a given authenticated user.
     *
     * @param  Illuminate\Http\Request  $request
     * @return object response
     */
    public function index(Request $request)
    {
        if ($request->user()) {
            return Commerce::ofUser($request->user())->get();
        }

        return Commerce::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Commerce $commerce)
    {
        return $commerce;
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
    public function store(Request $request, CommerceRepository $repository)
    {
        $user = $request->user();

        $input = $request->all();

        return $repository->save($input, $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commerce $commerce)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|max:255',
        ]);

        $commerce->fill($validatedData);

        $commerce->save();

        return $commerce;
    }

    /**
     * Upload commerce avatar/cover to storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Commerce $commerce)
    {
        // todo: create request to validate it (size, extension...)

        if (
            (!$request->hasFile('avatar') || !$request->file('avatar')->isValid()) &&
            (!$request->hasFile('cover')  || !$request->file('cover')->isValid())
        ) {
            return response()->json(['error' => 'No se encuentra imagen en la request'], 500);
        }

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $path = $request->file('avatar')->store('images', 'public');

            // $commerce->avatar_dirname = env('APP_URL', 'https://api.onion.ar') . '/storage/' . $path;
            $commerce->avatar_dirname = 'https://api.onion.ar/storage/' . $path;
        }

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $path = $request->file('cover')->store('images', 'public');

            // $commerce->cover_dirname = env('APP_URL', 'https://api.onion.ar') . '/storage/' . $path;
            $commerce->cover_dirname = 'https://api.onion.ar/storage/' . $path;
        }

        $commerce->save();

        return response($commerce);
    }
}
