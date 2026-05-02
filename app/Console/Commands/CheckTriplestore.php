<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckTriplestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-triplestore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek status koneksi dan inisialisasi Triplestore ARC2';

    public function handle(\App\Services\SemanticService $service)
    {
        $this->info('Mengecek status Triplestore...');
        
        try {
            $results = $service->query('SELECT * WHERE { ?s ?p ?o } LIMIT 1');
            $this->info('Koneksi Triplestore Berhasil!');
            $this->line('Hasil query awal: ' . json_encode($results));
        } catch (\Exception $e) {
            $this->error('Gagal terhubung ke Triplestore: ' . $e->getMessage());
        }
    }
}
