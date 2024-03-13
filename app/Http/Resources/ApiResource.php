<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public $status;
    public $message;
    public $resource;
    public $httpStatus;
    public $httpMesage;
    public $headers;

    public function __construct($status, $message, $resource, $httpStatus = 200, $httpMesage = 'Ok', $headers = [])
    {
        $this->status = $status;
        $this->message = $message;
        parent::__construct($resource);
        $this->httpStatus = $httpStatus;
        $this->httpMesage = $httpMesage;
        $this->headers = $headers;
    }
        
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource,
            'httpStatus' => $this->httpStatus,
            'httpMesage' => $this->httpMesage,
        ];
    }

    public function toResponse($request)
    {
        return response($this->toArray($request), $this->httpStatus, $this->headers);
    }
}
