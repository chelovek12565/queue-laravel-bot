<?php

namespace App\Http\Requests;

use App\Domain\Queue\DTO\QueueDTO;
use Illuminate\Foundation\Http\FormRequest;

class QueueRequest extends FormRequest
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
            'name' => ['required', 'string', ],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
        ];
    }

    public function toDTO(): QueueDTO
    {
        return new QueueDTO(
            name: $this->validated('name'),
            userId: $this->validated('user_id'),
            roomId: $this->validated('room_id')
        );
    }
}
