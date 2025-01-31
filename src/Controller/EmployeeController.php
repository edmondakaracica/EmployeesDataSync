<?php

namespace App\Controller;

use App\Mapper\EmployeeMapper;
use App\Client\TrackTikApiClient;
use RuntimeException;

class EmployeeController
{
    private EmployeeMapper $mapper;
    private TrackTikApiClient $apiClient;

    public function __construct(EmployeeMapper $mapper, TrackTikApiClient $apiClient)
    {
        $this->mapper = $mapper;
        $this->apiClient = $apiClient;
    }

    public function handleRequest()
    {
        $provider1Data = $this->loadMockEmployees(__DIR__ . '/../../data/provider1_employees.json');
        $provider2Data = $this->loadMockEmployees(__DIR__ . '/../../data/provider2_employees.json');

        // Merge and map employees from both providers
        $allMappedEmployees = array_merge(
            array_map([$this->mapper, 'mapProvider1ToTrackTik'], $provider1Data),
            array_map([$this->mapper, 'mapProvider2ToTrackTik'], $provider2Data)
        );

        $this->apiClient->sendEmployeeData($allMappedEmployees);
    }

    private function loadMockEmployees(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException("Mock data file not found: " . $filePath);
        }

        $jsonData = file_get_contents($filePath);
        $employees = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Invalid JSON format in " . $filePath);
        }

        return $employees;
    }

}
