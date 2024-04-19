<?php
require_once 'src/QueryBuilder.php';

$builder = new GraphQLQueryBuilder\QueryBuilder;

$builder->setArguments([
  'preview' => true,
  'where' => ['userIdNo' => 2],
]);
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
      'year1Start', 'month1Start',
      'schoolorcompanyInformation1Start', 'year1End',
      'month1End', 'schoolorcompanyInformation1End',
      'year2Start', 'month2Start',
      'schoolorcompanyInformation2Start', 'year2End',
      'month2End', 'schoolorcompanyInformation2End',
    ],
  ],
]);
$builder->addQueryObject([
  'name' => 'oysterApplicantSelfIntroductionCollection',
  'data' => [
    'items' => [
      'selfIntroJapanese',
    ],
  ],
]);
$builder->addQueryObject([
  'name' => 'oysterApplicantSkillsAndCertificationsCollection',
  'data' => [
    'items' => [
      'skills',
      'certifications',
    ],
  ],
]);
$builder->addQueryObject([
  'name' => 'oysterApplicantPreferencesCollection',
  'data' => [
    'items' => [
      'desiredConditions',
    ],
  ],
]);

print $builder->build();
