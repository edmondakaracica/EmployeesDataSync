<?php

namespace App\Mapper;

class EmployeeMapper
{
    public function mapProvider1ToTrackTik(array $provider1Employee): array
    {
        return [
            'firstName'         => $provider1Employee['first_name'] ?? '',
            'lastName'          => $provider1Employee['last_name'] ?? '',
            'jobTitle'          => $provider1Employee['position'] ?? '',
            'gender'            => $provider1Employee['gender'] ?? '',
            'birthday'          => $provider1Employee['dob'] ?? '',
            'language'          => $provider1Employee['preferred_language'] ?? '',
            'customId'          => $provider1Employee['unique_code'] ?? '',
            'primaryPhone'      => $provider1Employee['phone'] ?? '',
            'email'             => $provider1Employee['contact_email'] ?? '',
        ];
    }

    public function mapProvider2ToTrackTik(array $provider2Employee): array
    {
        return [
            'firstName'         => $provider2Employee['employee_firstname'] ?? '',
            'lastName'          => $provider2Employee['employee_lastname'] ?? '',
            'jobTitle'          => $provider2Employee['title'] ?? '',
            'gender'            => $provider2Employee['gender_identity'] ?? '',
            'birthday'          => $provider2Employee['date_of_birth'] ?? '',
            'language'          => $provider2Employee['locale'] ?? '',
            'customId'          => $provider2Employee['employee_number'] ?? '',
            'primaryPhone'      => $provider2Employee['mobile_number'] ?? '',
            'email'             => $provider2Employee['work_email'] ?? '',
        ];
    }


}
