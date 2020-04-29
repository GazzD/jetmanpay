<?php

namespace App\Console\Commands;


use GuzzleHttp\Client;
use App\Dosa;
use Illuminate\Console\Command;

class DosaLoader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:dosas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load dosas from webservice';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $baseUrl = env('DOSA_WEBSERVICE_ENDPOINT');
        
        $client = new Client(['base_uri' => $baseUrl]);
        
        $response = $client->request('GET', 'iaim_w2389009812.php?act=gettransfdosa|1');
        
        $responseObject = json_decode($response->getBody()->getContents());
        
        foreach ($responseObject->transferencia as $dosaJson) {
            $dosa = new Dosa();
            
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
            
            $dosa->client_id = \App\Client::where('code', $dosaJson->cod_cliente)->first()->id;
            
            $dosa->save();
        }
    }
}
