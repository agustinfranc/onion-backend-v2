<?php

namespace App\Http\Controllers;

use App\Repositories\CommerceBranchRepository;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Generate preference that allows a client to make a payment
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function generatePreference(Request $request, CommerceBranchRepository $repository) {
        // TODO: validaciones: array de items, commerce_branch...

        $commerceBranch = $repository->getOne($request->commerce_branch);

        if (!$commerceBranch->mp_access_token) {
            return response()->json([ 'status' => 404, 'message' => 'Access token not found', 'error' => 'token_not_found' ], 404);
        }

        $mp = new MercadoPagoService($commerceBranch->mp_access_token);
        $response = $mp->generatePreference($request->items);

        return $response;
    }
}
