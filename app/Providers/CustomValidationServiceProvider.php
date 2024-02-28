<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('valid_group_ids', function ($attribute, $value, $parameters, $validator) {
            // Check if all values in the array exist in the 'id' column of the 'groups' table
            $existingGroupIds = \App\Models\ClientGroups::pluck('id')->toArray();
            foreach ($value as $groupId) {
                if (!in_array($groupId, $existingGroupIds)) {
                    return false;
                }
            }
            return true;
        });

        Validator::replacer('valid_group_ids', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The selected :attribute is not valid.');
        });
    }
}
