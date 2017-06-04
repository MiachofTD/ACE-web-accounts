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
     * 0 - Failed to communicate with server
     * 1 - Successfully communicated with server
     *
     * @return mixed
     */
    public function handle()
    {
        $server = $this->option( 'server' );
        $port = $this->option( 'port' );

        //If no server hostname or port has been found, exit now
        if ( empty( $server ) || empty( $port ) ) {
            return 0;
        }

        $fp = fsockopen( 'udp://' . $server, $port, $errno, $errstr, 10 );
        if ( !$fp ) {
            //Unable to create socket
            info( 'Unable to create socket to udp://ac.aka-steve.com' );
            return 0;
        }

        socket_set_timeout( $fp, 1, 500 );

        //This is a specific packet the server will respond to
        //See the Thwargle launcher for another implementation of this packet https://github.com/Thwargle/ThwargLauncher
        $packet = hex2bin( "00000000000001009300d005000000004000000004003138303200003400000001000000000000003eb8a8581c006163736572766572747261636b65723a6a6a3968323668637367676300000000000000000000" );
        fwrite( $fp, $packet );

        //Because UDP is weird, we won't get a failure until we actually try and read a response from the server
        if ( !( $response = fread( $fp, 9999 ) ) ) {
            info( 'Unable to send/receive data from udp://ac.aka-steve.com' );
            return 0;
        }

        //I don't know what to do with the response value right now.
        //echo bin2hex( $response ) . "\n";

        fclose( $fp );

        return 1;
    }
}
