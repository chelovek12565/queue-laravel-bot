<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Domain\User\Domain\DTO\UserDTO;

class UserRequest extends FormRequest
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
            'tgid' => ['required', 'integer'],
            'first_name' => ['required','string','max:255'],
            'second_name' => ['nullable','string','max:255'],
            'username' => ['nullable','string','max:255'],
        ];
    }

    public function toDTO(): UserDTO
    {
        return new UserDTO(
            tgid: $this->validated('tgid'),
            firstName: $this->validated('first_name'),
            secondName: $this->validated('second_name'),
            username: $this->validated('username')
        );
    }
}
