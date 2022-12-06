<?php

namespace Coreproc\NovaToggleFields\Actions;

use Coreproc\NovaToggleFields\ToggleFieldUtilities;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class ToggleFields extends Action
{
    protected FieldCollection $fieldCollection;

    protected string $resource;

    public $standalone = true;

    public $confirmText = 'Check or uncheck to toggle the fields below.';

    public function __construct(string $resource, $fieldCollection)
    {
        $this->resource = $resource;
        $this->fieldCollection = $fieldCollection;
    }

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $hiddenFields = array_keys(array_filter($fields->toArray(), function ($value) {
            return ! $value;
        }));

        $hiddenFieldsQueryParams = http_build_query(['hiddenFields' => $hiddenFields]);

        $redirectUrl = Nova::url('/resources/' .
            call_user_func($this->resource . '::' . 'uriKey') . '?' .
            $hiddenFieldsQueryParams);

        return Action::redirect($redirectUrl);
    }

    /**
     * Get the fields available on the action.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $actionFeilds = [];
        $hiddenFields = ToggleFieldUtilities::parseHiddenFieldsRefererParams($request);

        foreach ($this->fieldCollection as $field) {
            $actionField = Boolean::make($field->name, $field->attribute);

            if (! in_array($field->attribute, $hiddenFields)) {
                $actionField->withMeta(['value' => true]);
            }

            $actionFeilds[] = $actionField;
        }

        return $actionFeilds;
    }
}
