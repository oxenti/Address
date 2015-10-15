<?php
namespace Address\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Http\Client;

include_once "lib" . DS . "simple_html_dom.php";

class AddressComponent extends Component
{
    /**
     * Retuns the full address
     */
    public function getByZipcode($zipcode)
    {
        $http = new Client();
        $response = $http->get('http://www.consultaenderecos.com.br/busca-cep/' . $zipcode);
        $html = str_get_html($response->body());
        $lines = $html->find("table td");

        $data = [];
        $data['street'] = isset($lines[1]) ? $lines[1]->innertext : '';
        $data['neighborhood'] = isset($lines[2]) ? $lines[2]->innertext : '';
        $data['city'] = isset($lines[3]) ? $lines[3]->innertext : '';
        $data['state'] = isset($lines[4]) ? $lines[4]->innertext : '';

        return $data;
    }
}
