<?php

use Illuminate\Support\Facades\Storage;
use App\Models\Lookup;
use Carbon\Carbon;
use App\Models\PaymentPrice;
use App\Models\Order;
use App\Models\Billing;
use App\Models\ItemSource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;





/**
*  This function formats a date to 'Y-m-d' format. Returns NULL if the date is null.
* @author Salah Derbas
*/
if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return (!is_null($date)) ? Carbon::parse($date)->format('Y-m-d') : NULL ;
    }
}

/**
*  This function retrieves the ID of a lookup record by key.
* @author Salah Derbas
*/
if (!function_exists('getIDLookups')) {
    function getIDLookups($key)
    {
        return Lookup::where(['key' => $key ])->pluck('id')->first();
    }
}

/**
*  This function retrieves the ID of a lookup record by key.
* @author Salah Derbas
*/
if (!function_exists('getValueByIDLookups')) {
    function getValueByIDLookups($id)
    {
        return Lookup::findOrFail($id)->value;
    }
}


/**
*  This function retrieves the value of a lookup record by key.
* @author Salah Derbas
*/
if (!function_exists('getValueLookups')) {
    function getValueLookups($key)
    {
        return Lookup::where(['key' => $key ])->pluck('value')->first();
    }
}
/**
* Checks if the function 'handleFileUpload' already exists before defining it.
* This function handles the uploading of files, allowing optional deletion of old files if updating.
* @author Salah Derbas
*/
if (!function_exists('handleFileUpload')) {
    function handleFileUpload($file, $type, $directory, $oldPath = null)
    {
        $path = 'public/' . $directory;
        if($type === 'update' && $oldPath)  {
            if (Storage::exists($oldPath))
                Storage::delete($oldPath);
        }
        $newPath = $file->store($path,'public');
        return env('APP_URL').'storage/'.$newPath;

    }
}

/**
 * This function retrieves the client's IP address by checking various server variables.
 * It accounts for scenarios where the client may be behind a proxy or CDN (e.g., Cloudflare).
 * If multiple IPs are returned, only the first one is used.
* @author Salah Derbas
*/
if (!function_exists("getClientIP")) {
    function getClientIP()
    {

        $ipaddress = '';
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && !empty($_SERVER['HTTP_CF_CONNECTING_IP']))
			$ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
        else if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']) && !empty($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && !empty($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']) && !empty($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = '';

		if(strpos($ipaddress, ",") !== false){
			$ipaddress = substr($ipaddress, 0, strpos($ipaddress, ','));
		}

        return $ipaddress;
    }
}





/**
 * This function retrieves the ID of a status from the database based on a given code and key.
 * It uses the Lookup model to query for the matching record and returns the 'id' field.
 * @author Salah Derbas
*/
if (!function_exists("getStatusID")) {
    function getStatusID( $code , $key )
    {
        $statusID = Lookup::where(['code' => $code , 'key' => $key ])->pluck('id')->first();
        return $statusID;
    }
}

/**
 * Function to get user country information based on public IP address.
 *
 * @author Salah Derbas
*/
if (!function_exists("getUserCountry")) {
    function getUserCountry($PublicIP)
    {
        $client = new \GuzzleHttp\Client();

        $json = $client->request('GET', "http://ipwhois.pro/$PublicIP?key=JeHz2Pp7vRKDgHTp");
        $code = $json->getBody();
        $data = json_decode($code);
        if (isset($data)) {
            return $data;
        }
    }
}

/**
 * Logs a debug message to a specified log channel.
 * This function ensures a consistent and simple way to log debug information
 * to custom log files defined in your Laravel logging configuration.
 *
 * @param string $fileName The name of the log channel (defined in config/logging.php).
 * @param string $name     A label or identifier for the log entry.
 * @param array  $array    The data or details to log.
 *
 * @return void
 */
if (!function_exists("LoggingFile")) {
    function LoggingFile($fileName,$name, $array)
    {
        Log::channel( $fileName )->debug( $name , $array );
    }
}



