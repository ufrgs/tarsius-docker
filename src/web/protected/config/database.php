<?php
return array(
    'class' => 'CDbConnection',
    'connectionString' => 'mysql:host=mariadb;dbname=tarsius',
    'username' => 'tarsius',
    'password' => 'tarsius',
    'emulatePrepare'=>true,  // necessário em algumas instalações do MySQL
    // 'connectionString'    => "sqlite:".__DIR__.'/../../tarsius.db',
);
