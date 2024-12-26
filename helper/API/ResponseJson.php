<?php

use Symfony\Component\HttpFoundation\Response;

// Success Code
define('LOGIN_SUCCESS_CODE'                   , 1001);
define('MESSAGE_CODE_SUCCESS_CODE'            , 1002);
define('LOOKUPS_SUCCESS_CODE'                 , 1003);
define('CONTENT_EMPTY_CODE'                   , 1004);
define('CONTENT_SUCCESS_CODE'                 , 1005);
define('CONTACT_US_SUCCESS_CODE'              , 1006);
define('NOTIFICATION_EMPTY_CODE'              , 1007);
define('NOTIFICATIONS_SUCCESS_CODE'           , 1008);
define('USER_NOT_FOUND_CODE'                  , 1009);
define('ENABLED_NOTIFICATION_SUCCESS_CODE'    , 1010);
define('SEND_NOTIFICATION_SUCCESS_CODE'       , 1011);
define('SEND_OTP_SUCCESS_CODE'                , 1012);
define('CHECK_OTP_SUCCESS_CODE'               , 1013);
define('RESET_NEW_PASSWOED_CODE'              , 1014);
define('GET_PROFILE_CODE'                     , 1015);
define('REFRESH_TOKEN_CODE'                   , 1016);
define('USER_LOGOUT_CODE'                     , 1017);
define('DELETE_ACCONT_CODE'                   , 1018);
define('COUNTRIES_SUCCESS_CODE'               , 1019);
define('GET_CATEGORY_SUCCESS_CODE'            , 1020);
define('GET_CATEGORY_EMPTY_CODE'              , 1021);
define('GET_ITEMS_EMPTY_CODE'                 , 1022);
define('GET_ITEMS_SUCCESS_CODE'               , 1023);
define('HOME_SUCCESS_CODE'                    , 1024);
define('SEARCH_NOT_FOUND_CODE'                , 1025);
define('SEARCH_SUCCESS_CODE'                  , 1026);
define('SLIDER_NOT_FOUND_CODE'                , 1027);
define('SLIDER_SUCCESS_CODE'                  , 1028);




// Validation Code
define('EMAIL_EXISTS_CODE'                    , 4001);
define('PASSWORD_REQUIRED_CODE'               , 4002);
define('USER_DELETED_CODE'                    , 4003);
define('NAME_REQUIRED_CODE'                   , 4004);
define('NAME_UNIQUE_CODE'                     , 4005);
define('NAME_REGEX_CODE'                      , 4006);
define('EMAIL_REQUIRED_CODE'                  , 4007);
define('EMAIL_STRING_CODE'                    , 4008);
define('EMAIL_EMAIL_CODE'                     , 4009);
define('EMAIL_MAX_CODE'                       , 4010);
define('EMAIL_UNIQUE_CODE'                    , 4011);
define('EMAIL_REGEX_CODE'                     , 4012);
define('PASSWORD_VALIDATION_CODE'             , 4013);
define('OTP_REQUIRED_CODE'                    , 4014);
define('SUBJECT_REQUIRED_CODE'                , 4015);
define('GOOGLE_FAILED_CODE'                   , 4016);
define('FACEBOOK_FAILED_CODE'                 , 4017);
define('CONFIRM_PASSWORD_REQUIRED_WITH_CODE'  , 4018);
define('CONFIRM_PASSWORD_SAME_CODE'           , 4019);
define('CONFIRM_PASSWORD_MIN_CODE'            , 4020);
define('MESSAGE_REQUIRED_CODE'                , 4020);
define('TITLE_EN_REQUIRED_CODE'               , 4021);
define('TITLE_AR_REQUIRED_CODE'               , 4022);
define('BODY_EN_REQUIRED_CODE'                , 4023);
define('BODY_AR_REQUIRED_CODE'                , 4024);
define('USERS_STRING_CODE'                    , 4025);
define('APPLE_ID_FAILED_CODE'                 , 4026);
define('NAME_CODE'                            , 4028);
define('PHONE_CODE'                           , 4029);
define('COUNTRY_ID_REQUIRED_CODE'             , 4039);
define('COUNTRY_ID_EXISTS_CODE'               , 4040);
define('GENDER_ID_REQUIRED_CODE'              , 4041);
define('GENDER_ID_EXISTS_CODE'                , 4042);
define('PHOTO_FILE_CODE'                      , 4053);
define('REGISTER_USER_SUCCESS_CODE'           , 4056);
define('UPDATE_PROFILE_SUCCESS_CODE'          , 4057);
define('ID_REQUIRED_CODE'                     , 4058);
define('ID_EXISTS_CODE'                       , 4059);





