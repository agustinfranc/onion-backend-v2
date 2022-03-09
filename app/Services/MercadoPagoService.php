<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MercadoPagoService
{
    private $_accessToken;

    public function __construct($accessToken)
    {
        $this->_accessToken = $accessToken;
    }

    /**
     * Generate preference that allows a client to make a payment
     *
     * @param array $request
     * @return json
     */
    public function generatePreference(array $request) {
        //TODO: crear interfaz de la respuesta
        $response = Http::post('https://api.mercadolibre.com/checkout/preferences?access_token=' . $this->_accessToken, [
            'items' => $request,
        ]);

        return ($response->json());
    }

}