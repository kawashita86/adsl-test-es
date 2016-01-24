<?php

/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 23/01/2016
 * Time: 09:50
 */
namespace AppBundle\Utils;

class ComparaWebService {

    public $results;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * ComparaWebService constructor.
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct(\GuzzleHttp\Client $client = null)
    {
        $this->client = $client;
    }

    public function findCities($city) {
        if(empty($city))
            return array('result' => '');

        $response = $this->client->request('POST', 'find/city', ['json' => ['city' => trim($city)]]);
        return json_decode($response->getBody(), true);
    }

    public function findStreets($city, $street) {
        if(empty($street))
            return array('result' => '');

        $response = $this->client->request('POST', 'find/street',
            ['json' => [
                'city' => $city,
                'street' => $street
            ]]);
        return json_decode($response->getBody(), true);
    }

    public function findCivics($city, $street,$civic, $particella = 'V' ) {
        if(empty($civic))
            return array('result' => '');

        $response = $this->client->request('POST', 'find/civic',
            ['json' => [
                'city' => trim($city),
                'street' => trim($street),
                'civic' => trim($civic),
                'particella' => trim($particella)
            ]]);
        return json_decode($response->getBody(), true);
    }
    /**
     * Request to remote API comparasemplice for best offers sorted by performance
     * @return array
     */
    public function getComparator(){
        // @todo change tlc with adsl
       $response = $this->client->request('GET', 'tlc/q', ['query' => ['sort' => 'velocita']]);

       if($response->getStatusCode() == 200)
       {
           $this->results = json_decode($response->getBody(),true);
           return $this->formatOffersResults();

       } else {
           return array();
       }
    }

    /**
     * Add custom element to the API results
     * @return mixed
     */
    public function formatOffersResults(){
        foreach($this->results as &$offer){
            $offer['start_price_decimal'] = '.00';
            $offer['default_price_decimal'] = '.00';
            if(strpos($offer['start_price'], '.') !== false){
                $start_price = explode('.', (string)$offer['start_price']);
                $offer['start_price'] = (int)$start_price[0];
                $offer['start_price_decimal'] = '.'.$start_price[1];
            }
            if(strpos($offer['default_price'], '.') !== false){
                $start_price = explode('.', (string)$offer['default_price']);
                $offer['default_price'] = (int)$start_price[0];
                $offer['default_price_decimal'] = '.'.$start_price[1];
            }
        }
        return $this->results;
    }


