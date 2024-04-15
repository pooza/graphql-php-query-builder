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
  'name' => 'oysterApplicantPersonalInformationCollection',
  'data' => [
    'items' => [
      'firstName', 'lastName',
      'firstNameKana', 'lastNameKana',
      'birthDate',
      'gender',
      'mobileNumber',
      'postalCode', 'addressJapanese',
    ],
  ],
]);
$builder->addQueryObject([
  'name' => 'oysterApplicantEducationCollection',
  'data' => [
    'items' => [
      'year1Start',
      'month1Start',
      'schoolorcompanyInformation1Start',
      'year1End',
      'month1End',
      'schoolorcompanyInformation1End',
      'year2Start',
      'month2Start',
      'schoolorcompanyInformation2Start',
      'year2End',
      'month2End',
      'schoolorcompanyInformation2End',
    ],
  ],
]);
echo $builder->build();
