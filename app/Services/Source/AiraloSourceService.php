<?php

namespace App\Services\Source;

use App\Interfaces\Source\SourcePackageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\BaseIntegrationService;
use Illuminate\Support\Facades\Auth;
use App\Models\ItemSource;

class AiraloSourceService extends BaseIntegrationService implements SourcePackageInterface
{

    /**
    * Constructor to initialize Airalo API configuration and headers
    * @author Salah Derbas
    */
    public function __construct()
    {
        $this->base_url        =  env('AIRALO_URL').env('AIRALO_VERSION');
        $this->client_id       =  env('AIRALO_CLIENT_ID') ;
        $this->client_secret   =  env('AIRALO_CLIENT_SECRET');
        $this->grant_type      =  env('AIRALO_GRANT_TYPE');

        $this->header          = [
            'Accept'        =>  'application/json',
            'Content-Type'  =>  'application/json',
        ];
    }

    /**
    * Generate an authorization token for Airalo API
    * @return string - Access token
    * @author Salah Derbas
    */
    protected function generateToken()
    {
        $data  = [ "client_id"      =>  $this->client_id ,
                   "client_secret"  =>  $this->client_secret ,
                   "grant_type"     =>  $this->grant_type
                ];

        $response = $this->buildRequest('POST', '/token', $data);

        return $response->getData(true)['data']['data']['access_token'];
    }


    /**
    * Submit an order to the Airalo API
    * @param int $item_source_id - ID of the item source
    * @return array - Order submission result
    * @author Salah Derbas
    */
    public function submitOrder($item_source_id): array
    {
        $this->header['Authorization'] = 'Bearer ' . $this->generateToken();
        $data     = $this->formatDataPayment($item_source_id);

        $response = $this->buildRequest('POST', '/orders', $data);

        LoggingFile( 'App-API' , '[submitOrder]---RESPONSE_submitOrder--' ,['ip' => getClientIP() , 'user_id' => Auth::id() , 'data' => $data , 'RESPONSE' => $response->getContent()  ]);

        if($response->getData(true)['success'])
            return ['success' => true, 'data' =>  $response->getData(true)['data']['data'] ];

        return ['success' => false, 'data' =>  NULL ];
    }

    /**
    * Format payment data for the Airalo API order submission
    * @param int $item_source_id - ID of the item source
    * @return array - Formatted payment data
    * @author Salah Derbas
    */
    private function formatDataPayment($item_source_id): array
    {
        $package_id = ItemSource::findOrFail($item_source_id)->package_id;

        return [
            'quantity'    =>  1,
            'package_id'  =>  $package_id
        ];
    }

    /**
     * Retrieves usage information for a specific ICCID.
     * @param string $iccid
     * @return array
     * @author Salah Derbas
     */
    public function usagePackage($iccid): array
    {
        $this->header['Authorization'] = 'Bearer ' . $this->generateToken();

        $response = $this->buildRequest('GET', '/sims/' .$iccid. '/usage' );

        LoggingFile( 'App-API' , '[usagePackage]---RESPONSE_usagePackage--' ,['ip' => getClientIP() , 'user_id' => Auth::id() , 'RESPONSE' => $response->getContent()  ]);

        if($response->getData(true)['success'])
            return ['success' => true, 'data' =>  $response->getData(true)['data']['data'] ];

        return ['success' => false, 'data' =>  NULL ];

    }


}
