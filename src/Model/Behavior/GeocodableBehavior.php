<?php
namespace Address\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

/**
 * Geocodable behavior
 */
class GeocodableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'apiUrl' => 'http://maps.google.com/maps/api/geocode/json',
        'language' => 'pt',
        'region' => 'br',
        'fields' => [
            'street' => 'street',
            'neighborhood' => 'neighborhood',
            'city' => 'city',
            'state' => 'state',
            'country' => 'country',
            'zipcode' => 'zipcode'
        ]
    ];

    public $apiFieldMap = [
        'route' => 'street',
        'sublocality_level_1' => 'neighborhood',
        'locality' => 'city',
        'administrative_area_level_1' => 'state',
        'country' => 'country',
        'postal_code' => 'zipcode',
    ];

    public $config = [];

    public function initialize(array $config)
    {
        $this->config = array_merge($this->_defaultConfig, $config);
    }

    // function to geocode address, it will return false if unable to geocode address
    public function getCoordinates($address)
    {
        // url encode the address
        $address = urlencode($address);
         
        // google map geocode api url
        $url = "{$this->config['apiUrl']}?address={$address}&language={$this->config['language']}&region={$this->config['region']}";
        // get the json response
        $httpClient = new Client();
        $respJson = $httpClient->get($url);
         
        // decode the json
        $resp = json_decode($respJson->body(), true);
     
        // response status will be 'OK', if able to geocode given address
        if ($resp['status'] == 'OK') {
            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formattedAddress = $resp['results'][0]['formatted_address'];
             
            // verify if data is complete
            if ($lati && $longi && $formattedAddress) {
                // put the data in the array
                $dataArr = [];
                 
                array_push(
                    $dataArr,
                    $lati,
                    $longi,
                    $formattedAddress
                );
                 
                return $dataArr;
                 
            } else {
                return false;
            }
             
        } else {
            return false;
        }
    }

    public function decodeAddress($lat, $lng)
    {
        $url = "{$this->config['apiUrl']}?latlng={$lat},{$lng}&language={$this->config['language']}&region={$this->config['region']}";
        
        $httpClient = new Client();
        $response = $httpClient->get($url);
         
        if (! $response->isOk()) {
            return false;
        }

        $resp = json_decode($response->body(), true);
        // debug($resp);
        if (! isset($resp['results']['0'])) {
            return false;
        }

        $address = [];
        foreach ($resp['results'][0]['address_components'] as $component) {
            if (!isset($this->apiFieldMap[$component['types'][0]])) {
                continue;
            }
            $address[$this->config['fields'][$this->apiFieldMap[$component['types'][0]]]] = $component['long_name'];
        }

        return $address;
    }
}
