<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Directory\Api\Http\Requests\Contact;

use Playground\Directory\Api\Http\Requests\FormRequest;

/**
 * \Playground\Directory\Api\Http\Requests\Contact\RestoreRequest
 */
class RestoreRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
