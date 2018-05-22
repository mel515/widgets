<?php

namespace InetStudio\Widgets\Http\Requests\Back;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Widgets\Contracts\Http\Requests\Back\SaveWidgetRequestContract;

/**
 * Class SaveWidgetRequest.
 */
class SaveWidgetRequest extends FormRequest implements SaveWidgetRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [

        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @param Request $request
     *
     * @return array
     */
    public function rules(Request $request): array
    {
        return [

        ];
    }
}
