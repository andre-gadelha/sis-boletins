<?php

namespace App\Helpers\General;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CollectionHelper
{
    public static function paginate(Collection $results, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('page');
        
        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

    /**
     * Remove um boletim especifico
     *
     * @param  String $_search_words     
     * @return String $_text
     * @param  int $_search_words
     */
    public static function search_terms(String $_search_words, String $_text, int $_qtd_words = 3){
        //array para armazenar as posições das palavras
        $_text_worked = "";
        $_words_and_your_positions = [];
        $_found_mentions = [];
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
        //PASSO POR TODAS PALAVRAS LOCALIZADAS NO TEXTO E VERIFICO SE SÃO SEQUENCIAS
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
        //AGRUPAR TODAS AS SEQUENCIAS
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
                            array_push($_found_mentions,$_setence);                
                            //limpo as auxs
                            $_indices_begin = 0;
                            $_setence = null;
                        }
                    break;
                //para palavras que findam uma sequência
                case (($_item_words_with_sequentials['SFPP'] == true) && ($_item_words_with_sequentials['SNP'] == false)):
                        $_qtd_of_words+=1;
                        if ($_setence = array_slice($_words_and_your_positions,$_indices_begin,$_qtd_of_words)){                
                            array_push($_found_mentions,$_setence);                
                            //limpo as auxs
                            $_indices_begin = 0;
                            $_setence = null;
                        }
                    break;
            }
        }
        //TRABALHO O TEXTO A SER RETORNADO
        foreach ($_found_mentions as $key_fm => $_item_found_mentions) {
            
            //posição do primeiro item
            $_pofi = 0;
            //posição do último item
            $_poli = 0;
            //PEGO A POSIÇÃO DO PRIMEIRO ITEM
            $_pofi = $_item_found_mentions[0]["position"];
            //PEGO A POSIÇÃO DO ÚLTIMO ITEM
            //$_poli = $_item_found_mentions[(count($_item_found_mentions[$key_fm]) - 1)]["position"];
            $_poli = end($_item_found_mentions)["position"];;

            //PASSO PELAS 3 PALAVRAS ANTERIORES E CONCATENO
            // DA (POSIÇÃO ATUAL DO PRIMEIRO ITEM MENOS A QUANTIDADE DE PALAVRAS) ATÉ A POSIÇÃO ATUAL
            $_text_worked.="<span class='ml-2'>...";
            for ($i = ($_pofi - $_qtd_words); $i < $_pofi; $i++){
                if(array_key_exists($i,$_array_words_of_text)) {
                    $_text_worked.=strtolower($_array_words_of_text[$i])." ";
                }
            }
            $_text_worked.="<strong>";
            foreach ($_item_found_mentions as $key_ifm => $_item_ifm) {
                $_text_worked.=$_item_ifm["word"]." ";
            }            
            $_text_worked.="</strong>";            
            // DA (POSIÇÃO ATUAL DO ULTIMO ITEM MENOS A QUANTIDADE DE PALAVRAS) ATÉ A POSIÇÃO ATUAL
            for ($j = ($_poli +1); $j <= ($_poli + $_qtd_words); $j++) { 
                if(array_key_exists($j,$_array_words_of_text)) {
                    $_text_worked.=strtolower($_array_words_of_text[$j])." ";
                }
            }
            $_text_worked.="...</span>";
        }

        //return $_words_and_your_positions;
        return $_text_worked;
    }
}