<?php
namespace GraphQLQueryBuilder;

class QueryBuilder {
  const TYPE_QUERY = 'query';
  const TYPE_MUTATION = 'mutation';

  protected $arguments;
  protected $queryType;
  protected $objects = [];
  protected $tab = '  ';

  public function __construct ($args = [], $type = self::TYPE_QUERY) {
    $this->setArguments($args);
    $this->setQueryType($type);
  }

  public function addQueryObject($obj) {
    $this->objects[] = $obj;
  }

  public function build () {
    $obj = null;
    $query = [$this->queryType . " {\n"];
    foreach ($this->objects as $obj) {
      $line = $this->tab .  $obj['name'];
      if ($this->arguments) {
        $line .=  ' (' . $this->renderArguments($this->arguments) . ") {\n";
      } else {
        $line .= " {\n";
      }
      $query[] = $line;
      $query[] = $this->renderQueryObject($obj['data'], 2);
      $query[] = $this->tab . "}\n";
    }
    $query[] = "}";
    return implode($query);
  }

  protected function renderArguments ($value) {
    if (is_array($value)) {
      $dest = ['{'];
      foreach ($value as $k => $v) {
        $dest[] = $this->renderArguments($value);
      }
      $dest[] = ']';
      return implode(',', $dest);
    }
    return $k . ': ' . json_encode($value);
  }

  protected function renderQueryObject ($query = [], $depth = 0) {
    $dest = [];
    foreach ($query as $k => $v) {
      if (is_numeric($k)) {
        $dest[] = str_repeat($this->tab, $depth) . $v;
      } else  {
        $dest[] = str_repeat($this->tab, $depth) . $k . '{';
        $depth ++;
        if (is_array($v)) {
          $dest[] = $this->renderQueryObject($v, $depth);
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
