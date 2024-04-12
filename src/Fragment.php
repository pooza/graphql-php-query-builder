<?php
namespace GraphQLQueryBuilder;

class Fragment extends QueryBuilder {
  protected $type;

  public function __construct($type = '') {
    $this->setFragmentType($type);
  }

  public function formatInlineFragment() {
    return '... on ' . $this->type;
  }

  public function setFragmentType($type) {
    $this->type = $type ?? '';
    return $this;
  }
}
