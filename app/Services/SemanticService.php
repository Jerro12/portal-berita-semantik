<?php

namespace App\Services;

use App\Models\News;
use EasyRdf\Graph;
use EasyRdf\RdfNamespace;
use ARC2;

class SemanticService
{
    protected $config;
    protected $store;

    public function __construct()
    {
        // Konfigurasi ARC2 untuk MySQL
        $this->config = [
            'db_host' => config('database.connections.mysql.host'),
            'db_name' => config('database.connections.mysql.database'),
            'db_user' => config('database.connections.mysql.username'),
            'db_pwd' => config('database.connections.mysql.password'),
            'store_name' => 'arc',
            'endpoint_features' => [
                'select', 'construct', 'ask', 'describe', 
                'load', 'insert', 'delete', 
                'dump'
            ],
            'endpoint_timeout' => 60,
        ];

        $this->store = ARC2::getStore($this->config);
        
        // Setup ARC2 (Akan membuat tabel jika belum ada)
        $this->store->setUp();

        // Setup Namespaces (Ontologi)
        RdfNamespace::set('schema', 'https://schema.org/');
        RdfNamespace::set('dc', 'http://purl.org/dc/elements/1.1/');
        RdfNamespace::set('news-ns', url('/ns/news/'));
    }

    /**
     * Konversi Berita ke RDF dan Simpan ke Triplestore
     */
    public function indexNews(News $news)
    {
        $uri = url('/ns/news/' . $news->id);

        // 1. Hapus data lama terkait URI ini agar tidak terjadi duplikasi (Cloning)
        $this->query("DELETE { <$uri> ?p ?o } WHERE { <$uri> ?p ?o }");

        $graph = new Graph();
        $resource = $graph->resource($uri);

        $resource->add('http://www.w3.org/1999/02/22-rdf-syntax-ns#type', $graph->resource('https://schema.org/NewsArticle'));
        $resource->add('https://schema.org/headline', $news->title);
        $resource->add('https://schema.org/articleBody', $news->content);
        $resource->add('https://schema.org/datePublished', $news->published_at?->toIso8601String());
        $resource->add('https://schema.org/articleSection', $news->category);
        $resource->add('https://schema.org/author', $news->source ?? 'Admin');
        
        if ($news->image) {
            $resource->add('schema:image', url($news->image));
        }

        // Tambahkan metadata tambahan jika ada
        if ($news->metadata) {
            foreach ($news->metadata as $key => $value) {
                $resource->add('news-ns:' . $key, $value);
            }
        }

        // Convert graph to Turtle format for storage
        $turtle = $graph->serialise('turtle');

        // Simpan ke ARC2 Triplestore menggunakan method insert langsung
        return $this->store->insert(
            $graph->serialise('ntriples'), 
            url('/graph/news')
        );
    }

    /**
     * Hapus Berita dari Triplestore berdasarkan News model atau ID
     */
    public function deleteNews($news)
    {
        $id = $news instanceof News ? $news->id : $news;
        $uri = url('/ns/news/' . $id);

        return $this->query("DELETE { <$uri> ?p ?o } WHERE { <$uri> ?p ?o }");
    }

    /**
     * Jalankan Query SPARQL
     */
    public function query($sparql)
    {
        $prefixes = "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX owl: <http://www.w3.org/2002/07/owl#>
        ";
        
        // Gabungkan prefix jika query belum memilikinya (sederhana)
        if (stripos($sparql, 'PREFIX rdf:') === false) {
            $sparql = $prefixes . $sparql;
        }

        return $this->store->query($sparql);
    }

    /**
     * Reset Triplestore (Hapus semua tabel ARC2 dan buat ulang)
     */
    public function resetStore()
    {
        $this->store->drop();
        $this->store->setUp();
    }

    public function getStore()
    {
        return $this->store;
    }
}
