<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class BillingRequest extends FormRequest
{
    private const ROUTE_BILLING_SHOW                = 'admin.billings.show';
    private const ROUTE_BILLING_DOWNLOAD            = 'admin.billings.download';
    private const ROUTE_BILLING_APPROVE             = 'admin.billings.approve';
    private const ROUTE_BILLING_REJECT              = 'admin.billings.reject';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for showing a billing request.
     *
     * @author Salah Derbas
     * @return array
     */
    private function showBillingRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:billings,id'] ,
            ],
        ];
    }

    /**
     * Validation rules for downloading a billing request.
     *
     * @author Salah Derbas
     * @return array
     */
    private function downloadBillingRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:billings,id'] ,
            ],
        ];
    }

    /**
     * Validation rules for approving a billing request.
     *
     * @author Salah Derbas
     * @return array
     */
    private function approveBillingRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:billings,id'] ,
            ],
        ];
    }

    /**
     * Validation rules for rejecting a billing request.
     *
     * @author Salah Derbas
     * @return array
     */
    private function rejectBillingRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:billings,id'] ,
            ],
        ];
    }

    /**
     * Get requested data based on the current route.
     *
     * @param string $key
     * @return mixed
     * @author Salah Derbas
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data  = match ($route) {
            self::ROUTE_BILLING_SHOW                   => $this->showBillingRequest(),
            self::ROUTE_BILLING_DOWNLOAD               => $this->downloadBillingRequest(),
            self::ROUTE_BILLING_APPROVE                => $this->approveBillingRequest(),
            self::ROUTE_BILLING_REJECT                 => $this->rejectBillingRequest(),

                default => [ 'rules' => [], 'messages' => []  ]
        };
        return $data[$key];

    }

    /**
     * Get the validation rules for the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function rules()
    {
        return $this->requested('rules');
    }

}
