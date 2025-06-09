<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/debug-tables', function() {
    // Executa SHOW TABLES e retorna apenas o nome das tabelas
    $rows = DB::select('SHOW TABLES');
    // Ajuste a chave abaixo conforme sua database: geralmente é "Tables_in_<nome_do_banco>"
    $key = 'Tables_in_' . env('DB_DATABASE');
    $tables = array_map(fn($row) => $row->$key, $rows);
    return response()->json($tables);
});
