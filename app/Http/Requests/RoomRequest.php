<?php

namespace App\Http\Requests;
use App\Domain\Room\DTO\RoomDTO;
use Spatie\LaravelData\Optional;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function toDTO(): RoomDTO
    {
        return new RoomDTO(
            userId: $this->validated('user_id'),
            name: $this->validated('name'),
            description: $this->validated('description') ?? Optional::create()
        );
    }
}
