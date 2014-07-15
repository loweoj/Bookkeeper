<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Remote Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default connection that will be used for SSH
    | operations. This name should correspond to a connection name below
    | in the server list. Each connection will be manually accessible.
    |
    */

    'default' => 'local',

    'connections' => array(

        'local' => array(
            'host'      => '127.0.0.1:2222',
            'username'  => 'vagrant',
            'password'  => 'secret',
            'key'       => '/Users/oliverlowe/.ssh/id_rsa',
            'keyphrase' => '',
            'root'      => '/home/vagrant/accounts/public/'
        )

    )

);