// Exceptions Code
define('INCCORECT_DATA_ERROR_CODE'           , 9001);
define('MODEL_NOT_FOUND_CODE'                , 9002);
define('PRIVATE_KEY_CODE'                    , 9003);
define('EMAIL_VERIFIED_AT_CODE'              , 9004);
define('MESSAGE_NOT_FOUND_CODE'              , 9005);
define('MESSAGE_CODE_ERROR_CODE'             , 9006);
define('OTP_INVALID_CODE'                    , 9007);
define('EXPIRE_TIME_INVALID_CODE'            , 9008);
define('DATA_ERROR_CODE'                     , 9009);






define('ALL_MESSAGE_CODE'                  , 90001);



/**
* =================================================================================================
* Start ALL Function for Response Customize
*/

/**
* This function returns a global API response with the specified data and status code.
* @author Salah Derbas
*/
if (!function_exists('responseGlobal')) {
    function responseGlobal($data , $statusCode  = Response::HTTP_OK ){
        return response()->json($data, $statusCode);
    }
}

/**
*  This function returns a successful API response with specified data, message, and response code.
* @author Salah Derbas
*/
if (!function_exists('responseSuccess')) {
    function responseSuccess($data , $message = '' , $code = null){
        return responseGlobal([
            'success'             => true  ,
            'message'             => $message  ,
            'code'                => $code  ,
            'data'                => $data  ,
        ], Response::HTTP_OK);
    }
}

/**
*  This function returns an error response with a specified message, status code, and error code.
* @author Salah Derbas
*/
if (!function_exists('responseError')) {
    function responseError($message, $statusCode , $code = null){
        return responseGlobal([
            'success' => false,
            'error'   => [
                    'message'      => $message,
                    'code'         => $code,
            ]
        ], $statusCode);
    }
}

/**
*  This function returns a validation error response with message, status code, error code, and validation errors.
* @author Salah Derbas
*/
if (!function_exists('responseValidator')) {
    function responseValidator($message , $statusCode  , $code = null , $errors){
        return responseGlobal([
            'success' => false,
            'error'   => [
                    'message'    => $message,
                    'code'       => $code,
            ] ,
            'validator' => $errors
        ], $statusCode);
    }
}

/**
*  This function returns an unauthorized response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondUnauthorized')) {
    function respondUnauthorized($message = 'Unauthorized' ){
        return responseError($message, Response::HTTP_UNAUTHORIZED , Response::HTTP_UNAUTHORIZED);
    }
}

/**
*  This function returns a forbidden response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondForbidden')) {
    function respondForbidden($message = 'Forbidden'){
        return responseError($message, Response::HTTP_FORBIDDEN , Response::HTTP_FORBIDDEN);
    }
}

/**
* This function returns a "not found" response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondNotFound')) {
    function respondNotFound($message = 'Not Found' ){
        return responseError($message, Response::HTTP_INTERNAL_SERVER_ERROR , Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

/**
* This function returns an internal server error response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondInternalError')) {
    function respondInternalError($message = 'Internal Server Error'){
        return responseError($message, Response::HTTP_INTERNAL_SERVER_ERROR , Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

/**
* This function returns an "unprocessable entity" response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondUnprocessableEntity')) {
    function respondUnprocessableEntity($message = 'Unprocessable Entity'){
        return responseError($message, Response::HTTP_UNPROCESSABLE_ENTITY , Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

/**
* This function returns a "method not allowed" response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondMethodAllowed')) {
    function respondMethodAllowed($message){
        return responseError($message, Response::HTTP_METHOD_NOT_ALLOWED , Response::HTTP_METHOD_NOT_ALLOWED );
    }
}

/**
* This function returns a "model not found" response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondModelNotFound')) {
    function respondModelNotFound($message = 'Method Not Allowed'){
        return (new ApiResponse())->respondModelNotFound($message);
    }
}

/**
* This function returns a validation failure response with message, validation errors, and error codes.
* @author Salah Derbas
*/
if (!function_exists('respondValidationFailed')) {
    function respondValidationFailed($message = 'Validation failed' , $validate_errors , $codes){
        return responseValidator($message, Response::HTTP_UNPROCESSABLE_ENTITY , $codes , $validate_errors);
    }
}

/**
* This function returns an empty response with a specified message and code.
* @author Salah Derbas
*/
if (!function_exists('respondEmpty')) {
    function respondEmpty ($message = 'Not Found' , $code) {
        return responseError($message, Response::HTTP_OK , $code);
    }
}

/**
* This function returns a "too many requests" response with a specified message.
* @author Salah Derbas
*/
if (!function_exists('respondTooManyRequest')) {
    function respondTooManyRequest($message = 'Too Many Requests') {
        return responseError($message, Response::HTTP_TOO_MANY_REQUESTS , Response::HTTP_TOO_MANY_REQUESTS );
    }
}

