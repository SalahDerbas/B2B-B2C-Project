<?php

namespace App\Http\Requests\API\V1\b2b\Order;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PaymentPrice;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SubmitRequest extends BaseRequest
{
    private const ROUTE_B2B_ORDER_PAY           = 'api.b2b.user.order.pay';
    private const ROUTE_B2B_ORDER_DATA          = 'api.b2b.user.order.orderData';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Returns the validation rules and messages for the order data request.
     *
     * This function specifies the required validation rules and error messages
     * for validating the `order_id` field in the request.
     *
     * @return array An array containing:
     *               - 'rules': Validation rules for the request.
     *               - 'messages': Custom error messages for validation failures.
     * @author Salah Derbas
     */

     private function orderDataRequest()
     {
         return [
             'rules'   =>  [
                 'order_id'                  => ['required'],
             ],
             'messages'  => [
                 'order_id.required'         => getStatusText(ORDER_DATA_REQUIRED_CODE),
             ],
         ];
     }


    /**
     * Get the validation rules for the contact us request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function payRequest()
    {
        return [
            'rules'   =>  [
                'item_source_id'                  => ['required' , 'exists:item_sources,id'],
            ],
            'messages'  => [
                'item_source_id.required'         => getStatusText(ITEM_SOURCE_ID_REQUIRED_CODE),
                'item_source_id.exists'           => getStatusText(ITEM_SOURCE_ID_EXISTS_CODE),
            ],
        ];
    }


    /**
     * Generate a standardized error response for promo code validation.
     * @author Salah Derbas
     */
    private function generateErrorResponse(int $errorCode): array
    {
        return ['value' => false , 'message' => getStatusText($errorCode),'code' => $errorCode];
    }

   /**
     * Adds a new field to the current request data.
     *
     * @return mixed
     * @author Salah Derbas
     */
    protected function addField(string $key, $value): void
    {
        $this->replace(array_merge($this->all(), [$key => $value]));
    }
    /**
     * Validates the provided order data and ensures it meets the required conditions.
     *
     * This function checks:
     * - If the `$order_data` is null, indicating the order data was not found.
     * - If the `order_data` field within the `$order_data` is null, indicating the order data is incomplete or not submitted.
     *
     * It returns an error response for any validation failure or a success response with the validated data.
     *
     * @param array|null $order_data The order data to validate.
     *
     * @return array An array containing:
     *               - 'value' (bool): Validation result (true for success, false for failure).
     *               - 'order_data' (mixed): The validated order data (only on success).
     *               - Optional 'message' and 'code' keys (on validation failure).
     * @author Salah Derbas
     */
    public function validateOrderID($order_data)
    {
        if(is_null($order_data))
            return $this->generateErrorResponse(ORDER_DATA_NOT_FOUND_CODE);
        if(is_null($order_data['order_data']))
            return $this->generateErrorResponse(ORDER_DATA_SUBMIT_CODE);

        return ['value' => true , 'order_data' => $order_data['order_data']];
    }



    public function validateB2BBalance($item_source_id)
    {
        $final_price    =  PaymentPrice::where('item_source_id' , $this->item_source_id)->pluck('final_price')->first();
        $b2b_balance    =  Auth::user()->b2b_balance;
        if($b2b_balance < $final_price)
            return $this->generateErrorResponse(BALANCE_LESS_AMOUNT_CODE);

        return ['value' => true , 'new_balance' => ($b2b_balance - $final_price) , 'payment_id' =>  Auth::user()->payment_id];

    }



    /**
     * Validates and processes the order data for the current operation.
     *
     * This function performs the following:
     * - Decrypts and retrieves the order data using the provided order ID.
     * - Validates the order data against specific criteria.
     * - Throws an exception if the validation fails.
     * - Adds the validated order data to the field list for further processing.
     *
     * @throws HttpResponseException If the order data validation fails.
     * @return void
     * @author Salah Derbas
     */
    protected function handleOrderDataValidation(): void
    {
        $order_data = Order::findOrFail(decryptWithKey($this->order_id , 'B2B-B2C'));
        $validateOrderID = $this->validateOrderID( $order_data );

        if (!$validateOrderID['value']) {
            throw new HttpResponseException(
                responseError($validateOrderID['message'], Response::HTTP_UNPROCESSABLE_ENTITY, $validateOrderID['code'])
            );
        }
        $this->addField('order_data',  $validateOrderID['order_data'] );
    }

    /**
     * Handles validation logic specific to the order payment route.
     *
     * @return mixed
     * @author Salah Derbas
     */
    protected function handleOrderPayValidation(): void
    {
        $validateB2BBalance = $this->validateB2BBalance( $this->item_source_id );

        if (!$validateB2BBalance['value']) {
            throw new HttpResponseException(
                responseError($validateB2BBalance['message'], Response::HTTP_UNPROCESSABLE_ENTITY, $validateB2BBalance['code'])
            );
        }

        $this->addField('payment_id',  $validateB2BBalance['payment_id'] );
        $this->addField('new_balance',  $validateB2BBalance['new_balance'] );
    }

    /**
     * Determines the appropriate validation logic to execute based on the current route.
     *
     * @return mixed
     * @author Salah Derbas
     */
    protected function passedValidation(): void
    {
        $route = $this->route()->getName();
        if ($route === self::ROUTE_B2B_ORDER_PAY)
            $this->handleOrderPayValidation();

        if($route === self::ROUTE_B2B_ORDER_DATA)
            $this->handleOrderDataValidation();
    }




    /**
     * Retrieve requested validation data based on the current route.
     *
     * @param string $key
     * @return mixed
     * @author Salah Derbas
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data = match ($route) {
                self::ROUTE_B2B_ORDER_PAY                => $this->payRequest(),
                self::ROUTE_B2B_ORDER_DATA               => $this->orderDataRequest(),
            default => []
        };
        return $data[$key];

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function rules()
    {
        return $this->requested('rules');
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function messages()
    {
        return $this->requested('messages');
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @author Salah Derbas
     */
    protected function failedValidation(Validator $validator)
    {
        $route             =  $this->route()->getName();
        $messages          =  $this->messages();

        $errorMap = match ($route) {
            self::ROUTE_B2B_ORDER_PAY => [
                $messages['item_source_id.required']      =>   ITEM_SOURCE_ID_REQUIRED_CODE,
                $messages['item_source_id.exists']        =>   ITEM_SOURCE_ID_EXISTS_CODE,
            ],
            self::ROUTE_B2B_ORDER_DATA => [
                 $messages['order_id.required']           => ORDER_DATA_REQUIRED_CODE,
            ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
