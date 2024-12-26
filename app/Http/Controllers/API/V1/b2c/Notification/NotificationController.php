<?php

namespace App\Http\Controllers\API\V1\b2c\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\V1\b2c\Notification\NotificationResource;

class NotificationController extends Controller
{
    /**
     * Display the push notifications for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
     */
    public function index()
    {
        try{
            $data = Notification::where('user_id' , Auth::id())->get();

            if($data->isEmpty())
                return responseSuccess('', getStatusText(NOTIFICATION_EMPTY_CODE), NOTIFICATION_EMPTY_CODE);

            return responseSuccess(NotificationResource::collection($data) , getStatusText(NOTIFICATIONS_SUCCESS_CODE)  , NOTIFICATIONS_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Toggle the notification setting for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
     */
    public function updateEnable()
    {
        try{
            $user = User::find(Auth::id())->whereNotNull('fcm_token')->first();
            if (is_null($user))
                return responseError(getStatusText(USER_NOT_FOUND_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,USER_NOT_FOUND_CODE);

            $user->enable_notification = !$user->enable_notification;
            $user->save();
            return responseSuccess((boolean)$user->enable_notification, getStatusText(ENABLED_NOTIFICATION_SUCCESS_CODE)  , ENABLED_NOTIFICATION_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
