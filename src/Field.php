<?php

namespace GraphQLQueryBuilder;
class Field extends QueryBuilder {
  protected $alias;

  public function __construct($alias = '', $arguments = [], $objectField = '') {
    $this->setAlias($alias);
    $this->setArguments($arguments);
    $this->setObjectField($objectField);
  }

  public function setAlias($alias) {
    $this->alias = $alias ?? '';
    return $this;
  }

  public function formatFieldsHeading() {
    $heading = [];
    $heading[] = $this->alias ? $this->alias . ':' : '';
    $heading[] = $this->objectField;
    $heading[] = $this->arguments ? ' ' . $this->formatArguments($this->arguments): '';
    return implode($heading);
  }
}
