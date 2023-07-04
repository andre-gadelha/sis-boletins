<!-- bulletins  -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- criar um componente para essaporra - COLEÇÃO DE BOLETINS COM UM FOREACH-->
            <ul class="row list-unstyled list">
                @isset($bulletins)                    
                    <!-- linhas -->
                    @foreach ($bulletins as $bulletin)
                        <li class="col mb-4">
                            <blockquote class="blockquote border-gray-300 shadow rounded">
                                
                                <header class="blockquote-header ml-2 mt-0">
                                    <a href="{{asset('storage/'.$bulletin->path_of_file)}}" class="ml-2 mr-3 mb-0">
                                        <h6>
                                            {{ \Carbon\Carbon::parse($bulletin->date_of_publish)->format('d/m/Y')}} {{ $bulletin->name_of_file }}
                                        </h6>
                                    </a>  
                                </header>                                
                                <footer class="blockquote-footer p-2">{!! CollectionHelper::search_terms($request->words_to_filter,$bulletin->text_without_formatation) !!}</footer>
                            </blockquote>
                        </li>
                    @endforeach
                @endisset
                <!-- linhas -->
            </ul>
        </div>
    </div>    
</div>

