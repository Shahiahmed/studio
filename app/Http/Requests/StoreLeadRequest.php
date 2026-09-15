<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'contact' => ['required', 'string', 'min:5', 'max:190'],
            'project_type' => ['nullable', Rule::in(array_keys(config('studio.project_types')))],
            'message' => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * Without JS, bring the visitor back to the form instead of the top of the page.
     */
    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl().'#contact';
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Как к вам обращаться?',
            'name.max' => 'Имя слишком длинное.',
            'contact.required' => 'Оставьте телефон, Telegram или email — чтобы мы могли связаться.',
            'contact.min' => 'Проверьте контакт — он слишком короткий.',
            'contact.max' => 'Контакт слишком длинный.',
            'project_type.in' => 'Выберите тип проекта из списка.',
            'message.max' => 'Описание слишком длинное — сократите до 5000 символов.',
        ];
    }
}
