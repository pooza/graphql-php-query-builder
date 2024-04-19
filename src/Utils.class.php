<?php
namespace GraphQLQueryBuilder;

class Utils {
  static public function isHashMap ($array) {
    $keys = array_keys($array);
    return (array_keys($keys) !== $keys);
  }
}