/**
 * Function to insert a new order and return the created order ID.
 *
 * @author Salah Derbas
*/
if (!function_exists("insertOrderInitial")) {
    function insertOrderInitial($data , $LogName)
    {
        LoggingFile($LogName , '[pay]--START_PAY_ITEM--' ,['ip' => getClientIP() , 'user_id' => Auth::id() ,'item_source_id' => $data['item_source_id'] , 'payment_id' => $data['payment_id'] ]);

        $dataOrder = PaymentPrice::where(['item_source_id' => $data['item_source_id'] , 'payment_id' => $data['payment_id']])
        ->with(['getPayment', 'getItemSource' , 'getItemSource.getItem.getSubCategory' , 'getItemSource.getSource'])->first();

        $orderID = Order::insertGetId([
            'email'             => Auth::user()->email,
            'sub_category_id'   => $dataOrder->getItemSource->getItem->sub_category_id,
            'item_id'           => $dataOrder->getItemSource->getItem->id,
            'user_id'           => Auth::id(),
            'item_source_id'    => $dataOrder->item_source_id,
            'payment_id'        => $dataOrder->payment_id,
            'final_price'       => (is_null($data['promo_code_id'])) ? $dataOrder->final_price : $data['new_price'],
            'cost_price'        => $dataOrder->getItemSource->cost_price,
            'source_id'         => $dataOrder->getItemSource->getSource->id,
            'status_order'      => getStatusID('U-StatusOrder'   ,'SO-submit_order' ),
            'status_package'    => getStatusID('U-StatusPackage' ,'SP-new' ),
            'user_agent'        => json_encode(getUserCountry(getClientIP())) ,
            'promo_code_id'     => $data['promo_code_id'],
            'promo_code'        => $data['promo_code'],
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        LoggingFile( $LogName , '[pay]---CREATE_ORDER_ID--' ,['ip' => getClientIP() , 'user_id' => Auth::id() , 'orderID' => $orderID  ]);
        return $orderID;
    }
}



/**
 * Function to update the status of an order by order ID.
 *
 * @author Salah Derbas
*/
if (!function_exists("updateStatusOrder")) {
    function updateStatusOrder($orderID , $keyStatus , $valueStatus , $LogName)
    {
        LoggingFile( $LogName , '---UPDATE_STATUS_ORDER--' ,['ip' => getClientIP() , 'user_id' => Auth::id() , 'orderID' => $orderID , $keyStatus => $valueStatus ]);
        Order::findOrFail($orderID)->update([$keyStatus => $valueStatus]);
    }
}

/**
 * Function to update the status of an order by order ID.
 *
 * @author Salah Derbas
*/
if (!function_exists("updateStatusBilling")) {
    function updateStatusBilling($billingID , $keyStatus , $valueStatus , $LogName)
    {
        LoggingFile( $LogName , '---UPDATE_STATUS_ORDER--' ,['ip' => getClientIP() , 'user_id' => Auth::id() , 'billingID' => $billingID , $keyStatus => $valueStatus ]);
        Billing::findOrFail($billingID)->update([$keyStatus => $valueStatus]);
    }
}

/**
 * Function to update Final of an order by order ID.
 *
 * @author Salah Derbas
*/
if (!function_exists("updateOrderFinal")) {
    function updateOrderFinal($orderID , $order_data , $LogName)
    {
        $statusOrderID = getStatusID('U-StatusOrder'   ,'SO-success' );
        LoggingFile( $LogName , '---UPDATE_ORDER_FINAL--' ,['ip' => getClientIP() , 'user_id' => Auth::id() , 'orderID' => $orderID , 'order_data'  => $order_data , 'iccid'  => $order_data['sims'][0]['iccid']  ,'status_order'   => $statusOrderID ]);

        Order::findOrFail($orderID)->update([
            'order_data'     => json_encode($order_data)   ,
            'iccid'          => $order_data['sims'][0]['iccid'] ,
            'status_order'   => $statusOrderID,
        ]);
    }
}


/**
 * Function to encrypt a plaintext string using a specified key.
 *
 * @author Salah Derbas
*/
if (!function_exists("encryptWithKey")) {
    function encryptWithKey($plaintext, $key) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = $iv . openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        $base64Encoded = base64_encode($encryptedData);
        return strtr($base64Encoded, '+/', '-_');
    }
}

/**
 * Function to decrypt an encrypted string using a specified key.
 *
 * @author Salah Derbas
*/
if (!function_exists("decryptWithKey")) {
     function decryptWithKey($encryptedData, $key) {
        $base64Encoded = strtr($encryptedData, '-_', '+/');
        $encryptedData = base64_decode($base64Encoded);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($encryptedData, 0, $ivLength);

        return openssl_decrypt(substr($encryptedData, $ivLength) , 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }
}

/**
 * Generates a UUID (Universally Unique Identifier) version 4.
 * A UUID is a 128-bit number used to uniquely identify information.
 * This function ensures the UUID conforms to RFC 4122 specifications.
 * The function checks if it already exists before declaring to avoid redeclaration errors.
 *
 * @author Salah Derbas
 * @return string A UUID version 4 string in the format 8-4-4-4-12 (e.g., 550e8400-e29b-41d4-a716-446655440000).
 */
if (!function_exists("generateString")) {
    function generateString(int $strength = 100)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($characters, ceil($strength / strlen($characters)))), 0, $strength);
    }
}



