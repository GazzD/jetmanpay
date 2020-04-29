<?php

use App\Dosa;
use function GuzzleHttp\json_decode;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client as GuzzleClient;
use App\Plane;
use App\User;
use App\Client;

use Illuminate\Support\Facades\DB;

class DosasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dosa items
        $dosaItems = array();
        
        // Get web service's base url
        $baseUrl = env('DOSA_WEBSERVICE_ENDPOINT');
        $guzzleClient = new GuzzleClient(['base_uri' => $baseUrl]);
        
        // Get all new dosas
        $dosaListResponse = $guzzleClient->request('GET', 'iaim_w2389009812.php?act=gettransfdosa|1');
        $dosaListResponseObject = json_decode($dosaListResponse->getBody()->getContents());
        
        if(!$dosaListResponseObject) dd($dosaListResponseObject);
        
        // Iterate over dosas
        foreach ($dosaListResponseObject->transferencia as $dosaJson) {
            
            $dosa = new Dosa();
            $dosa->id_charge = $dosaJson->id_cobro;
            $dosa->airplane = $dosaJson->matricula;
            $dosa->billing_code = $dosaJson->cod_facturacion;
            $dosa->closure_code = $dosaJson->cod_cierre;
            $dosa->aperture_code = $dosaJson->cod_apertura;
            $dosa->status_code = $dosaJson->cod_status;
            $dosa->aperture_date = $dosaJson->fecha_apertura;
            $dosa->currency = $dosaJson->cod_tipo_moneda;
            $dosa->flight_type_id = $dosaJson->id_tipo_vuelo;
            $dosa->aircraft_movement_id = $dosaJson->id_movimiento_aeronave;
            $dosa->ton_max_weight = $dosaJson->peso_max_tonelada;
            $dosa->flight_type = $dosaJson->tipo_vuelo;
            $dosa->client_code = $dosaJson->cod_cliente;
            $dosa->terminal_code = $dosaJson->cod_terminal;
            $dosa->taxable_base_amount = $dosaJson->monto_base_imponible;
            $dosa->exempt_vat_amount = $dosaJson->monto_iva_exento;
            $dosa->total_dosa_amount = $dosaJson->monto_total_dosa;
            $dosa->client_name = $dosaJson->nombre_cliente;
            $dosa->arrival_flight_number = $dosaJson->numero_vuelo_lleg;
            $dosa->departure_flight_number = $dosaJson->numero_vuelo_sal;
            $dosa->arrival_time = $dosaJson->hora_real_lleg;
            $dosa->departure_time = $dosaJson->hora_real_sal;
            
            // Validate Client
            $client = Client::where('code', $dosaJson->cod_cliente)->first();
            $dosa->client_id = 1;//$client ? $client->id: null;
            
            // Validate plane
            $plane = Plane::where('tail_number', $dosaJson->matricula)->first();
            if (!$plane) {
                // Create not registered planes
                $plane = new Plane();
                $plane->tail_number = $dosaJson->matricula;
                $plane->passengers_number = $dosaJson->cant_pas_resident + $dosaJson->cant_pas_desembar;
                $plane->weight = $dosaJson->peso_max_tonelada;
                $plane->client_id = 1;//$dosa->client_id;
                $plane->save();
            }
            $dosa->plane_id = $plane->id;
            
            // Store dosa
            $dosa->save();
            
            // Find dosa items
            $dosaDetailResponse = $guzzleClient->request('GET', 'iaim_w2389009812.php?act=getdetdosa|'.$dosa->id_charge);
            $dosaDetail = json_decode($dosaDetailResponse->getBody()->getContents());
            
            // Iterate over dosa items
            foreach ($dosaDetail->detalle as $dosaItemJson) {
                $dosaItem = array();
                $dosaItem['step_number'] = $dosaItemJson->nro_paso;
                $dosaItem['concept'] = $dosaItemJson->nombre_cobro;
                $dosaItem['amount'] = $dosaItemJson->monto_cobro;
                $dosaItem['payment_type'] = $dosaItemJson->tipo_cobro;
                $dosaItem['tax_fee'] = $dosaItemJson->iva;
                $dosaItem['arrival_date'] = $dosaItemJson->fecha_hora_llegada;
                $dosaItem['departure_date'] = $dosaItemJson->fecha_hora_salida;
                $dosaItem['calculation_values'] = $dosaItemJson->valores_calculo;
                $dosaItem['dosa_id'] = $dosa->id;
                $dosaItem['created_at'] =  \Carbon\Carbon::now();
                $dosaItem['updated_at'] = \Carbon\Carbon::now(); 
                
                // Add to dosa items array
                $dosaItems[] = $dosaItem;
            }
        }
        
        // Store dosa items
        DB::table('dosa_items')->insert($dosaItems);
    }
}
