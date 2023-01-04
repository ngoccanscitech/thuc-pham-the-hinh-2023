<?php

function getConfigValueFromSettingTable($config_key)
{
    $setting = \App\Models\Setting::where('config_key', $config_key)->first();
    if (!empty($setting))
    {
        return $setting->config_value;
    }
    return null;
}
