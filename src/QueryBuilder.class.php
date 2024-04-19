<?php
namespace GraphQLQueryBuilder;

require_once 'Util.class.php';

class QueryBuilder {
  const TYPE_QUERY = 'query';
  const TYPE_MUTATION = 'mutation';

  protected $arguments;
  protected $queryType;
  protected $objects = [];
  protected $tab = '  ';

  public function __construct ($args = [], $type = self::TYPE_QUERY) {
    $this->setArguments($args);
    $this->setType($type);
  }

  public function setArguments ($args) {
    $this->arguments = $args ?? [];
    return $this;
  }

  public function setType ($type) {
    $this->queryType = $type ?? '';
    return $this;
  }

  public function addObject($obj) {
    $this->objects[] = $obj;
  }

  public function build () {
    $obj = null;
    $query = [$this->queryType . " {\n"];
    foreach ($this->objects as $obj) {
      $line = $this->tab . $obj['name'];
      if ($this->arguments) {
        $line .=  ' ' . $this->renderArguments($this->arguments) . " {\n";
      } else {
        $line .= " {\n";
      }
      $query[] = $line;
      $query[] = $this->renderObject($obj['data'], 2);
      $query[] = $this->tab . "}\n";
    }
    $query[] = "}\n";
    return implode($query);
  }

  protected function renderArguments ($value, $level = 0) {
    if (is_array($value)) {
      $dest = [];
      if (Util::isHashMap($value)) {
        foreach ($value as $k => $v) {
          if (!empty($k) && !empty($v)) {
            $dest[] = $k . ': ' . $this->renderArguments($v, $level + 1);
          }
        }
        if (0 < $level) {
          return '{' . implode(', ', $dest) . '}';
        } else {
          return '(' . implode(', ', $dest) . ')';
        }
      } else {
        foreach ($value as $k => $v) {
          if (!empty($v)) {
            $dest[] = $this->renderArguments($v, $level + 1);
          }
        }
        return '[' . implode(', ', $dest) . ']';
      }
    } else if (!empty($value)){
      return json_encode($value);
    }
  }

  protected function renderObject ($query = [], $level = 0) {
    $dest = [];
    foreach ($query as $k => $v) {
      if (is_numeric($k)) {
        $dest[] = str_repeat($this->tab, $level) . $v;
      } else  {
        $dest[] = str_repeat($this->tab, $level) . $k . '{';
        $level ++;
        if (is_array($v)) {
          $dest[] = $this->renderObject($v, $level);
        } else {
          $dest[] = str_repeat($this->tab, $level) . $v;
        }
        $level --;
        $dest[] = str_repeat($this->tab, $level) . "}\n";
      }
    }
    return implode("\n", $dest);
  }
}
