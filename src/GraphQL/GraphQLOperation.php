<?php

namespace Dealt\DealtSDK\GraphQL;

use Dealt\DealtSDK\Exceptions\GraphQLException;
use Dealt\DealtSDK\Exceptions\GraphQLFailureException;
use Dealt\DealtSDK\Exceptions\GraphQLInvalidParametersException;
use Dealt\DealtSDK\GraphQL\Types\Input\AbstractInputType;
use Dealt\DealtSDK\GraphQL\Types\Object\AbstractObjectType;
use Dealt\DealtSDK\Utils\GraphQLFormatter;
use Exception;

abstract class GraphQLOperation implements GraphQLOperationInterface
{
    /** @var string */
    private static $operationType;

    /** @var string */
    public static $operationName;

    /** @var array */
    public static $operationParameters;

    /** @var AbstractObjectType */
    public static $operationResult;

    public function __construct()
    {
        $this->queryVars   = [];
    }

    public static function getOperationName()
    {
        return static::$operationName;
    }

    /**
     * Will throw GraphQLInvalidParametersException when a required
     * operation variable is missing in the current operation.
     *
     * @throws
     */
    public function validateQueryParameters()
    {
        $params        = static::$operationParameters;
        $operationType = static::$operationType;
        $operationName = static::$operationName;

        foreach ($params as $param => $type) {
            $inputType = is_array($type) ? $type['inputType'] : $type;

            if (str_ends_with($inputType, '!') && !isset($this->queryVars[$param])) {
                throw new GraphQLInvalidParametersException("Missing parameter $$param of type $inputType in $operationName $operationType");
            }
        }
    }

    /**
     * builds the body of a GraphQL query
     * as a HEREDOC string.
     *
     * @return string
     */
    public static function toQuery()
    {
        $operationType       = static::$operationType;
        $operationName       = static::$operationName;
        $operationResult     = static::$operationResult;
        $operationParameters = self::toQueryParametersDefinition();
        $queryParameters     = self::toQueryParameters();

        $query = <<<GRAPHQL
             $operationType $operationName$operationParameters {
                $operationName({$queryParameters}) {
                    __typename
                    {$operationResult::toFragment()}
                }
            }
        GRAPHQL;

        return GraphQLFormatter::formatQuery($query);
    }

    protected static function toQueryParametersDefinition()
    {
        $params = static::$operationParameters;

        if (empty($params)) {
            return '';
        }

        return '(' . array_reduce(
            array_keys($params),
            function ($accumulator, $key) use ($params) {
                $prefix    = $accumulator != '' ? ', ' : '';
                $type      = $params[$key];
                $inputType = is_array($type) ? $type['inputType'] : $type;

                return "$accumulator$prefix$$key: $inputType";
            },
            ''
        ) . ')';
    }

    protected static function toQueryParameters(): string
    {
        $params = static::$operationParameters;

        return GraphQLFormatter::formatQueryParameters(array_reduce(
            array_keys($params),
            function ($accumulator, $key) {
                $prefix = $accumulator != '' ? ', ' : '';

                return "$accumulator$prefix$key: $$key";
            },
            ''
        ));
    }

    public function toQueryVariables(): array
    {
        $args = $this->queryVars;

        return array_reduce(
            array_keys($args),
            function ($accumulator, $key) use ($args) {
                $input             = $args[$key];
                $accumulator[$key] = $input instanceof AbstractInputType ? $input->toArray() : $input;

                return $accumulator;
            },
            []
        );
    }

    /**
     * Parses a GraphQL query result and casts it
     * to the underlying result class which extends AbstractObjectType.
     *
     * @param string $result
     *
     * @throws GraphQLFailureException
     * @throws GraphQLException
     */
    public function parseResult($result): AbstractObjectType
    {
        try {
            $json = json_decode($result);
        } catch (Exception $e) {
            throw new GraphQLException($e->getMessage());
        }

        if (isset($json->errors)) {
            throw new GraphQLFailureException($json->errors[0]->message);
        }

        $query_name = $this->getOperationName();

        return static::$operationResult::fromJson($json->data->$query_name);
    }

    public function setApiKey(string $apiKey): self
    {
        $this->setQueryVar('apiKey', $apiKey);

        return $this;
    }

    public function setQueryVar(string $key, $value)
    {
        $this->queryVars[$key] = $value;
    }
}
