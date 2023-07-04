<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Repositories\BulletinRepository;
use App\Http\Requests\BulletinFormRequest;
use App\Http\Requests\StoreBulletinFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\General\CollectionHelper;

class BulletinsController extends Controller
{
    /**
     * Construtor Padrão
     */
    public function __construct(private BulletinRepository $_repository){
        //Request $request, Upload $_upload
        //$this->middleware('auth')->except('index_public')->except('store_public');
    }


    /**
     * Mostra um index publico com todos os boletins
     *
     * @return \Illuminate\Http\Response
     */
    public function show_years(Request $request = null){
        
        //dd($request);

        $bulletins = $this->_repository->search_years();
        
        $mensagemSucesso = session('mensagem.sucesso');
        
        return view('bulletins.public')
        ->with('bulletins', CollectionHelper::paginate($bulletins, 12)) // O laravel não pagina collection, tive que adaptar
        ->with('request', $request)
        ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function show_months_year(Request $request){

        $bulletins = $this->_repository->search_months($request);
        
        $mensagemSucesso = session('mensagem.sucesso');
        
        return view('bulletins.public')
        ->with('bulletins', CollectionHelper::paginate($bulletins, 12)) // O laravel não pagina collection, tive que adaptar
        ->with('request', $request)
        ->with('yearRequest', $request->selected_year)
        ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function show_files_month(Request $request){

        $bulletins = $this->_repository->search_files_year_month($request);
        
        $mensagemSucesso = session('mensagem.sucesso');
        
        return view('bulletins.public')
        ->with('bulletins', CollectionHelper::paginate($bulletins, 12)) // O laravel não pagina collection, tive que adaptar
        ->with('request', $request)
        ->with('mensagemSucesso', $mensagemSucesso);
    }

    /**
     * Processa a requisição do index_public e devolve para o index publico
     *
     * @param  \App\Http\Requests\BulletinFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function results_of_search(BulletinFormRequest $request){

        $bulletins = null;
        $bulletins = $this->_repository->search($request);        

        //o erro, ao invés de mandar pra view direto, mandei pra rota, onde sobrescrevia a variável sempre
        //apresentando o erro de buscar sempre todos os boletins
        return view('bulletins.public')
            ->with('bulletins', $bulletins)
            ->with('request', $request)
            ->with('mensagemSucesso', "Pesquisa de boletins com o(s) termo(s) '{$request->words_to_filter}' foi executada com sucesso para o período informado.");
    }

    /**
     * Processa a requisição do index_public e devolve para o index publico
     *
     * @param  \App\Http\Requests\BulletinFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function private_results_of_search(Request $request){

        $bulletins = null;
        $bulletins = $this->_repository->simple_search($request);        

        //o erro, ao invés de mandar pra view direto, mandei pra rota, onde sobrescrevia a variável sempre
        //apresentando o erro de buscar sempre todos os boletins
        return view('bulletins.index')
            ->with('bulletins', $bulletins)
            ->with('request', $request)
            ->with('mensagemSucesso', "Pesquisa de boletins com os seguintes termos '{$request->words_to_filter}' executada com sucesso");
    }


    /**
     * Mostra o index com os boletins autênticado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
        $bulletins = null;
        $bulletins = $this->_repository->search();
        $mensagemSucesso = session('mensagem.sucesso');
        //
        return view('bulletins.index')
            ->with('bulletins', \App\Helpers\General\CollectionHelper::paginate($bulletins, 12))
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    /**
     * Mostra o index com os boletins autênticado.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(){
        return view('bulletins.dashboard');
    }

    /**
     * Mostra um formulário vázio para fazer upload de um nobo boletim
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $mensagemSucesso = session('mensagem.sucesso');        //
        return view('bulletins.create')
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    /**
     * Processa a requisição da função 'create' e devolve para o index do boletins
     *
     * @param  \App\Http\Requests\StoreBulletinFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBulletinFormRequest $request){
        $_request = $this->store_file($request);
        $_bulletin = $this->_repository->add($_request);
        return to_route('bulletins.index')->with('mensagem.sucesso', " Boletim '{$_bulletin->name_of_file}' adicionada com sucesso");
    }

    /**
     * Converte um texto com numeri em sigla
     *
     * @return String
     */
    public function month_number_to_string(String $_parametro){

        $_acronym = "";

        switch ($_parametro) {
            case 1:
                $_acronym = "JAN";
                break;
            case 2:
                $_acronym = "FEV";
                break;
            case 3:
                $_acronym = "MAR";
                break;
            case 4:
                $_acronym = "ABR";
                break;
            case 5:
                $_acronym = "MAIO";
                break;
            case 6:
                $_acronym = "JUN";
                break;
            case 7:
                $_acronym = "JUL";
                break;
            case 8:
                $_acronym = "AGO";
                break;
            case 9:
                $_acronym = "SET";
                break;
            case 10:
                $_acronym = "OUT";
                break;
            case 11:
                $_acronym = "NOV";
                break;
            case 12:
                $_acronym = "DEZ";
                break;
        }
        return $_acronym;
    }

    /**
     * Remove formatações em textos.
     *
     * @param  String $_texto
     * @return \Illuminate\Http\Response
     */
    public function remove_accent(String $_original_text){
        $_text = "";
        $_text = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", '/\s\s+/'), explode(" ", "a A e E i I o O u U n N"), $_original_text);
        return $_text;
    }

    /**
     * Remove ponto,traço, e etc. em textos.
     *
     * @param  String  $_texto
     * @return $_string  $_texto sem formatação
     */

    public function remove_enter(String $_original_text){
        $_special = "";
        $_text = "";
        $_special = array("\n");
        $_text = str_replace($_special, " ", $_original_text);
        return $_text;
    }

    public function remove_punctuation(String $_original_text){
        $_special = "";
        $_text = "";
        $_text_without_enter = "";

        $_text_without_enter = $this->remove_enter($_original_text);
        $_special = array(".", ",", ";", "!", "@", "#", "%", "¨", "*", "(", ")", "+", "-", "=", "§", "$", "|", "\\", ":", "/", "<", ">", "?", "{", "}", "[", "]", "&", "'", '"', "´", "`", "?", '“', '”', '$', "'", "'","\n");
        $_text = str_replace($_special, "", trim($_text_without_enter));
        return $_text;
    }    
    
    /**
     * Armazena o upload enviado por request
     *
     * @param  \App\Http\Requests\StoreBulletinFormRequest  $request
     * @return \App\Http\Requests\StoreBulletinFormRequest  $request
     */
    public function store_file(StoreBulletinFormRequest $request){
        //limpando as variaveis
        $_year_of_file = "";
        $_month_of_file = "";
        $_file_to_upload = "";
        $_path_local_file = "";
        $_original_text = "";
        $_text_without_accent = "";
        $_text_without_formatation = "";

        //filtro ano e mes para salvar no banco
        $_year_of_file = explode("-", $request->date_of_publish)[0];        
        $_month_of_file = explode("-", $request->date_of_publish)[1];
        $_month_of_file = $this->month_number_to_string($_month_of_file);
        //salvo o arquivo local
        $_file_to_upload = $request->file('file_to_upload')->store($_year_of_file . "/" . $_month_of_file, 'public');
        $_path_local_file = Storage::disk('local')->path("//public/" . $_file_to_upload);
        //converto o texto
        $_original_text = $this->pdf_to_text($_path_local_file);
        //removo acentuação
        $_text_without_accent = $this->remove_accent($_original_text);
        //removo a pontuação
        $_text_without_formatation = $this->remove_punctuation($_text_without_accent);

        //adiciono os valores na requisição
        $request->file_to_upload = $_file_to_upload;
        $request->original_text = $_original_text;
        $request->text_without_formatation = Str::upper($_text_without_formatation);

        return $request;
    }


    /**
     * Armazena o upload enviado por request
     *
     * @param  String $_file_adress
     * @return String
     */
    public function pdf_to_text(String $_file_adress){
        $_text_of_file = "";
        $_text_of_file =  (new Pdf())->setPdf($_file_adress)->text();
        return $_text_of_file;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function show(Bulletin $bulletin){
        //
    }

    /**
     * Mostra um formulário para editar os dados do boletim especifico
     *
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function edit(Bulletin $bulletin){
        //
        $mensagemSucesso = session('mensagem.sucesso');
        return view('bulletins.edit')->with('bulletin', $bulletin)->with('mensagemSucesso', $mensagemSucesso);
    }

    /**
     * Processa a requisição vinda da função edit e devolve para o index do boletins
     *
     * @param  \App\Http\Requests\UpdateBulletinRequest  $request
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function update(BulletinFormRequest $request, Bulletin $bulletin){
        //
    }

    /**
     * Remove um boletim especifico
     *
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function destroy_all(Request $request){
        if (isset($request->bulletins_selecteds)){
            foreach ($request->bulletins_selecteds as $key => $bulletin_selected) {
                Bulletin::find($bulletin_selected)->delete();
            }
            return to_route('bulletins.index')->with('mensagem.sucesso',"Boletins removidos com sucesso!");        
        }
        else{
            return to_route('bulletins.index')->withErrors("Marque uma caixa de seleção, por favor!");
        }
    }    
}
