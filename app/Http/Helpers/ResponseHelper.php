<?php

/**
 * response422
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response422($errors, string $message = null)
{
    if ($message === null) $message = __('Form invalid');
    return response()->json([
        'errors' => $errors,
        'message' => $message,
    ], 422);
}

/**
 * response200
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response200($data = null, string $message = null)
{
    if ($message === null) $message = __('Success');
    return response()->json([
        'data' => $data,
        'message' => $message,
    ], 200);
}

/**
 * response404
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response404($data = null, string $message = null)
{
    if ($message === null) $message = __('Data not found.');
    return response()->json([
        'data' => $data,
        'message' => $message,
    ], 404);
}

/**
 * response200
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response500($data = null, string $message = null)
{
    if ($message === null) $message = __('Server Error');
    return response()->json([
        'data' => $data,
        'message' => $message,
    ], 500);
}
