<?php

namespace App\Http\Requests\API\V1\b2c\Order;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use App\Models\PaymentPrice;
use App\Models\PromoCode;
use App\Models\UserPromoCode;
use App\Models\Order;
use Carbon\Carbon;

class SubmitRequest extends BaseRequest
{
    private const ROUTE_ORDER_PAY           = 'api.user.order.pay';
    private const ROUTE_CHECK_PROMOCODE     = 'api.user.order.checkPromocode';
    private const ROUTE_ORDER_DATA          = 'api.user.order.orderData';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author Salah Derbas
     */
    public function authorize()
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
     * Returns the validation rules and messages for the promo code request.
     *
     * This function defines the validation rules and corresponding error messages
     * for checking the `item_source_id` and `promo_code` fields in the request.
     *
     * @return array An array containing:
     *               - 'rules': Validation rules for the request.
     *               - 'messages': Custom error messages for validation failures.
     * @author Salah Derbas
     */
    private function checkPromocodeRequest()
    {
        return [
            'rules'   =>  [
                'item_source_id'                  => ['required' , 'exists:item_sources,id'],
                'promo_code'                      => ['required' , 'exists:promo_codes,promo_code'],
            ],
            'messages'  => [
                'item_source_id.required'         => getStatusText(ITEM_SOURCE_ID_REQUIRED_CODE),
                'item_source_id.exists'           => getStatusText(ITEM_SOURCE_ID_EXISTS_CODE),
                'promo_code.required'             => getStatusText(PROMO_CODE_REQUIRED_CODE),
                'promo_code.exists'               => getStatusText(PROMO_CODE_EXISTS_CODE),
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
                'payment_id'                      => ['required' , 'exists:payments,id'],
                'promo_code'                      => [ 'exists:promo_codes,promo_code' ],
            ],
            'messages'  => [
                'item_source_id.required'         => getStatusText(ITEM_SOURCE_ID_REQUIRED_CODE),
                'item_source_id.exists'           => getStatusText(ITEM_SOURCE_ID_EXISTS_CODE),
                'payment_id.required'             => getStatusText(PAYMENT_ID_REQUIRED_CODE),
                'payment_id.exists'               => getStatusText(PAYMENT_ID_EXISTS_CODE),
                'promo_code.exists'               => getStatusText(PROMO_CODE_EXISTS_CODE),
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
     * Check the validity of a promo code for the current user.
     *
     * This method performs multiple validations on the provided promo code:
     * - Ensures the user hasn't exceeded the promo code usage limit.
     * - Confirms the global usage limit of the promo code hasn't been reached.
     * - Validates the promo code's active date range.
     * - Verifies the item's final price is eligible for the discount.
     *
     * @param array $inputs An array containing 'promo_code' and 'item_source_id'.
     * @return array|object Returns an array with the new price on success or an error response on failure.
     * @author Salah Derbas
     */
    public function checkPromoCode($inputs)
    {
        $Promocode      =  PromoCode::where('promo_code' , $inputs['promo_code'])->first();
        $final_price    =  PaymentPrice::where('item_source_id' , $inputs['item_source_id'])->pluck('final_price')->first();
        $count          =  UserPromocode::where(['user_id' => Auth::id(), 'promocode_id' => $Promocode->id])->count();
        if($count >= $Promocode["user_limit"] )
            return $this->generateErrorResponse(PROMOCODE_USER_LIMIT);

        if($Promocode["limit"] == $Promocode["counter"])
            return $this->generateErrorResponse(PROMOCODE_LIMIT);

        if (Carbon::now()->between(Carbon::parse($Promocode["from_date"]) , Carbon::parse($Promocode["to_date"])))
            return $this->generateErrorResponse(PROMOCODE_DATE);

        if( $final_price < $Promocode["amount"])
            return $this->generateErrorResponse(PROMOCODE_PRICE_AMOUNT);

        return ['value' => true , 'new_price' => ($final_price - $Promocode["amount"]) , 'promo_code_id' => $Promocode->id ];
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


    /**
     * Retrieves the payment request form based on the given inputs and returns the appropriate structure.
     *
     * @return mixed
     * @author Salah Derbas
     */
    private function PaymentRequestForm($inputs)
    {
        $final_price = PaymentPrice::where(['item_source_id' => $inputs['item_source_id'] , 'payment_id' => $inputs['payment_id']])->pluck('final_price')->first();

        return match ((integer)$inputs["payment_id"]) {
            1     =>   [ "amount"  =>  $final_price ,  "currency"  => "USD"  ],
            //
            default => []
        };
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
        if ($route === self::ROUTE_ORDER_PAY)
            $this->handleOrderPayValidation();

        if ($route === self::ROUTE_CHECK_PROMOCODE)
            $this->handlePromoCodeValidation();

        if($route === self::ROUTE_ORDER_DATA)
            $this->handleOrderDataValidation();
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
        if (!is_null($this->promo_code))
            $this->validatePromoCode();

        $this->addField('payment_request', $this->PaymentRequestForm($this->all()));
    }

    /**
     * Handles validation logic specific to the promo code check route.
     *
     * @return mixed
     * @author Salah Derbas
     */
    protected function handlePromoCodeValidation(): void
    {
        $this->validatePromoCode();
    }

    /**
     * Validates the provided promo code and updates the request data if valid.
     *
     * @return mixed
     * @author Salah Derbas
     */
    protected function validatePromoCode(): void
    {
        $checkPromoCode = $this->checkPromoCode($this->all());

        if (!$checkPromoCode['value']) {
            throw new HttpResponseException(
                responseError($checkPromoCode['message'], Response::HTTP_UNPROCESSABLE_ENTITY, $checkPromoCode['code'])
            );
        }

        $this->addField('new_price',        $checkPromoCode['new_price']       );
        $this->addField('promo_code_id',    $checkPromoCode['promo_code_id']   );
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
                self::ROUTE_ORDER_PAY                => $this->payRequest(),
                self::ROUTE_CHECK_PROMOCODE          => $this->checkPromocodeRequest(),
                self::ROUTE_ORDER_DATA               => $this->orderDataRequest(),
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
            self::ROUTE_ORDER_PAY => [
                $messages['item_source_id.required']      =>   ITEM_SOURCE_ID_REQUIRED_CODE,
                $messages['item_source_id.exists']        =>   ITEM_SOURCE_ID_EXISTS_CODE,
                $messages['payment_id.required']          =>   PAYMENT_ID_REQUIRED_CODE,
                $messages['payment_id.exists']            =>   PAYMENT_ID_EXISTS_CODE,

            ],
            self::ROUTE_CHECK_PROMOCODE => [
                $messages['item_source_id.required']      =>   ITEM_SOURCE_ID_REQUIRED_CODE,
                $messages['item_source_id.exists']        =>   ITEM_SOURCE_ID_EXISTS_CODE,
                $messages['promo_code.required']          =>   PROMO_CODE_REQUIRED_CODE,
                $messages['promo_code.exists']            =>   PROMO_CODE_EXISTS_CODE,

            ],
            self::ROUTE_ORDER_DATA => [
                 $messages['order_id.required']           => ORDER_DATA_REQUIRED_CODE,
            ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
