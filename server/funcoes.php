<?php
function mensagem_href ($mensagem,$pagina){
  return "<script language='javascript' type='text/javascript'>alert('".$mensagem."');window.location.href='".$pagina."';</script>";
}
function mensagem ($mensagem){
  return "<script language='javascript' type='text/javascript'>alert('".$mensagem."');</script>";
}
function string_upper_to_db($string){
  return utf8_decode(mb_strtoupper($string,'UTF-8'));
}
function string_db_to_upper($string){
  return mb_strtoupper(utf8_encode($string),'UTF-8');
}
function go_to_page($pagina){
  return "<script language='javascript' type='text/javascript'>window.location.href='".$pagina."';</script>";
}

?>