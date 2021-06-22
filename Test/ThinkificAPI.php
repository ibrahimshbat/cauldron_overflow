<?php

//require '../vendor/autoload.php';
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpClient\HttplugClient;
class ThinkificAPI
{
    private Client $client;
    private const SUBDOMAIN = "evidence-based-education";
    private string $token = '1c1d77854a35f4f97cd186c3431ba578';
    /**'
     * ThinkificAPI constructor.
     * @param Client $client
     */
    public function __construct()
    {
       /* $this->client = new Client([
            'base_url' => 'https://api.thinkific.com/api/public/v1/',
            'headers'=>[
                'X-Auth-API-Key' => '1c1d77854a35f4f97cd186c3431ba578',
                'X-Auth-Subdomain' => SUBDOMAIN,
                'Content-Type' => 'application/json',
                ],
            ]);*/
       echo "Ibrahim". Uuid::uuid4()->toString();
    }

    public function getEnrolment(){
       // $this->client->get('enrolments', [

      //  ]
    }

    public function printtt(){
        echo "HellO API";
    }


}
new ThinkificAPI();

//echo Uuid::uuid4()->toString();
//new ThinkificAPI().printtt();
//Client $client = new Client(['base_uri' => 'https://evidencebased.education']);
// Send a request to https://foo.com/api/test
//$response = $client->request('GET', 'our-team');
//echo $response;
//echo Uuid::uuid4()->toString();
