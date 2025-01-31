<?php

namespace App\Client;

class TrackTikApiClient
{
    private string $accessToken;
    private string $apiUrl;

    public function __construct(string $accessToken, string $apiUrl)
    {
        $this->accessToken = $accessToken;
        $this->apiUrl = $apiUrl;
    }

    // Sends employee data to TrackTik's API
    public function sendEmployeeData(array $employeeData): array
    {
        $multiHandle = curl_multi_init();
        $handles = [];
        $responses = [];

        foreach ($employeeData as $employee) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($employee));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->accessToken,
                'Content-Type: application/json',
            ]);

            curl_multi_add_handle($multiHandle, $ch);
            $handles[] = $ch;
        }

        // Execute all requests in parallel
        do {
            curl_multi_exec($multiHandle, $running);
            curl_multi_select($multiHandle);
        } while ($running > 0);

        // Handle responses
        foreach ($handles as $ch) {
            $response = curl_multi_getcontent($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP status before removing handle
            $data = json_decode($response, true);

            if (!in_array($httpCode, [200, 201], true)) {
                echo 'Failed to send data for employee. HTTP code: ' . $httpCode . ' Response: ' .  nl2br(htmlspecialchars($response)) . '<br>';
            } elseif (isset($data['data']['customId'])) {
                echo 'Employee with ID ' . $data['data']['customId'] . ' was added successfully.<br>';
            }

            $responses[] = ['httpCode' => $httpCode, 'response' => $data];

            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        curl_multi_close($multiHandle);

        return $responses;
    }
}
