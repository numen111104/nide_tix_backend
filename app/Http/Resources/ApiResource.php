<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public $status;
    public $message;
    public $resource;
    public $httpStatus;
    public $httpMessage;
    public $headers;

    public function __construct($status, $message, $resource, $httpStatus, $httpMessage, $headers = [])
    {
        $this->status = $status;
        $this->message = $message;
        parent::__construct($resource);
        $this->httpStatus = $httpStatus;
        $this->httpMessage = $httpMessage;
        $this->headers = $headers;
    }
        
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource, // Tetap menggunakan $this->resource
        ];
    }

    public function toResponse($request)
    {
        return response($this->toArray($request), $this->httpStatus, $this->headers);
    }
}
