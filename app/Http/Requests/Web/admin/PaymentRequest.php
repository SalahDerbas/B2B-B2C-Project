<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    private const ROUTE_PAYMENT_STORE              = 'admin.payments.store';
    private const ROUTE_PAYMENT_UPDATE             = 'admin.payments.update';
    private const ROUTE_PAYMENT_DELETE             = 'admin.payments.delete';
    private const ROUTE_PAYMENT_EDIT               = 'admin.payments.edit';
    private const ROUTE_PAYMENT_SWITCH_STATUS      = 'admin.payments.switchStatus';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for switching the payment status.
     *
     * @author Salah Derbas
     * @return array
     */
    private function switchStatusPaymentRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:payments,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for editing an payment.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editPaymentRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:payments,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for deleting an payment.
     *
     * @author Salah Derbas
     * @return array
     */
    private function deletePaymentRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:payments,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an payment.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updatePaymentRequest()
    {
        return [
            'rules'   =>  [
                'name'          =>  ['required'] ,
                'is_b2b'        =>  ['required'],
            ],
        ];
    }

    /**
     * Get the validation rules for storing a new payment.
     *
     * @author Salah Derbas
     * @return array
     */
    private function storePaymentRequest()
    {
        return [
            'rules'   =>  [
                'name'          =>  ['required'] ,
                'is_b2b'        =>  ['required'],
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
            self::ROUTE_PAYMENT_STORE                => $this->storePaymentRequest(),
            self::ROUTE_PAYMENT_UPDATE               => $this->updatePaymentRequest(),
            self::ROUTE_PAYMENT_DELETE               => $this->deletePaymentRequest(),
            self::ROUTE_PAYMENT_EDIT                 => $this->editPaymentRequest(),
            self::ROUTE_PAYMENT_SWITCH_STATUS        => $this->switchStatusPaymentRequest(),

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
