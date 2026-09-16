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
            'name.required' => __('Как к вам обращаться?'),
            'name.max' => __('Имя слишком длинное.'),
            'contact.required' => __('Оставьте телефон, Telegram или email — чтобы мы могли связаться.'),
            'contact.min' => __('Проверьте контакт — он слишком короткий.'),
            'contact.max' => __('Контакт слишком длинный.'),
            'project_type.in' => __('Выберите тип проекта из списка.'),
            'message.max' => __('Описание слишком длинное — сократите до 5000 символов.'),
        ];
    }
}
