<!-- bulletins  -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- criar um componente - COLEÇÃO DE BOLETINS COM UM FOREACH-->
            <ul class="row row-cols-3 row-cols-sm-4 row-cols-lg-6 row-cols-xl-8 list-unstyled list">   
                <!-- linhas -->
                @isset($bulletins)                 
                    @foreach ($bulletins as $bulletin)
                        <li class="col mb-4">
                            <div class="card px-3 py-4 text-center bg-white border border-gray-300 shadow rounded">
                                <i class="" style="font-size:60px;"></i>
                                <div class="card-body">
                                    <!--<h5 class="card-title">{{ \Carbon\Carbon::parse($bulletin->date_of_publish)->format('Y')}}</h5>-->
                                    <h5 class="card-title">{{ app(App\Http\Controllers\BulletinsController::class)->month_number_to_string(strval($bulletin->bulletin_month)) . ' ' . $bulletin->bulletin_year }}</h5>
                                    <p class="card-text"></p>
                                    <a href="{{ route('bulletins.show_files_month', [$bulletin->bulletin_year, $bulletin->bulletin_month]) }}" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endisset
                <!-- linhas -->
            </ul>
        </div>
    </div>    
</div>

