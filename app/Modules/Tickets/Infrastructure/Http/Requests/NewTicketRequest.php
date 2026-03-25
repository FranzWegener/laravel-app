<?php

declare(strict_types=1);

namespace App\Modules\Tickets\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * This runs before the validation rules are applied.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'subject'   => strip_tags($this->input('subject')),
            'content' => strip_tags($this->input('content')),
        ]);
    }

    public function rules(): array
    {
        return [
            'type'    => ['required', 'string', 'in:problem,question,other'],
            'subject' => ['required', 'string', 'min:4', 'max:256'],
            'content' => ['required', 'string', 'min:4'],
        ];
    }
}
