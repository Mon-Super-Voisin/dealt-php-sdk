<?php

namespace Dealt\DealtSDK\Utils;

class GraphQLFormatter
{
    public static function formatQuery(string $query)
    {
        return trim(preg_replace('/\s\s+/', ' ', $query));
    }

    public static function formatQueryParameters(string $queryParams)
    {
        return trim(preg_replace('/"([^"]+)"\s*:\s*/', ' $1: ', $queryParams));
    }
}
