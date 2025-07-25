<?php

namespace App\Traits;

trait CommonFunctionalityTrait
{
    public $usersRoleId = ['2', '3'];
    public $trainerRoleId = '2';
    public $clientRoleId = '3';
    public $successCode = 200;
    public $invalidPassword = 400;
    public $validationCode = 401;
    public $recodeNotFoundCode = 404;
    public $somethingWrong = 408;
    public $recodeExistCode = 409;
    public $blockedUser = 403;

    public $responseMsg = [
        'success' => [
            'Record saved successfully.',
            'Record updated successfully.',
            'Record remove successfully.'

        ],
        'error' => [
            'Sorry! Record not found',
            'Oops! something went wrong.',
            'Sorry! Record already exist.',
            'Sorry! File not found in folder.',

        ],
        'validation' => [
            'Unauthorized user',
            'Sorry! invalid user',
            'Sorry! your account is deactivated.'
        ]
    ];

    public function getExceptionResponse($e)
    {
        return response()->json([
            'message' => $e->getMessage(),
            'status' => $e->getCode(),
        ]);
    }
    public function recordNotFoundResponse()
    {
        return response()->json([
            'message' => $this->responseMsg['error'][0],
            'status' => $this->recodeNotFoundCode,
        ]);
    }
    public function recordExistResponse()
    {
        return response()->json([
            'message' => $this->responseMsg['error'][2],
            'status' => $this->recodeExistCode,
        ]);
    }
    public function recordRemove()
    {
        return response()->json([
            'message' => $this->responseMsg['success'][2],
            'status' => $this->successCode,
        ]);
    }
    public function somethingWrong()
    {
        return response()->json([
            'message' => $this->responseMsg['error'][1],
            'status' => $this->somethingWrong,
        ]);
    }
    public function customResponse($msg, $status)
    {
        return response()->json([
            'message' => $msg,
            'status' => $status,
        ]);
    }
    public function recordUpdate()
    {
        return response()->json([
            'message' => $this->responseMsg['success'][1],
            'status' => $this->successCode,
        ]);
    }
    public function filterRequestData($data)
    {
        $returnData = array();
        $returnData['showPage'] = isset($data->limit) ? $data->limit : 10;
        $returnData['sortBy'] = isset($data->sorting['by']) ? $data->sorting['by'] : 'id';
        $returnData['sortOrder'] = isset($data->sorting['order']) ? $data->sorting['order'] : 'DESC';
        return $returnData;
    }
}
