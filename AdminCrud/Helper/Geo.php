<?php
namespace Elogic\AdminCrud\Helper;

class Geo
{
    private const API_KEY = 'AIzaSyAd_-xQlcrAeV0EDRBfDJzjbfyXxdBMXUM';
    private const API_URL = 'https://maps.googleapis.com/maps/api/geocode/json?address=';

    public static function getCoordinates($address): array
    {
        $formattedAddr = str_replace(' ', '+', $address);
        $geocodeFromAddress = file_get_contents(
            self::API_URL .
            $formattedAddr .
            '&key=' . self::API_KEY .
            '&sensor=false'
        );
        $output = json_decode($geocodeFromAddress);
        $data = null;
        if ($output->status == 'OK') {
            $data['latitude'] = $output->results[0]->geometry->location->lat;
            $data['longitude'] = $output->results[0]->geometry->location->lng;
        }
        return $data;
    }
}
