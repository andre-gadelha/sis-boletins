<?php

namespace App\Repositories;

use App\Http\Requests\BulletinFormRequest;
use App\Http\Requests\StoreBulletinFormRequest;
use Illuminate\Http\Request;
use App\Models\Bulletin;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class EloquentBulletinRepository implements BulletinRepository
{
    
    public function add(StoreBulletinFormRequest $request): Bulletin
    {
        //dd($request);
        return DB::transaction(function () use ($request) {
            //dd($request->date_of_publish);
            $_bulletin = Bulletin::create([
                'name_of_file' => $request->file('file_to_upload')->getClientOriginalName(),
                'original_text' => $request->original_text,
                'text_without_formatation' => $request->text_without_formatation,
                'path_of_file' => $request->file_to_upload,
                'date_of_publish' => $request->date_of_publish,
            ]);

            return $_bulletin;
        });
    }

    public function search(BulletinFormRequest $request = null): Collection
    {
        if($request != null)
        {
            return Bulletin::query()->where('text_without_formatation', 'LIKE' , '%' .$request->words_to_filter. '%')->whereBetween('date_of_publish', [$request->filter_date_start,$request->filter_date_end])->orderByRaw('date_of_publish DESC')->get();
        }
        else{
            //$bos = "teste";
            //dd($bos);
            return Bulletin::query()
            //->whereYear('date_of_publish','=', date('Y'))
            //->groupByRaw(year('date_of_publish'))
            ->orderByRaw('id DESC')
            ->get();
            //dd($bos);
        }    
    }
    
    public function simple_search(Request $request): Collection
    {
        return Bulletin::query()->whereFullText('text_without_formatation', $request->words_to_filter)->get();
    }

    //public function search_years(BulletinFormRequest $request = null): Collection
    public function search_years(Request $request = null): Collection
    {
        if($request == null)
        {        
            return Bulletin::selectraw('DISTINCT(DATE_FORMAT(date_of_publish, "%Y")) as bulletin_year')
            ->orderByRaw('date_of_publish DESC')
            ->get();
        }    
    }

    public function search_months(Request $request): Collection
    {
        if($request != null)
        {        
            return Bulletin::selectraw('DISTINCT(DATE_FORMAT(date_of_publish, "%m")) as bulletin_month, DATE_FORMAT(date_of_publish, "%Y") as bulletin_year')
            ->whereYear('date_of_publish','=', $request->selected_year)
            ->orderByRaw('date_of_publish DESC')
            ->get();
        }    
    }

    //Busca arquivos conforme a ano e o mês selecionado pelo usuário
    public function search_files_year_month(Request $request): Collection
    {
         return Bulletin::query()
         ->whereYear('date_of_publish','=', $request->selected_year)
        ->whereMonth('date_of_publish','=', $request->selected_month)
        ->orderByRaw('date_of_publish DESC')
        ->get();
    }


}
