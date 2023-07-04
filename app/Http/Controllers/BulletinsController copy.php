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

class BulletinsController extends Controller
{
    /**
     * Construtor Padrão
     */
    public function __construct(private BulletinRepository $_repository)
    {
        //Request $request, Upload $_upload
        //$this->middleware('auth')->except('index_public')->except('store_public');
    }


    /**
     * Mostra um index publico com todos os boletins
     *
     * @return \Illuminate\Http\Response
     */
    public function index_public(Request $request = null){
        $_palavras ="era uma vez dai";
        $_texto ="não te contei que era uma vez dai você pirou mais uma palavra, outras vez dai";
        $_array_aux = $this->search_terms($_palavras,$_texto);

        dd($_array_aux);


        $bulletins = $this->_repository->search();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('bulletins.public')
            ->with('bulletins', \App\Helpers\General\CollectionHelper::paginate($bulletins, 12)) // O laravel não pagina collection, tive que adaptar
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

        //dd($request);

        //o erro, ao invés de mandar pra view direto, mandei pra rota, onde sobrescrevia a variável sempre
        //apresentando o erro de buscar sempre todos os boletins
        return view('bulletins.public')
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
        return to_route('bulletins.index')->with('mensagem.sucesso', "Série '{$_bulletin->name_of_file}' adicionada com sucesso");
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
    public function remove_punctuation(String $_original_text){
        $_special = "";
        $_text = "";

        $_special = array(".", ",", ";", "!", "@", "#", "%", "¨", "*", "(", ")", "+", "-", "=", "§", "$", "|", "\\", ":", "/", "<", ">", "?", "{", "}", "[", "]", "&", "'", '"', "´", "`", "?", '“', '”', '$', "'", "'");
        $_text = str_replace($_special, "", trim($_original_text));
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
        $_year_of_file = Carbon::createFromFormat('Y-m-d', $request->date_of_publish)->year;
        $_month_of_file = Carbon::createFromFormat('Y-m-d', $request->date_of_publish)->month;
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
        //removo as barras invertidas, revisar se for em outro sistema operacional
        $_file_adress = str_replace("/", "\\", $_file_adress);
        $_text_of_file = (new Pdf("h:\laragon\bin\git\mingw64\bin\pdftotext.exe"))->setPdf($_file_adress)->text();
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
    public function destroy(Bulletin $bulletin){
        //
        $bulletin->delete();

        return to_route('bulletins.index')
            ->with('mensagem.sucesso', "Boletim '{$bulletin->nome}' removida com sucesso");
    }

    /**
     * Remove um boletim especifico
     *
     * @param  String $_search_words     
     * @return String $_text
     * @param  int $_search_words
     */
    public function search_terms(String $_search_words, String $_text, int $_qtd_words = 3)
    {
        //array para armazenar as posições das palavras
        $_words_and_your_positions = [];
        $_results = [];
        //array das palavras localizadas
        $_array_search_words = explode(" ",strtoupper($_search_words));
        //array das palavras do texto
        $_array_words_of_text = explode(" ",strtoupper($_text));
        //indice para cortar palavras
        $_indices_begin = 0;
        //quantidade de palavras a serem cortadas
        $_qtd_of_words = 0;
        //frase cortada
        $_setence = [];


        //PASSO POR TODAS AS PALAVRAS PARA PEGAR SUAS POSIÇÕES
        //passo por todas as palavras buscadas
        foreach ($_array_words_of_text as $_key_wot => $_item_words_of_text){
            foreach ($_array_search_words as $_key_sw => $_item_search_word){
                if ($_item_search_word == $_item_words_of_text){
                    $_words_and_your_positions[] = array(
                        'word' => $_array_words_of_text[$_key_wot],
                        'position' => $_key_wot,
                    );
                }
            }
        }
        //PASSO POR TODAS PALAVRAS LOCALIZADAS NO TEXTO E SUAS RESPECTIVAS POSIÇÕES
        //identifico se são sequiencias
        foreach ($_words_and_your_positions as $_key_wayp => $_item_of_words_and_your_positions){
            //limpo as variaveis
            $_aux_actual_position_content=0;
            $_aux_position_content_previus=0;
            $_aux_position_content_next=0;
            $_aux_previus_item=0;
            $_aux_next_item=0;
            $_key_wayp_previus=0;
            $_key_wayp_next=0;
            $_SFPP=false;
            $_SNP=false;

            //posição atual (conteudo)
            $_aux_actual_position_content = $_words_and_your_positions[$_key_wayp]['position'];
            //posição anterior (conteudo)
            $_aux_position_content_previus = $_aux_actual_position_content - 1;
            //proxima posição (conteudo)
            $_aux_position_content_next = $_aux_actual_position_content + 1;
            //contadores
            $_key_wayp_previus = $_key_wayp - 1;
            $_key_wayp_next = $_key_wayp + 1;

            //AQUI SE A POSIÇÃO ATUAL DA PALAVRA FOR DIFERENTE DE ZERO QUE É A PRIMEIRA PALAVRA
            if ($_key_wayp != 0){
                $_aux_previus_item = $_words_and_your_positions[$_key_wayp_previus]['position'];
                $_SFPP = ($_aux_position_content_previus == $_aux_previus_item) ? true : false;
            }
            //AQUI SE A POSIÇÃO ATUAL DA PALAVRA FOR DIFERENTE DA ULTIMA
            if ($_key_wayp != count($_words_and_your_positions)-1) {
                $_aux_next_item = $_words_and_your_positions[$_key_wayp_next]['position'];
                $_SNP = ($_aux_position_content_next == $_aux_next_item) ? true : false;
            }
            //adiciono
            $_words_and_your_positions[$_key_wayp]['SFPP'] = $_SFPP;
            $_words_and_your_positions[$_key_wayp]['SNP'] = $_SNP;

        }
        
        //AGRUPAR TODAS AS SEQUENCIAS COM MAIS DE UMA PALAVRA
        foreach ($_words_and_your_positions as $key_wws => $_item_words_with_sequentials){
            switch ($_item_words_with_sequentials) {
                //para palavras que inciam uma sequência
                case (($_item_words_with_sequentials['SFPP'] == false) && ($_item_words_with_sequentials['SNP'] == true)):
                        $_indices_begin = $key_wws;
                        $_qtd_of_words+=1;
                    break;
                //para palavras que estão dentro de uma sequência                
                case (($_item_words_with_sequentials['SFPP'] == true) && ($_item_words_with_sequentials['SNP'] == true)):
                        $_qtd_of_words+=1;
                    break;
                //para palavras que NÂO estão dentro de uma sequência
                case (($_item_words_with_sequentials['SFPP'] == false) && ($_item_words_with_sequentials['SNP'] == false)):
                        $_indices_begin = $key_wws;
                        $_qtd_of_words=1;
                        if ($_setence = array_slice($_words_and_your_positions,$_indices_begin,$_qtd_of_words)){                
                            array_push($_results,$_setence);                
                            //limpo as auxs
                            $_indices_begin = 0;
                            $_setence = null;
                        }
                    break;
                //para palavras que findam uma sequência
                case (($_item_words_with_sequentials['SFPP'] == true) && ($_item_words_with_sequentials['SNP'] == false)):
                        $_qtd_of_words+=1;
                        if ($_setence = array_slice($_words_and_your_positions,$_indices_begin,$_qtd_of_words)){                
                            array_push($_results,$_setence);                
                            //limpo as auxs
                            $_indices_begin = 0;
                            $_setence = null;
                        }
                    break;
            }
        }

        //return $_words_and_your_positions;
        return $_results;
    }
}
