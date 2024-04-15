<?php
namespace GraphQLQueryBuilder;

class QueryBuilder {
  const TYPE_QUERY = 'query';
  const TYPE_MUTATION = 'mutation';

  protected $objectField;
  protected $arguments;
  protected $queryType;
  protected $objects = [];
  protected $tab = '  ';

  public function __construct ($field = '', $args = [], $type = self::TYPE_QUERY) {
    $this->setObjectField($field);
    $this->setArguments($args);
    $this->setQueryType($type);
  }

  public function addQueryObject($obj) {
    $this->objects[] = $obj;
  }

  public function build () {
    $query = [];
    $query[] = $this->queryType ? $this->queryType . ' ' : 'query ';
    $query[] = "{\n" . $this->tab . $this->objectField;
    if ($this->arguments) {
      $query[] = ' ' . json_encode($this->arguments) . "{\n";
    } else {
      $query[] = "{\n";
    }
    $obj = null;
    foreach ($this->objects as $obj) {
      $query[] = $this->renderQueryObjectPrettify($obj, 2);
    }
    $query[] = $this->tab . "}\n}";
    return implode($query);
  }

  protected function renderQueryObjectPrettify ($query = [], $depth = 0) {
    $dest = [];
    foreach ($query as $k => $v) {
      if (is_numeric($k)) {
        $dest[] = str_repeat($this->tab, $depth) . $v;
      } else  {
        $dest[] = str_repeat($this->tab, $depth) . $k . '{';
        $depth ++;
        if (is_array($v)) {
          $dest[] = $this->renderQueryObjectPrettify($v, $depth);
        } else {
          $dest[] = str_repeat($this->tab, $depth) . $v;
        }
        $depth --;
        $dest[] = str_repeat($this->tab, $depth) . "}\n";
      }
    }
    return implode("\n", $dest);
  }

  public function setObjectField ($field) {
    $this->objectField = $field ?? '';
    return $this;
  }

  public function setArguments ($args) {
    $this->arguments = $args ?? [];
    return $this;
  }

  public function setQueryType ($type) {
    $this->queryType = $type ?? '';
    return $this;
  }
}
