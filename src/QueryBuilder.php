<?php
namespace GraphQLQueryBuilder;

class QueryBuilder {
  protected $queryObject;
  protected $objectField;
  protected $arguments;
  protected $queryType;
  protected $tab = '  ';

  const TYPE_QUERY = 'query';
  const TYPE_MUTATION = 'mutation';

  public function __construct (
    $objectField = '',
    $arguments = [],
    $query = [],
    $queryType = self::TYPE_QUERY
  ) {
    $this->setObjectField($objectField);
    $this->setArguments($arguments);
    $this->setQueryObject($query);
    $this->setQueryType($queryType);
  }

  public function buildQuery ($prettify = false, $operationName = '') {
    if (empty($this->queryObject)) {
      return '';
    }

    $tab = $prettify ? $this->tab : '';

    $graphQLQuery = $this->queryType ? $this->queryType . ' ' : 'query ';
    $graphQLQuery .= $operationName ? $operationName : '';

    $graphQLQuery .= "{\n" . $tab . $this->objectField;
    $graphQLQuery .= $this->arguments ? ' ' . $this->formatArguments($this->arguments) . "{\n" : "{\n";
    $graphQLQuery .= $prettify === true ? $this->renderQueryObjectPrettify($this->queryObject, 2) : $this->renderQueryObject($this->queryObject);
    $graphQLQuery .= $tab . "}\n}";

    return $graphQLQuery;
  }

  protected function renderQueryObject ($query = []) {
    $queryString = '';

    foreach ($query as $queryField => $queryFieldValue) {
      // recursive loop through every node
      if (!is_numeric($queryField)) {
        $queryString .= $queryField . "{\n";

        if (is_array($queryFieldValue)) {
          $queryString .= $this->renderQueryObject($queryFieldValue);
        } else {
          $queryString .= $queryFieldValue . "\n";
        }
        $queryString .= "}\n" ;
      } else {
        $queryString .= $queryFieldValue . "\n";
      }
    }

    return $queryString;
  }

  protected function renderQueryObjectPrettify ($query = [], $tabCount = 0) {
    $queryString = '';

    foreach ($query as $queryField => $queryFieldValue) {
      // recursive loop through every node
      if (!is_numeric($queryField)) {
        $queryString .= str_repeat($this->tab, $tabCount) . $queryField . "{\n";
        $tabCount++;

        if (is_array($queryFieldValue)) {
          $queryString .= $this->renderQueryObjectPrettify($queryFieldValue, $tabCount);
        } else {
          $queryString .= str_repeat($this->tab, $tabCount) . $queryFieldValue . "\n";
        }
        $tabCount--;
        $queryString .= str_repeat($this->tab, $tabCount) . "}\n" ;
      } else {
        $queryString .= str_repeat($this->tab, $tabCount) . $queryFieldValue . "\n";
      }
    }

    return $queryString;
  }

  protected function formatArguments ($arguments) {
    if ($arguments) {
      $formattedArgument = [];
      foreach ($arguments as $name => $type) {
        if (is_array($type)) {
          if (count($type) > 0 && is_string($type[0])) {
            $type = '["' . implode('","', $type) . '"]';
          } else {
            $type = '[' . implode(',', $type) . ']' ;
          }
        } else {
          $type = gettype($type) === 'string' ? '"' . $type . '"' : $type ;
        }
        $formattedArgument[] = $name . ': ' . $type;
      }
      return '(' . implode(', ', $formattedArgument) . ') ';
    }
    return '';
  }

  public function setQueryObject ($queryObject) {
    $this->queryObject = $queryObject ?? [];
    return $this;
  }

  public function setObjectField ($objectField) {
    $this->objectField = $objectField ?? '';
    return $this;
  }

  public function setArguments ($arguments) {
    $this->arguments = $arguments ?? [];
    return $this;
  }

  public function setQueryType ($queryType) {
    $this->queryType = $queryType ?? '';
    return $this;
  }
}
