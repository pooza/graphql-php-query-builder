<?php
namespace GraphQLQueryBuilder;

define('ROOT_DIR', dirname(dirname(__FILE__)));
require_once ROOT_DIR . '/src/QueryBuilder.php';
require_once ROOT_DIR . '/src/Utils.php';

$user_id = 1;

$builder = new QueryBuilder;
$builder->setObjectField('oysterApplicantPersonalInformationCollection');
$builder->setArguments(['userIdNo' => $user_id]);
$builder->addQueryObject([
  'items' => [
    'firstName', 'lastName',
    'firstNameKana', 'lastNameKana',
    'birthDate',
    'gender',
    'mobileNumber',
    'postalCode', 'addressJapanese',
	],
]);
$builder->addQueryObject([
  'items' => [
    'firstName', 'lastName',
    'firstNameKana', 'lastNameKana',
    'birthDate',
    'gender',
    'mobileNumber',
    'postalCode', 'addressJapanese',
	],
]);
echo $builder->build(true);
