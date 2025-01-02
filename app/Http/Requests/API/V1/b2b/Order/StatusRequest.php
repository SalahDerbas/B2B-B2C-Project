<?php

namespace App\Http\Requests\API\V1\b2b\Order;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class StatusRequest extends BaseRequest
{
    private const ROUTE_B2B_PACKAGE_USAGE           = 'api.b2b.user.order.packages.usage';
    private const ROUTE_B2B_PACKAGE_GET_QR          = 'api.b2b.user.order.packages.getQR';
    private const ROUTE_B2B_PACKAGE_REEDEM_QR       = 'api.b2b.user.order.packages.reedemQR';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author Salah Derbas
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Returns the validation rules and messages for the order data request.
     *
     * This function specifies the required validation rules and error messages
     * for validating the `iccid` field in the request.
     *
     * @return array An array containing:
     *               - 'rules': Validation rules for the request.
     *               - 'messages': Custom error messages for validation failures.
     * @author Salah Derbas
     */
    public function packageGetQRRequest()
    {
        return [
            'rules'   =>  [
                'iccid'                      => [ 'required',  'exists:orders,iccid' ],
            ],
            'messages'  => [
                'iccid.required'             => getStatusText(ICCID_REQUIRED_CODE),
                'iccid.exists'               => getStatusText(ICCID_EXISTS_CODE),
            ],
        ];
    }

    /**
     * Returns the validation rules and messages for the order data request.
     *
     * This function specifies the required validation rules and error messages
     * for validating the `iccid` field in the request.
     *
     * @return array An array containing:
     *               - 'rules': Validation rules for the request.
     *               - 'messages': Custom error messages for validation failures.
     * @author Salah Derbas
     */
    public function packageUsageRequest()
    {
        return [
            'rules'   =>  [
                'iccid'                      => [ 'required',  'exists:orders,iccid' ],
            ],
            'messages'  => [
                'iccid.required'             => getStatusText(ICCID_REQUIRED_CODE),
                'iccid.exists'               => getStatusText(ICCID_EXISTS_CODE),
            ],
        ];

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

        if($route === self::ROUTE_B2B_PACKAGE_GET_QR || $route === self::ROUTE_B2B_PACKAGE_REEDEM_QR)
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
        $order_data = Order::where(['iccid' => $this->iccid , 'user_id' => Auth::id()])->first();
        $validateOrderID = $this->validateOrderID( $order_data );

        if (!$validateOrderID['value']) {
            throw new HttpResponseException(
                responseError($validateOrderID['message'], Response::HTTP_UNPROCESSABLE_ENTITY, $validateOrderID['code'])
            );
        }

        $this->addField('id',          $validateOrderID['id'] );
        $this->addField('order_data',  $validateOrderID['order_data'] );

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
        $route = $this->route()->getName();

        if(is_null($order_data))
            return $this->generateErrorResponse(ORDER_DATA_NOT_FOUND_CODE);
        if(is_null($order_data['order_data']))
            return $this->generateErrorResponse(ORDER_DATA_SUBMIT_CODE);
        if ($route === self::ROUTE_B2B_PACKAGE_REEDEM_QR)
        {
            if(!is_null($order_data['share_id']))
                return $this->generateErrorResponse(ORDER_DATA_IS_SHARE_CODE);

            if($order_data['user_id'] == Auth::id())
                return $this->generateErrorResponse(ORDER_DATA_USER_IS_SHARE_CODE);
        }

        return ['value' => true , 'order_data' => $order_data['order_data'] , 'id' => $order_data['id']];
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
            self::ROUTE_B2B_PACKAGE_USAGE                => $this->packageUsageRequest(),
            self::ROUTE_B2B_PACKAGE_GET_QR               => $this->packageGetQRRequest(),
            self::ROUTE_B2B_PACKAGE_REEDEM_QR            => $this->packageGetQRRequest(),

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
            self::ROUTE_B2B_PACKAGE_USAGE => [

                $messages['iccid.required']               =>   ICCID_REQUIRED_CODE,
                $messages['iccid.exists']                 =>   ICCID_EXISTS_CODE,
            ],
            self::ROUTE_B2B_PACKAGE_GET_QR => [

                $messages['iccid.required']               =>   ICCID_REQUIRED_CODE,
                $messages['iccid.exists']                 =>   ICCID_EXISTS_CODE,
            ],
            self::ROUTE_B2B_PACKAGE_REEDEM_QR => [

                $messages['iccid.required']               =>   ICCID_REQUIRED_CODE,
                $messages['iccid.exists']                 =>   ICCID_EXISTS_CODE,
            ],

            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }


}
