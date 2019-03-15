<?php

namespace App\Console\Commands;

use App\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class updateAgendaStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agenda:update_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check agenda status and update if already has happened';

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
     *  Altera agendas para o status de realizada data a condição
     *  de a data da realização seja anterior ao dia de hoje
     *  e que o status da agenda seja 4 (Marcada)
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $log = new Log();

        $lastdata = DB::table('logs')
            ->where('event', '=', 'AGENDA_STATUS_UPDATER')
            ->orderBy('created_at', 'desc')
            ->first();

        // in case any data is found, will assume the yesterday date for updating
        if (!is_object($lastdata)) {
            if (isset($lastdata->created_at))
                $lastdata->created_at = Carbon::yesterday();
        }


        $records = DB::table('agendas')
            ->whereBetween('data', [$lastdata->created_at, Carbon::yesterday()])
            ->where('status_id', '=', 4)
            ->where('realizada', '=', 0)
            ->get();

        // print elements which will be updated
        foreach ($records as $r){
            print_r($r);
        }

        $affected = DB::table('agendas')
            ->whereBetween('data', [$lastdata->created_at, Carbon::yesterday()])
            ->where('status_id', '=', 4)
            ->update(['realizada' => true]);

        $log->event = 'AGENDA_STATUS_UPDATER';
        $log->message = 'Numero de agendas atualizadas: ' . $affected;
        $log->save();
        $this->info($log->message);

    }
}
