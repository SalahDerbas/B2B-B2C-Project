<?php

namespace App\Http\Requests\Web\b2b;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
{
    private const ROUTE_CREDIT_STORE              = 'b2b.credits.store';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the store credit request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function storeCreditRequest()
    {
        return [
            'rules'   =>  [
                    'amount'             => ['required'] ,
                    'payment_id'         => ['required'  , 'exists:payments,id'],
            ],
        ];

    }
    /**
     * Retrieves the payment request form based on the given inputs and returns the appropriate structure.
     *
     * @return mixed
     * @author Salah Derbas
     */
    private function PaymentRequestForm($inputs)
    {
        return match ((integer)$inputs["payment_id"]) {
            1     =>   [ "amount"  =>  $inputs['amount'],  "currency"  => "USD"  ],
            //
            default => []
        };
    }

    /**
     * Handles validation logic specific to the order payment route.
     *
     * @return mixed
     * @author Salah Derbas
     */
    protected function addPaymentRequestValidation(): void
    {
        $this->replace(array_merge($this->all(), ['payment_request' => $this->PaymentRequestForm($this->all()) ]));
    }


    protected function passedValidation(): void
    {
        $route = $this->route()->getName();
        if ($route === self::ROUTE_CREDIT_STORE)
            $this->addPaymentRequestValidation();
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
                self::ROUTE_CREDIT_STORE                => $this->storeCreditRequest(),

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
