<?php

class Alert
{
    protected $message;
    protected $severity;
    protected $link;
    protected $linkText;

    public function __construct(string $message, string $severity = 'info', ?string $link = null, ?string $linkText = null)
    {
        $this->message = $message;
        $this->severity = $severity;
        $this->link = $link;
        $this->linkText = $linkText;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Alert
    {
        $this->message = $message;
        return $this;
    }

    public function getSeverity(): string
    {
        return $this->severity;
    }

    public function setSeverity(string $severity = 'info'): Alert
    {
        $validSeverities = ['info', 'success', 'warning', 'danger'];
        if (!in_array($severity, $validSeverities)) {
            throw new Exception('Invalid severity level.');
        }

        $this->severity = $severity;
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): Alert
    {
        $this->link = $link;
        return $this;
    }

    public function getLinkText(): ?string
    {
        return $this->linkText;
    }

    public function setLinkText(?string $linkText): Alert
    {
        $this->linkText = $linkText;
        return $this;
    }
}

class WHMCSAPIClient
{
    protected $whmcsUrl;
    protected $apiIdentifier;
    protected $apiSecret;

    public function __construct(string $whmcsUrl, string $apiIdentifier, string $apiSecret)
    {
        $this->whmcsUrl = $whmcsUrl;
        $this->apiIdentifier = $apiIdentifier;
        $this->apiSecret = $apiSecret;
    }

       public function getUserByID(int $userId): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->whmcsUrl . 'includes/api.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'action' => 'GetClientsDetails',
            'identifier' => $this->apiIdentifier,
            'secret' => $this->apiSecret,
            'clientid' => '14',
            'responsetype' => 'json'
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception('cURL error: ' . $error);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception('API request failed with HTTP code ' . $httpCode);
        }

        $userData = json_decode($response, true);
        if (!$userData || !isset($userData['client'])) {
            throw new Exception('Invalid API response');
        }

        return $userData['client'];
    }
}

function displayUserAlert(Alert $alert, int $userId, string $whmcsUrl, string $apiIdentifier, string $apiSecret)
{
    $api = new WHMCSAPIClient($whmcsUrl, $apiIdentifier, $apiSecret);
    $userData = $api->getUserByID($userId);

    $responseData = [
        'alert' => [
            'message' => $alert->getMessage(),
            'severity' => $alert->getSeverity(),
            'link' => $alert->getLink(),
            'linkText' => $alert->getLinkText(),
        ],
        'user' => [
            'id' => $userData['id'],
            'name' => $userData['firstname'] . ' ' . $userData['lastname'],
        ],
    ];

    header('Content-Type: application/json');
    echo json_encode($responseData);
}

$whmcsUrl = "http://192.168.61.3/";
$apiIdentifier = "RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw";
$apiSecret = "lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM";

$userId = 13; 

$alert = new Alert('This is an example alert', 'warning', 'https://example.com', 'Click here');

try {
    displayUserAlert($alert, $userId, $whmcsUrl, $apiIdentifier, $apiSecret);
} catch (Exception $e) {
    $responseData = [
        'error' => $e->getMessage(),
    ];

    header('Content-Type: application/json');
    echo json_encode($responseData);
}