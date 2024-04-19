<?php
require_once 'src/QueryBuilder.php';

$builder = new GraphQLQueryBuilder\QueryBuilder;

$builder->setArguments([
  'preview' => true,
  'where' => ['userIdNo' => 2],
]);

$builder->addObject([
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
$builder->addObject([
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
$builder->addObject([
  'name' => 'oysterApplicantSelfIntroductionCollection',
  'data' => [
    'items' => [
      'selfIntroJapanese',
    ],
  ],
]);
$builder->addObject([
  'name' => 'oysterApplicantSkillsAndCertificationsCollection',
  'data' => [
    'items' => [
      'skills',
      'certifications',
    ],
  ],
]);
$builder->addObject([
  'name' => 'oysterApplicantPreferencesCollection',
  'data' => [
    'items' => [
      'desiredConditions',
    ],
  ],
]);

print $builder->build();
