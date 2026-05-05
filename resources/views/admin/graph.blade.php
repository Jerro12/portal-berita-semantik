<x-admin-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-serif font-bold text-foreground mb-2">Graf Pengetahuan Semantik</h1>
                <p class="text-muted-foreground font-medium">Jelajahi triple RDF yang mendasari dan hubungan basis pengetahuan.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-secondary rounded-xl border border-border">
                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest block">Mesin Penyimpanan</span>
                    <span class="text-xs font-bold text-primary">ARC2 Triplestore (MySQL)</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- SPARQL Query Editor -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-background border border-border rounded-[2rem] p-6 shadow-sm">
                    <h3 class="font-serif font-bold text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        SPARQL Editor
                    </h3>
                    <form action="{{ route('news.sparql') }}" method="GET" class="space-y-4">
                        <textarea name="query" rows="8" 
                            class="block w-full border-border bg-secondary/30 rounded-2xl focus:ring-primary focus:border-primary px-4 py-3 font-mono text-xs leading-relaxed">{{ $query }}</textarea>
                        <button type="submit" class="w-full bg-primary text-primary-foreground py-3 rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            JALANKAN QUERY
                        </button>
                    </form>
                </div>

                <div class="p-6 bg-primary/5 border border-primary/10 rounded-[2rem]">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest mb-3">Templat Cepat</h4>
                    <div class="space-y-2">
                        <button type="button" onclick="setQuery('SELECT ?s ?p ?o WHERE { ?s ?p ?o } LIMIT 50')" class="w-full text-left p-3 bg-background rounded-xl border border-border text-[10px] font-mono hover:border-primary transition-colors">
                            Sampel Graf Visual (50)
                        </button>
                        <button type="button" onclick="setQuery('PREFIX schema: <https://schema.org/>\nSELECT ?judul WHERE {\n  ?s schema:headline ?judul .\n}')" class="w-full text-left p-3 bg-background rounded-xl border border-border text-[10px] font-mono hover:border-primary transition-colors">
                            Tampilkan Semua Judul
                        </button>
                        <button type="button" onclick="setQuery('PREFIX schema: <https://schema.org/>\nSELECT (COUNT(?s) AS ?total) WHERE {\n  ?s rdf:type schema:NewsArticle .\n}')" class="w-full text-left p-3 bg-background rounded-xl border border-border text-[10px] font-mono hover:border-primary transition-colors">
                            Hitung Total Berita
                        </button>
                        <button type="button" onclick="setQuery('PREFIX schema: <https://schema.org/>\nSELECT ?judul ?kategori WHERE {\n  ?s schema:headline ?judul ;\n     schema:articleSection ?kategori .\n}')" class="w-full text-left p-3 bg-background rounded-xl border border-border text-[10px] font-mono hover:border-primary transition-colors">
                            Judul & Kategori
                        </button>
                        <button type="button" onclick="setQuery('SELECT ?p (COUNT(?s) as ?count) WHERE { ?s ?p ?o } GROUP BY ?p')" class="w-full text-left p-3 bg-background rounded-xl border border-border text-[10px] font-mono hover:border-primary transition-colors">
                            Statistik Predikat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Results Visualization -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tab Navigation -->
                <div class="flex p-1 bg-secondary/50 rounded-2xl w-fit">
                    <button onclick="switchTab('table')" id="btn-table" class="px-6 py-2 rounded-xl text-xs font-bold transition-all bg-white text-primary shadow-sm">Tampilan Tabel</button>
                    <button onclick="switchTab('visual')" id="btn-visual" class="px-6 py-2 rounded-xl text-xs font-bold transition-all text-muted-foreground hover:text-foreground">Graf Visual</button>
                </div>

                <!-- Table Content -->
                <div id="content-table" class="bg-background border border-border rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-border flex justify-between items-center bg-secondary/10">
                        <h3 class="font-serif font-bold text-lg">Hasil Query</h3>
                        <span class="px-3 py-1 bg-primary text-primary-foreground rounded-full text-[10px] font-bold">
                            {{ count($triples) }} triple ditemukan
                        </span>
                    </div>
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 z-10 bg-white">
                                <tr class="bg-secondary/30">
                                    @if(count($triples) > 0)
                                        @foreach(array_keys($triples[0]) as $header)
                                            <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">
                                                ?{{ $header }}
                                            </th>
                                        @endforeach
                                    @else
                                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Subjek</th>
                                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Predikat</th>
                                        <th class="px-6 py-4 text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Objek</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @forelse($triples as $triple)
                                    <tr class="hover:bg-secondary/5 transition-colors">
                                        @foreach($triple as $key => $value)
                                            <td class="px-6 py-4">
                                                <div class="text-[11px] font-mono {{ $key == 's' ? 'text-primary' : 'text-foreground' }}">
                                                    {{ is_string($value) ? str_replace(['https://schema.org/', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'], ['schema:', 'rdf:'], $value) : $value }}
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-20 text-center text-muted-foreground italic font-serif">
                                            Tidak ada data yang dikembalikan untuk query ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Visual Content -->
                <div id="content-visual" class="hidden bg-background border border-border rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-border bg-secondary/10">
                        <h3 class="font-serif font-bold text-lg">Visualisasi Graf Pengetahuan</h3>
                    </div>
                    <div id="cy" class="w-full h-[600px] bg-white"></div>
                    <div class="p-4 bg-secondary/10 border-t border-border flex gap-4 overflow-x-auto text-[10px] font-bold">
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-primary"></span> Node Subjek</div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-accent"></span> Node Objek</div>
                        <div class="flex items-center gap-2"><span class="w-3 h-1 bg-secondary/30"></span> Relasi Predikat</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cytoscape JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.23.0/cytoscape.min.js"></script>
    <script>
        function switchTab(tab) {
            const table = document.getElementById('content-table');
            const visual = document.getElementById('content-visual');
            const btnTable = document.getElementById('btn-table');
            const btnVisual = document.getElementById('btn-visual');

            if (tab === 'table') {
                table.classList.remove('hidden');
                visual.classList.add('hidden');
                btnTable.classList.add('bg-white', 'text-primary', 'shadow-sm');
                btnTable.classList.remove('text-muted-foreground');
                btnVisual.classList.add('text-muted-foreground');
                btnVisual.classList.remove('bg-white', 'text-primary', 'shadow-sm');
            } else {
                table.classList.add('hidden');
                visual.classList.remove('hidden');
                btnVisual.classList.add('bg-white', 'text-primary', 'shadow-sm');
                btnVisual.classList.remove('text-muted-foreground');
                btnTable.classList.add('text-muted-foreground');
                btnTable.classList.remove('bg-white', 'text-primary', 'shadow-sm');
                
                // Initialize Cytoscape when tab is opened
                setTimeout(initGraph, 100);
            }
        }

        let cyInitialized = false;
        function initGraph() {
            if (cyInitialized) return;
            
            const triples = @json($triples);
            const elements = [];
            const nodes = new Set();

            triples.forEach(t => {
                const s = t.s;
                const p = t.p.replace('https://schema.org/', 'schema:').replace('http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'rdf:');
                const o = t.o;

                if (!nodes.has(s)) {
                    elements.push({ data: { id: s, label: s.split('/').pop(), type: 'subject' } });
                    nodes.add(s);
                }

                // If object is a URI (starts with http)
                if (o.toString().startsWith('http')) {
                    if (!nodes.has(o)) {
                        elements.push({ data: { id: o, label: o.split('/').pop(), type: 'object' } });
                        nodes.add(o);
                    }
                    elements.push({ data: { source: s, target: o, label: p } });
                } else {
                    // Object is a literal
                    const literalId = 'lit_' + Math.random().toString(36).substr(2, 9);
                    elements.push({ data: { id: literalId, label: o.length > 20 ? o.substr(0, 20) + '...' : o, type: 'literal' } });
                    elements.push({ data: { source: s, target: literalId, label: p } });
                }
            });

            const cy = cytoscape({
                container: document.getElementById('cy'),
                elements: elements,
                style: [
                    {
                        selector: 'node',
                        style: {
                            'label': 'data(label)',
                            'background-color': '#172A39',
                            'color': '#172A39',
                            'font-size': '10px',
                            'text-margin-y': '5px',
                            'width': '30px',
                            'height': '30px'
                        }
                    },
                    {
                        selector: 'node[type="object"]',
                        style: {
                            'background-color': '#FC563C'
                        }
                    },
                    {
                        selector: 'node[type="literal"]',
                        style: {
                            'background-color': '#6E7575',
                            'shape': 'rectangle',
                            'width': 'auto',
                            'height': '20px',
                            'padding': '5px'
                        }
                    },
                    {
                        selector: 'edge',
                        style: {
                            'width': 2,
                            'line-color': '#6E7575',
                            'target-arrow-color': '#6E7575',
                            'target-arrow-shape': 'triangle',
                            'curve-style': 'bezier',
                            'label': 'data(label)',
                            'font-size': '8px',
                            'color': '#64748b',
                            'text-rotation': 'autorotate',
                            'text-background-opacity': 1,
                            'text-background-color': '#E9E4E0',
                            'text-background-padding': '2px'
                        }
                    }
                ],
                layout: {
                    name: 'cose',
                    animate: true,
                    nodeOverlap: 20,
                    refresh: 20,
                    fit: true,
                    padding: 30,
                    randomize: false,
                    componentSpacing: 100,
                    nodeRepulsion: 400000,
                    edgeElasticity: 100,
                    nestingFactor: 5,
                    gravity: 80,
                    numIter: 1000,
                    initialTemp: 200,
                    coolingFactor: 0.95,
                    minTemp: 1.0
                }
            });

            cyInitialized = true;
        }

        function setQuery(q) {
            const textarea = document.querySelector('textarea[name="query"]');
            textarea.value = q;
            textarea.focus();
        }
    </script>
</x-admin-layout>
