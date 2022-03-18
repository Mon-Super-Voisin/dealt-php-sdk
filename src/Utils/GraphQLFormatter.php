<?php

namespace Dealt\DealtSDK\Utils;

class GraphQLFormatter
{
    /**
     * Format query by removing new lines, spaces and tabs.
     */
    public static function formatQuery(string $query): string
    {
        return trim((string) preg_replace('/\s\s+/', ' ', $query));
    }

    /**
     * Format parameters by stripping quotes on keys
     * when json encoding an array object.
     */
    public static function formatQueryParameters(string $queryParams): string
    {
        return trim((string) preg_replace('/"([^"]+)"\s*:\s*/', ' $1: ', $queryParams));
    }
}