/**
 * Handles API exceptions by returning custom responses based on the response status code.
 * If the status code is not handled, it returns the original response.
 * This function checks if it exists before declaring to avoid redeclaration errors.
 *
 * @author Salah Derbas
 * @param \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response $response The response object to evaluate.
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response The custom error response or the original response.
 */
if (!function_exists("ExceptionAPI")) {
    function ExceptionAPI($response)
    {
        if ($response->getStatusCode() === 401)
        return respondUnauthorized('Unauthorized');
        if ($response->getStatusCode() === 403)
            return respondForbidden('Forbidden');
        if ($response->getStatusCode() === 404)
            return respondNotFound('Not Found');
        if ($response->getStatusCode() === 405)
            return respondMethodAllowed('Method Not Allowed');
        if ($response->getStatusCode() === 422)
            return respondUnprocessableEntity('Unprocessable Entity');
        if ($response->getStatusCode() === 429)
            return respondTooManyRequest('Too Many Requests');
        if ($response->getStatusCode() === 500)
            return respondInternalError('Internal Server Error');

        return $response;
    }
}



/**
 * Handles web exceptions by returning custom error views based on the response status code.
 * If the status code is not handled, it returns the original response.
 * This function checks if it exists before declaring to avoid redeclaration errors.
 *
 * @author Salah Derbas
 * @param \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response $response The response object to evaluate.
 * @return \Illuminate\Http\Response The custom error view or the original response.
 */
if (!function_exists("ExceptionWeb")) {
    function ExceptionWeb($response)
    {
        if ($response->getStatusCode() === 401)
            return response()->view('errors.401', [], 401);
        if ($response->getStatusCode() === 403)
            return response()->view('errors.403', [], 403);
        if ($response->getStatusCode() === 404)
            return response()->view('errors.404', [], 404);
        if ($response->getStatusCode() === 405)
            return response()->view('errors.405', [], 405);
        if ($response->getStatusCode() === 422)
            return response()->view('errors.422', [], 422);
        if ($response->getStatusCode() === 429)
            return response()->view('errors.429', [], 429);
        if ($response->getStatusCode() === 500)
            return response()->view('errors.500', [], 500);

        return $response;
    }
}

/**
 * Generates a unique number ID based on the provided key and current date and time.
 * This function checks if it exists before declaring to avoid redeclaration errors.
 *
 * @author Salah Derbas
 * @param string $key A key to prefix the generated ID.
 * @return string A unique identifier in the format: key--year--month--day--hour:minute:second.
 */
if (!function_exists('getNumberID')) {
    function getNumberID($key)
    {
        $date = Carbon::now();
       return '('.$key.')-('.Auth::user()->email.')-('.$date->year.'-'.$date->month.'-'.$date->day.'-'.$date->format('H:i:s').')';
    }
}

/**
 * Retrieves lookup data based on the provided code.
 * This function checks if it exists before declaring to avoid redeclaration errors.
 *
 * @author Salah Derbas
 * @param string $code The code for which to retrieve lookup data.
 * @return \Illuminate\Support\Collection The collection of lookup data matching the code.
 */
if (!function_exists("getDataLookups")) {
    function getDataLookups($code)
    {
        return Lookup::where(['code' => $code ])->get();
    }
}


if (!function_exists('getFileName')) {
    function getFileName($key)
    {
       return '('.$key.')-('.formatDate(Carbon::now()).')';
    }
}





if (!function_exists('CustomizeFileUpload')) {
    function CustomizeFileUpload($file, $type, $directory, $oldPath = null)
    {
        $destinationPath = public_path($directory);
        if($type === 'update' && $oldPath)  {
            if (File::exists($oldPath))
            File::delete($oldPath);
        }
        $file->move($destinationPath, $file->getClientOriginalName());
        return url($directory .'/'. $file->getClientOriginalName());

    }
}

