<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreatorHub - Le Feed</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <nav class="bg-white border-b border-sky-100 sticky top-0 z-50 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center space-x-2">
            <span class="text-2xl font-bold text-sky-600">Creator<span class="text-slate-800">Hub</span></span>
        </div>
        <div class="flex items-center space-x-4">
            @auth
                <a href="{{ route('portfolios.create') }}" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-full font-medium text-sm transition shadow-md shadow-sky-100 flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    <span>Partager un projet</span>
                </a>
            @else
                <a href="/login" class="text-slate-600 hover:text-sky-500 font-medium text-sm">Se connecter</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <header class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Le Feed des Créateurs</h1>
            <p class="text-slate-500 mt-2">Découvrez les réalisations marquantes de notre communauté de prestataires.</p>
        </header>

        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">
            @forelse($portfolios as $portfolio)
                <div class="break-inside-avoid bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition duration-300 group">

                    <div class="relative overflow-hidden">
                        @if($portfolio->media_type === 'image')
                            <img src="{{ $portfolio->media_url }}" alt="{{ $portfolio->title }}" class="w-full h-auto max-h-96 object-cover transform group-hover:scale-105 transition duration-500">
                        @else
                            <div class="relative bg-slate-900 aspect-video flex items-center justify-center text-white">
                                <a href="{{ $portfolio->media_url }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 hover:bg-opacity-40 transition">
                                    <svg class="w-12 h-12 text-white opacity-85 hover:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                                </a>
                                <span class="text-xs text-slate-400 absolute bottom-2 left-2">Regarder sur Player</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 group-hover:text-sky-500 transition line-clamp-1 mb-1">{{ $portfolio->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-3">{{ $portfolio->description }}</p>

                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach($portfolio->tags as $tag)
                                <span class="bg-sky-50 text-sky-600 text-[10px] font-semibold px-2 py-0.5 rounded-full">#{{ $tag->name }}</span>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between border-t border-slate-50 pt-3">
                            <div class="flex items-center space-x-2">
                                <img src="{{ $portfolio->user->image ?? 'https://ui-avatars.com/api/?name='.urlencode($portfolio->user->name).'&background=e0f2fe&color=0284c7' }}"
                                     alt="{{ $portfolio->user->name }}"
                                     class="w-6 h-6 rounded-full object-cover">
                                <span class="text-xs font-semibold text-slate-700 truncate max-w-[120px]">{{ $portfolio->user->name }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $portfolio->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-2xl border border-dashed">
                    <p class="font-medium">Aucun projet publié pour le moment.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
