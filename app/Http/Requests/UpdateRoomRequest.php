<?php

namespace App\Http\Requests;

use App\Enums\RoomStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_name' => 'sometimes|string|max:60',
            'status'    => 'sometimes|string|in:' . implode(',', RoomStatusEnum::values()),
        ];
    }
}
