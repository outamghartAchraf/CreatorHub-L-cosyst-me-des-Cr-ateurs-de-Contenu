<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreatorHub - Publier une réalisation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen">

    <div class="max-w-2xl mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">

            <header class="mb-8">
                <a href="{{ route('feed') }}" class="text-sky-500 hover:text-sky-600 text-xs font-semibold flex items-center space-x-1 mb-4">
                    <span>← Retour au Feed</span>
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Publier une réalisation</h1>
                <p class="text-slate-500 text-sm mt-1">Alimentez votre portfolio pour vous faire remarquer par l'écosystème.</p>
            </header>

            <form action="{{ route('portfolios.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Titre du Projet <span class="text-rose-500">*</span></label>
                    <input type="text" id="title" name="title" required value="{{ old('title') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition text-sm">
                    @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition text-sm">{{ old('description') }}</textarea>
                    @error('description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="media_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lien du Média (Image HD / Vidéo) <span class="text-rose-500">*</span></label>
                        <input type="url" id="media_url" name="media_url" required value="{{ old('media_url') }}" placeholder="https://example.com/image.jpg"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white transition text-sm">
                        @error('media_url') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="media_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Type de Média <span class="text-rose-500">*</span></label>
                        <select id="media_type" name="media_type" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:border-sky-500 focus:bg-white transition text-sm">
                            <option value="image" {{ old('media_type') == 'image' ? 'selected' : '' }}>Image (HD URL)</option>
                            <option value="video" {{ old('media_type') == 'video' ? 'selected' : '' }}>Vidéo (YouTube/Vimeo)</option>
                        </select>
                        @error('media_type') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sélectionnez des tags de compétences <span class="text-rose-500">*</span></label>
                    <div class="flex flex-wrap gap-2 max-h-36 overflow-y-auto p-3 bg-slate-50 rounded-xl border border-slate-200">
                        @forelse($tags as $tag)
                            <label class="flex items-center space-x-2 bg-white px-3 py-1.5 rounded-full border border-slate-200 cursor-pointer text-xs hover:border-sky-400 transition">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="text-sky-500 rounded focus:ring-sky-400">
                                <span>#{{ $tag->name }}</span>
                            </label>
                        @empty
                            <p class="text-xs text-slate-400">Aucun tag n'est disponible. Veuillez en créer dans la base de données.</p>
                        @endforelse
                    </div>
                    @error('tags') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl shadow-md shadow-sky-100 transition duration-300">
                        Publier sur le Feed
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
