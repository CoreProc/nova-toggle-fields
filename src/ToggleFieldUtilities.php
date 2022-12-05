<?php

namespace Coreproc\NovaToggleFields;

use Laravel\Nova\Http\Requests\NovaRequest;

class ToggleFieldUtilities
{
    public static function parseHiddenFieldsRefererParams(NovaRequest $novaRequest)
    {
        $hiddenFields = [];

        $parts = parse_url($novaRequest->header('Referer'));
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
            if (isset($query['hiddenFields'])) {
                $hiddenFields = $query['hiddenFields'];
            }
        }

        return $hiddenFields;
    }
}
