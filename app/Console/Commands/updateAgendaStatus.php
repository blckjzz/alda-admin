<?php

namespace App\Console\Commands;

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
        $affected = DB::table('agendas')
            ->where(
                [
                    ['data', '<=', Carbon::today()],

                    ['status_id', '=', 4]
                ]
            )->update(
                [
                    'status_id' => 5,
                ]);
        $this->info('Numero de agendas atualizadas: ' . $affected);
    }
}