    /**
     * Mock provider for sample information
     * @return mixed
     */
    public function mockComparator()
    {
        $this->results = [['id' => 74, 'id_provider' => 2, 'customer' => 'RES', 'name' => 'TIM SMART CASA', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 29, 'activation_price' => 0, 'min_subscribtion' => '36 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '2016-01-29', 'default_price' => 39, 'modem' => 'NO', 'modem_type' => '', 'modem_price' => 3.9, 'phone_start_call_price' => 0, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 20, 'speed_upload' => 1, 'exp_connection' => 3, 'exp_call_center' => 3, 'exp_chat' => 1, 'exp_personal' => 3, 'exp_act_time' => 3, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', 'extra_bitstream' => '', 'extra_fo_price' => '', 'other_info' => 'Navighi ad alta velocità  con l\'ADSL di Telecom Italia e puoi chiamare gratis tutti i numeri di rete fissa e i mobili in italia. Tim Vision incluso', 'sin_top' => 1, 'link' => 'http://ad.zanox.com/ppc/?36358750C1393961443T', 'is_active' => 1],
            ['id' => 5, 'id_provider' => 6, 'customer' => 'RES', 'name' => 'Absolute ADSL', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 22.95, 'activation_price' => 0, 'min_subscribtion' => '', 'promo_price_expire' => 'standard', 'offer_expire' => '2016-01-25', 'default_price' => 22.95, 'modem' => 'NO', 'modem_type' => '', 'modem_price' => 3, 'phone_start_call_price' => 0.18, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 20, 'speed_upload' => 1, 'exp_connection' => 3, 'exp_call_center' => 3, 'exp_chat' => 1, 'exp_personal' => 3, '[exp_act_time' => 3, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', '[extra_bitstream' => 5, 'extra_fo_price' => '', 'other_info' => 'chiamate a 0 cent. al minuto e 18,15 cent. di addebito alla risposta verso numeri Fissi in Italia, Europa Occidentale*, USA e Canada e verso tutti i mobili in Italia.', 'sin_top' => 2, 'link' => 'https://www.infostrada.it/it/adsl/absolute_adsl.phtml?source=841000', 'is_active' => 1],
            ['id' => 26, 'id_provider' => 6, 'customer' => 'RES', 'name' => 'Absolute Fibra', 'sin_label' => '', 'type' => 'FIBRA OTTICA + TEL', 'start_price' => 27.95, 'activation_price' => 140, 'min_subscribtion' => '', 'promo_price_expire' => 'standard', 'offer_expire' => '2016-01-25', 'default_price' => 27.95, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0.18, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 30, 'speed_upload' => 3, 'exp_connection' => 4, 'exp_call_center' => 3, 'exp_chat' => 1, 'exp_personal' => 3, 'exp_act_time' => 3, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', 'extra_bitstream' => 5, 'extra_fo_price' => '', 'other_info' => 'Connessione internet illimitata con velocitÃ  fino 30MB, tecnologia FTTC, chiamate a 0 cent. al minuto e 18,15 cent. di addebito alla risposta verso numeri Fissi in Italia, Europa Occidentale*, USA e Canada e verso tutti i mobili in Italia. Costo di attivazione rateizzabile in 30 rate da 3 â‚¬/mese.', 'sin_top' => 2, 'link' => 'https://www.infostrada.it/it/adsl/absolute_adsl.phtml?source=841000', 'is_active' => 1],
            ['id' => 44, 'id_provider' => 1, 'customer' => 'RES', 'name' => 'Jet', 'sin_label' => '', 'type' => 'FIBRA OTTICA + TEL', 'start_price' => 25, 'activation_price' => 36, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '2016-01-29', 'default_price' => 35, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0.18, 'phone_mobile_price' => 0.19, 'phone_italian_price' => '', 'speed_download' => 100, 'speed_upload' => 10, 'exp_connection' => 5, 'exp_call_center' => 5, 'exp_chat' => 1, 'exp_personal' => 5, 'exp_act_time' => 3, 'extra_mail' => 'SI', 'extra_static_ip' => 'NO', 'extra_bitstream' => 3, 'extra_fo_price' => 'dal II anno 5â‚¬', 'other_info' => 'Internet illimitato + chiamate verso rete fissa nazionale gratuite con addebito del solo scatto alla risposta di 18 â‚¬cent. e chiamate verso rete mobile nazionale a soli 20 â‚¬cent di scatto alla e 19â‚¬cent/min', 'sin_top' => 3, 'link' => 'http://ad.zanox.com/ppc/?30321441C1076141384T', 'is_active' => 1],
            ['id' => 45, 'id_provider' => 1, 'customer' => 'RES', 'name' => 'Jet', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 25, 'activation_price' => 36, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '2016-01-29', 'default_price' => 35, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0.18, 'phone_mobile_price' => 0.19, 'phone_italian_price' => '', 'speed_download' => 20, 'speed_upload' => 1, 'exp_connection' => 4, 'exp_call_center' => 5, 'exp_chat' => 1, 'exp_personal' => 5, 'exp_act_time' => 3, 'extra_mail' => 'SI', 'extra_static_ip' => 'NO', 'extra_bitstream' => 3, 'extra_fo_price' => '', 'other_info' => 'Internet illimitato + chiamate verso rete fissa nazionale gratuite con addebito del solo scatto alla risposta di 18 â‚¬cent. e chiamate verso rete mobile nazionale a soli 20 â‚¬cent di scatto alla e 19â‚¬cent/min', 'sin_top' => 3, 'link' => 'http://ad.zanox.com/ppc/?30321441C1076141384T', 'is_active' => 1],
            ['id' => 58, 'id_provider' => 1, 'customer' => 'RES', 'name' => 'Super Jet', 'sin_label' => '', 'type' => 'FIBRA OTTICA + TEL', 'start_price' => 29, 'activation_price' => 36, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '2016-01-29', 'default_price' => 39, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 100, 'speed_upload' => 10, 'exp_connection' => 5, 'exp_call_center' => 5, 'exp_chat' => 1, 'exp_personal' => 5, 'exp_act_time' => 3, 'extra_mail' => 'SI', 'extra_static_ip' => 'NO', 'extra_bitstream' => 3, 'extra_fo_price' => 'dal II anno 5â‚¬', 'other_info' => 'Internet illimitato + chiamate illimitate verso fissi e mobili nazionali + un servizio digitale incluso per 18 mesi tra Dropbox Pro, Corriere della Sera Digital Edition, Gazzetta Gold, Il Sole 24 Ore Quotidiano Digitale e Deezer Premium+', 'sin_top' => 3, 'link' => 'http://ad.zanox.com/ppc/?30321386C52179517T', 'is_active' => 1],
            ['id' => 59, 'id_provider' => 1, 'customer' => 'RES', 'name' => 'Super Jet', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 29, 'activation_price' => 36, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '2016-01-29', 'default_price' => 39, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 20, 'speed_upload' => 1, 'exp_connection' => 4, 'exp_call_center' => 5, 'exp_chat' => 1, 'exp_personal' => 5, 'exp_act_time' => 3, 'extra_mail' => 'SI', 'extra_static_ip' => 'NO', 'extra_bitstream' => 3, 'extra_fo_price' => '', 'other_info' => 'Internet illimitato + chiamate illimitate verso fissi e mobili nazionali + un servizio digitale incluso per 18 mesi tra Dropbox Pro, Corriere della Sera Digital Edition, Gazzetta Gold, Il Sole 24 Ore Quotidiano Digitale e Deezer Premium+', 'sin_top' => 3, 'link' => 'http://ad.zanox.com/ppc/?30321386C52179517T', 'is_active' => 1],
            ['id' => 3, 'id_provider' => 4, 'customer' => 'RES', 'name' => 'Super Fibra', 'sin_label' => '', 'type' => 'FIBRA OTTICA + TEL', 'start_price' => 25, 'activation_price' => 192, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'standard', 'offer_expire' => '2016-01-29', 'default_price' => 25, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0.19, 'phone_mobile_price' => 0.19, 'phone_italian_price' => '', 'speed_download' => 100, 'speed_upload' => 20, 'exp_connection' => 4, 'exp_call_center' => 2, 'exp_chat' => 2, 'exp_personal' => 4, 'exp_act_time' => 4, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', 'extra_bitstream' => '', 'extra_fo_price' => '', 'other_info' => 'Internet illimitato fino a 100 MB + Chiamate verso fissi a 19 cent a chiamata e 19 cent scatto alla risposta + 19 cent/minuto verso mobili + 1GB di Internet 4G al mese per navigare fuori casa + 12 mesi di Sky online . Vodafone Station Revolution von Wi-Fi ultra veloce: 4 volte piÃ¹ veloce di un modem tradizionale', 'sin_top' => 4, 'link' => 'http://ad.zanox.com/ppc/?31391255C1885386155T', 'is_active' => 1],
            ['id' => 1, 'id_provider' => 4, 'customer' => 'RES', 'name' => 'Super ADSL', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 29, 'activation_price' => 192, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'standard', 'offer_expire' => '2016-01-29', 'default_price' => 29, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0.19, 'phone_mobile_price' => 0.19, 'phone_italian_price' => '', 'speed_download' => 20, 'speed_upload' => 1, 'exp_connection' => 3, 'exp_call_center' => 2, 'exp_chat' => 2, 'exp_personal' => 4, 'exp_act_time' => 4, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', 'extra_bitstream' => '', 'extra_fo_price' => '', 'other_info' => 'Internet illimitato fino a 20 MB + Chiamate verso fissi a 19 cent a chiamata e 19 cent scatto alla risposta + 19 cent/minuto verso mobili + 1GB di Internet 4G al mese per navigare fuori casa . Vodafone Station Revolution von Wi-Fi ultra veloce: 4 volte piÃ¹ veloce di un modem tradizionale', 'sin_top' => 4, 'link' => 'http://ad.zanox.com/ppc/?31390311C2144921663T', 'is_active' => 1],
            ['id' => 15, 'id_provider' => 2, 'customer' => 'RES', 'name' => 'TIM Sky TIM SMART', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 39, 'activation_price' => 0, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '1899-12-30', 'default_price' => 58.9, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 20, 'speed_upload' => 1, 'exp_connection' => 3, 'exp_call_center' => 3, 'exp_chat' => 1, 'exp_personal' => 4, 'exp_act_time' => 3, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', 'extra_bitstream' => '', 'extra_fo_price' => '', 'other_info' => 'Chiamate illimitate verso tutti i numeri fissi e mobili nazionali + Sky TV + CONNESSIONE INTERNET ILLIMITATA + Decoder My Sky HD + Sky On Demand. NON NECESSITA DI PARABOLA (attivabile solo con copertura 20 Mega)', 'sin_top' => 4, 'link' => '', 'is_active' => 0],
            ['id' => 60, 'id_provider' => 2, 'customer' => 'RES', 'name' => 'TIM Sky TUTTO', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 39, 'activation_price' => 68, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '1899-12-30', 'default_price' => 64.8, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 20, 'speed_upload' => 1, 'exp_connection' => 3, 'exp_call_center' => 3, 'exp_chat' => 1, 'exp_personal' => 4, 'exp_act_time' => 3, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', 'extra_bitstream' => '', 'extra_fo_price' => '', 'other_info' => 'Chiamate illimitate verso tutti i numeri fissi e mobili nazionali + Sky TV + CONNESSIONE INTERNET ILLIMITATA + Decoder My Sky HD + Sky On Demand. NON NECESSITA DI PARABOLA (attivabile solo con copertura 20 Mega)', 'sin_top' => 4, 'link' => '', 'is_active' => 0],
            ['id' => 43, 'id_provider' => 2, 'customer' => 'RES', 'name' => 'Internet pack casa', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 22.42, 'activation_price' => 0, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '1899-12-30', 'default_price' => 38.21, 'modem' => 'SI', 'modem_type' => '', 'modem_price' => 0, 'phone_start_call_price' => 0.16, 'phone_mobile_price' => 0.19, 'phone_italian_price' => '', 'speed_download' => 7, 'speed_upload' => 0.384, 'exp_connection' => 3, 'exp_call_center' => 3, 'exp_chat' => 1, 'exp_personal' => 3, 'exp_act_time' => 3, 'extra_mail' => 'NO', 'extra_static_ip' => 'NO', 'extra_bitstream' => '', 'extra_fo_price' => '', 'other_info' => 'Internet Senza Limiti per 12 mesi + Memory Key da 8GB, pagamento annuale anticipato con carta di credito', 'sin_top' => 5, 'link' => '', 'is_active' => 0],
            ['id' => 62, 'id_provider' => 2, 'customer' => 'RES', 'name' => 'Tutto', 'sin_label' => '', 'type' => 'ADSL + TEL', 'start_price' => 29, 'activation_price' => 0, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'dopo 12 mesi', 'offer_expire' => '1899-12-30', 'default_price' => 44.9, 'modem' => 'NO', 'modem_type' => '', 'modem_price' => 3.9, 'phone_start_call_price' => 0, 'phone_mobile_price' => 0, 'phone_italian_price' => '', 'speed_download' => 7, 'speed_upload' => 0.384, 'exp_connection' => 3, 'exp_call_center' => 3, 'exp_chat' => 1, 'exp_personal' => 4, 'exp_act_time' => 3, 'extra_mail' => 'NO', 'extra_static_ip' => 'SI', 'extra_bitstream' => '', 'extra_fo_price' => '', 'other_info' => 'Chiamate illimitate verso tutti i numeri fissi e mobili nazionali. Se sei cliente Telecom Italia da almeno 10 anni, TUTTO per te a 29â‚¬/mese per 1 ANNO, poi 39â‚¬/mese anzichÃ© 44,90â‚¬/mese', 'sin_top' => 5, 'link' => '', 'is_active' => 0],
            ['id' => 41, 'id_provider' => 7, 'customer' => 'RES', 'name' => 'EOLO20 Plus', 'sin_label' => '', 'type' => 'WI - FI', 'start_price' => 32.9, 'activation_price' => 24.5, 'min_subscribtion' => '24 mesi', 'promo_price_expire' => 'standard', 'offer_expire' => '1899-12-30', 'default_price' => 32.9, 'modem' => 'NO', 'modem_type' => '','modem_price' => 3 ,'phone_start_call_price' => 0.1 ,'phone_mobile_price' => 0.1788 ,'phone_italian_price' => '','speed_download' => 20 ,'speed_upload' => 2 ,'exp_connection' => 5 ,'exp_call_center' => 3 ,'exp_chat' => 5 ,'exp_personal' => 5 ,'exp_act_time' => 4 ,'extra_mail' => 'NO','extra_static_ip' => 'NO','extra_bitstream' => '','extra_fo_price' => '','other_info' => 'Traffico dati 40 GB/mese (incrementabili) a banda piena, poi illimitato a 4 Mb/s. PossibilitÃ  di selezionare gratuitamente l\' opzione voce per telefonare verso i numeri di rete fissa nazionale al solo costo dello scatto alla risposta di 10 cent di â‚¬.' ,'sin_top' => 5 ,'link' => '','is_active' => 1]
        ];
        return $this->formatOffersResults();
    }

    /**
     * Return the result property
     * @return mixed
     */
    public function getResults(){
        return $this->results;
    }

}