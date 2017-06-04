<?php

namespace Ace\Console\Commands;

use Illuminate\Console\Command;

class CheckServerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:check-status { --server= } { --port= }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of the ACEmulator server.';

    /**
     * Create a new command instance.
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
        if ( !( $socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP ) ) ) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror( $errorcode );

            echo "Couldn't create socket: [$errorcode] $errormsg \n";

            return;
        }
        if ( !socket_connect( $socket, '73.88.27.215', 9000 ) ) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror( $errorcode );

            echo "Could not connect: [$errorcode] $errormsg \n";

            return;
        }

        echo "Connection established \n";

        $packet = hex2bin("00000000000001009300d005000000004000000004003138303200003400000001000000000000003eb8a8581c006163736572766572747261636b65723a6a6a3968323668637367676300000000000000000000");

        try {
            socket_write( $socket, $packet );
        }
        catch ( \Exception $e ) {
            echo $e->getMessage();
            return;
        }

        socket_close( $socket );

        return;
    }
}
