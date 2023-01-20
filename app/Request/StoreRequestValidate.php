<?php
declare(strict_types = 1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class StoreRequestValidate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}