/**
 * End ALL Function for Response Customize
 * =================================================================================================
*  @author Salah Derbas
*/




/**
* This function retrieves the status text associated with a response code. It uses translations
* for each code key from a specified language file. If no specific response code is provided,
* it returns all possible status texts; otherwise, it returns the specific status text or a default
* "message not found" code if the response code doesn't exist in the list.
* @author Salah Derbas
*/
if (!function_exists('getStatusText')) {
    function getStatusText($code){
        $key         = 'API/V1/code';

        $statusTexts = [
            MODEL_NOT_FOUND_CODE                  => trans($key.'.MODEL_NOT_FOUND_CODE'),
            PRIVATE_KEY_CODE                      => trans($key.'.PRIVATE_KEY_CODE'),
            INCCORECT_DATA_ERROR_CODE             => trans($key.'.INCCORECT_DATA_ERROR_CODE'),
            LOGIN_SUCCESS_CODE                    => trans($key.'.LOGIN_SUCCESS_CODE'),
            MESSAGE_NOT_FOUND_CODE                => trans($key.'.MESSAGE_NOT_FOUND_CODE'),
            MESSAGE_CODE_ERROR_CODE               => trans($key.'.MESSAGE_CODE_ERROR_CODE'),
            MESSAGE_CODE_SUCCESS_CODE             => trans($key.'.MESSAGE_CODE_SUCCESS_CODE'),
            LOOKUPS_SUCCESS_CODE                  => trans($key.'.LOOKUPS_SUCCESS_CODE'),
            EMAIL_EXISTS_CODE                     => trans($key.'.EMAIL_EXISTS_CODE'),
            PASSWORD_REQUIRED_CODE                => trans($key.'.PASSWORD_REQUIRED_CODE'),
            USER_DELETED_CODE                     => trans($key.'.USER_DELETED_CODE'),
            NAME_REQUIRED_CODE                    => trans($key.'.NAME_REQUIRED_CODE'),
            NAME_UNIQUE_CODE                      => trans($key.'.NAME_UNIQUE_CODE'),
            NAME_REGEX_CODE                       => trans($key.'.NAME_REGEX_CODE'),
            EMAIL_REQUIRED_CODE                   => trans($key.'.EMAIL_REQUIRED_CODE'),
            EMAIL_STRING_CODE                     => trans($key.'.EMAIL_STRING_CODE'),
            EMAIL_EMAIL_CODE                      => trans($key.'.EMAIL_EMAIL_CODE'),
            EMAIL_MAX_CODE                        => trans($key.'.EMAIL_MAX_CODE'),
            EMAIL_UNIQUE_CODE                     => trans($key.'.EMAIL_UNIQUE_CODE'),
            EMAIL_REGEX_CODE                      => trans($key.'.EMAIL_REGEX_CODE'),
            PASSWORD_VALIDATION_CODE              => trans($key.'.PASSWORD_VALIDATION_CODE'),
            OTP_REQUIRED_CODE                     => trans($key.'.OTP_REQUIRED_CODE'),
            GOOGLE_FAILED_CODE                    => trans($key.'.GOOGLE_FAILED_CODE'),
            FACEBOOK_FAILED_CODE                  => trans($key.'.FACEBOOK_FAILED_CODE'),
            CONFIRM_PASSWORD_REQUIRED_WITH_CODE   => trans($key.'.CONFIRM_PASSWORD_REQUIRED_WITH_CODE'),
            CONFIRM_PASSWORD_SAME_CODE            => trans($key.'.CONFIRM_PASSWORD_SAME_CODE'),
            CONFIRM_PASSWORD_MIN_CODE             => trans($key.'.CONFIRM_PASSWORD_MIN_CODE'),
            EMAIL_VERIFIED_AT_CODE                => trans($key.'.EMAIL_VERIFIED_AT_CODE'),
            CONTENT_EMPTY_CODE                    => trans($key.'.CONTENT_EMPTY_CODE'),
            CONTENT_SUCCESS_CODE                  => trans($key.'.CONTENT_SUCCESS_CODE'),
            MESSAGE_REQUIRED_CODE                 => trans($key.'.MESSAGE_REQUIRED_CODE'),
            SUBJECT_REQUIRED_CODE                 => trans($key.'.SUBJECT_REQUIRED_CODE'),
            CONTACT_US_SUCCESS_CODE               => trans($key.'.CONTACT_US_SUCCESS_CODE'),
            NOTIFICATION_EMPTY_CODE               => trans($key.'.NOTIFICATION_EMPTY_CODE'),
            NOTIFICATIONS_SUCCESS_CODE            => trans($key.'.NOTIFICATIONS_SUCCESS_CODE'),
            USER_NOT_FOUND_CODE                   => trans($key.'.USER_NOT_FOUND_CODE'),
            ENABLED_NOTIFICATION_SUCCESS_CODE     => trans($key.'.ENABLED_NOTIFICATION_SUCCESS_CODE'),
            TITLE_EN_REQUIRED_CODE                => trans($key.'.TITLE_EN_REQUIRED_CODE'),
            TITLE_AR_REQUIRED_CODE                => trans($key.'.TITLE_AR_REQUIRED_CODE'),
            BODY_EN_REQUIRED_CODE                 => trans($key.'.BODY_EN_REQUIRED_CODE'),
            BODY_AR_REQUIRED_CODE                 => trans($key.'.BODY_AR_REQUIRED_CODE'),
            USERS_STRING_CODE                     => trans($key.'.USERS_STRING_CODE'),
            SEND_NOTIFICATION_SUCCESS_CODE        => trans($key.'.SEND_NOTIFICATION_SUCCESS_CODE'),
            SEND_OTP_SUCCESS_CODE                 => trans($key.'.SEND_OTP_SUCCESS_CODE'),
            OTP_INVALID_CODE                      => trans($key.'.OTP_INVALID_CODE'),
            EXPIRE_TIME_INVALID_CODE              => trans($key.'.EXPIRE_TIME_INVALID_CODE'),
            CHECK_OTP_SUCCESS_CODE                => trans($key.'.CHECK_OTP_SUCCESS_CODE'),
            APPLE_ID_FAILED_CODE                  => trans($key.'.APPLE_ID_FAILED_CODE'),
            RESET_NEW_PASSWOED_CODE               => trans($key.'.RESET_NEW_PASSWOED_CODE'),
            GET_PROFILE_CODE                      => trans($key.'.GET_PROFILE_CODE'),
            REFRESH_TOKEN_CODE                    => trans($key.'.REFRESH_TOKEN_CODE'),
            USER_LOGOUT_CODE                      => trans($key.'.USER_LOGOUT_CODE'),
            NAME_CODE                             => trans($key.'.NAME_CODE'),
            PHONE_CODE                            => trans($key.'.PHONE_CODE'),
            COUNTRY_ID_REQUIRED_CODE              => trans($key.'.COUNTRY_ID_REQUIRED_CODE'),
            COUNTRY_ID_EXISTS_CODE                => trans($key.'.COUNTRY_ID_EXISTS_CODE'),
            GENDER_ID_REQUIRED_CODE               => trans($key.'.GENDER_ID_REQUIRED_CODE'),
            GENDER_ID_EXISTS_CODE                 => trans($key.'.GENDER_ID_EXISTS_CODE'),
            PHOTO_FILE_CODE                       => trans($key.'.PHOTO_FILE_CODE'),
            UPDATE_PROFILE_SUCCESS_CODE           => trans($key.'.UPDATE_PROFILE_SUCCESS_CODE'),
            DATA_ERROR_CODE                       => trans($key.'.DATA_ERROR_CODE'),
            DELETE_ACCONT_CODE                    => trans($key.'.DELETE_ACCONT_CODE'),
            REGISTER_USER_SUCCESS_CODE            => trans($key.'.REGISTER_USER_SUCCESS_CODE'),
            COUNTRIES_SUCCESS_CODE                => trans($key.'.COUNTRIES_SUCCESS_CODE'),
            GET_CATEGORY_SUCCESS_CODE             => trans($key.'.GET_CATEGORY_SUCCESS_CODE'),
            ID_EXISTS_CODE                        => trans($key.'.ID_EXISTS_CODE'),
            ID_REQUIRED_CODE                      => trans($key.'.ID_REQUIRED_CODE'),
            GET_CATEGORY_EMPTY_CODE               => trans($key.'.GET_CATEGORY_EMPTY_CODE'),
            GET_ITEMS_EMPTY_CODE                  => trans($key.'.GET_ITEMS_EMPTY_CODE'),
            GET_ITEMS_SUCCESS_CODE                => trans($key.'.GET_ITEMS_SUCCESS_CODE'),
            HOME_SUCCESS_CODE                     => trans($key.'.HOME_SUCCESS_CODE'),
            SEARCH_NOT_FOUND_CODE                 => trans($key.'.SEARCH_NOT_FOUND_CODE'),
            SEARCH_SUCCESS_CODE                   => trans($key.'.SEARCH_SUCCESS_CODE'),
            SLIDER_NOT_FOUND_CODE                 => trans($key.'.SLIDER_NOT_FOUND_CODE'),
            SLIDER_SUCCESS_CODE                   => trans($key.'.SLIDER_SUCCESS_CODE'),

        ];

        return ($code == ALL_MESSAGE_CODE) ? $statusTexts: $statusTexts[$code] ?? MESSAGE_NOT_FOUND_CODE;

    }
}
