<?php
namespace Spotler;

use Spotler\Exceptions\SpotlerException;

/**
 * Class Client
 *
 * @package   spotler-client
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 * @copyright 2019 Stephan Eizinga
 * @link      https://github.com/steffjenl/spotler-client
 */
class Client
{
    /**
     * @var string $consumerKey
     */
    private $consumerKey;
    /**
     * @var string $consumerSecret
     */
    private $consumerSecret;
    /**
     * @var string $bashUrl
     */
    private $bashUrl = 'https://restapi.mailplus.nl';
    /**
     * @var string $certificate
     */
    private $certificate;
    /**
     * @var string $certificate
     */
    private $verifyCertificate;

    /**
     * @var string
     */
    private $oauthSignature = 'HMAC-SHA1';

    /**
     * @var string
     */
    private $oauthVersion = '1.0';

    /**
     * @var $responseCode int
     */
    private $responseCode;

    /**
     * @var $responseBody
     */
    private $responseBody;

    /**
     * Client constructor.
     *
     * @param string $consumerKey
     * @param string $consumerSecret
     * @param string $certificate
     * @param bool   $verifyCertificate
     */
    public function __construct($consumerKey, $consumerSecret, $certificate = null, $verifyCertificate = true)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->certificate = $certificate;
        $this->verifyCertificate = $verifyCertificate;
    }

    /**
     * execute
     *
     * @param string $endpoint
     * @return mixed
     * @throws SpotlerException
     * @throws
     */
    public function execute($endpoint, $method = 'GET', $data = null)
    {
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: " . $this->createAuthorizationHeader($method, $endpoint),
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => sprintf('%s/%s', $this->bashUrl, $endpoint),
            CURLOPT_HEADER         => 0,
        ]);
        $curl = $this->setExecuteMethode($curl, $method, $data);
        $curl = $this->setVerifyHostCertificate($curl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        $this->responseBody = $response;
        $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // when $response return false we have a critical error
        if ($response === false) {
            throw new SpotlerException(curl_error($curl), curl_errno($curl));
        }
        curl_close($curl);
        return $response;
    }

    /**
     * @return int
     */
    public function getLastResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return mixed
     */
    public function getLastResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * setExecuteMethode will set curl options
     *
     * @param $curl
     * @param string $method
     * @param mixed $data
     * @param mixed $filePath
     * @return mixed
     */
    private function setExecuteMethode($curl, $method, $data = null)
    {
        if ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        } else if ($method == 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        } else if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        return $curl;
    }


    /**
     * setVerifyHostCertificate
     *
     * @param resource $curl
     *
     * @return mixed
     * @throws \ParagonIE\Certainty\Exception\BundleException
     * @throws \ParagonIE\Certainty\Exception\EncodingException
     * @throws \ParagonIE\Certainty\Exception\FilesystemException
     * @throws \ParagonIE\Certainty\Exception\RemoteException
     * @throws \SodiumException
     */
    private function setVerifyHostCertificate($curl)
    {
        if ($this->verifyCertificate) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            return $curl;
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        return $curl;
    }

    /**
     * createAuthorizationHeader
     *
     * @return string
     */
    private function createAuthorizationHeader($method, $endpoint)
    {
        $authParams = [
            'oauth_consumer_key' => $this->consumerKey,
            'oauth_signature_method' => $this->oauthSignature,
            'oauth_timestamp' => time(),
            'oauth_nonce' => md5(microtime(true)),
            'oauth_version' => $this->oauthVersion
        ];

        $authParams['oauth_signature'] = $this->createSignature($authParams, $method, $endpoint);

        $authParamsValues = [];
        foreach ($authParams as $paramName => $paramValue) {
            $authParamsValues[] = $paramName . '="' . $paramValue . '"';
        }

        return 'OAuth ' . implode(',', $authParamsValues);
    }

    /**
     * createSignature
     *
     * @param array $authParams
     * @param string $method
     * @param string $endpoint
     * @return string
     */
    private function createSignature($authParams, $method, $endpoint)
    {
        $sigBase = strtoupper($method) . "&" . rawurlencode($this->bashUrl . '/' . $endpoint) . "&"
            . rawurlencode("oauth_consumer_key=" . rawurlencode($this->consumerKey)
                . "&oauth_nonce=" . rawurlencode($authParams['oauth_nonce'])
                . "&oauth_signature_method=" . rawurlencode($this->oauthSignature)
                . "&oauth_timestamp=" . $authParams['oauth_timestamp']
                . "&oauth_version=" . $this->oauthVersion);
        $sigKey = $this->consumerSecret . "&";

        return base64_encode(hash_hmac("sha1", $sigBase, $sigKey, true));
    }
}