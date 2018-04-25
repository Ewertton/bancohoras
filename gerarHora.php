<?php
  Class GerarHora{

    static $zona = 'America/Recife';

    function GerarHora (){

    }

    function HoraAtual (){
      date_default_timezone_set(GerarHora::$zona);
      $hora = date('H:i:s');
      return $hora;
    }

    function DataAtual (){
      date_default_timezone_set(GerarHora::$zona);
      $data = date('d-m-Y');
      return $data;
    }

    function MesAtual (){
      date_default_timezone_set(GerarHora::$zona);
      $mes = date('m');
      return $mes;
    }

    function AnoAtual (){
      date_default_timezone_set(GerarHora::$zona);
      $ano = date('Y');
      return $ano;
    }

  }
?>
