<?php

namespace Coreproc\NovaToggleFields\Traits;

use Coreproc\NovaToggleFields\ToggleFieldUtilities;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Http\Requests\NovaRequest;

trait HasToggleableFields
{
    public function availableFields(NovaRequest $request)
    {
        $method = $this->fieldsMethod($request);

        $hiddenFields = [];

        if ($request->isResourceIndexRequest()) {
            $hiddenFields = ToggleFieldUtilities::parseHiddenFieldsRefererParams($request);
        }

        $fieldCollection = FieldCollection::make(array_values($this->filter($this->{$method}($request))));

        return $fieldCollection->filter(function ($field) use ($hiddenFields) {
            return ! in_array($field->attribute, $hiddenFields);
        });
    }
}
