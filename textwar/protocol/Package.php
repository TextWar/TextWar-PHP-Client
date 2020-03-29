<?php
namespace textwar\protocol;
class Package
{
  const ERR_NO_ERROR = 0;
  const ERR_INVALID_HEAD = 1;
  const ERR_INVALID_CRLF = 2;
  const ERR_INVALID_DATA = 3;
  const ERR_DATA_LENGTH = 4;
  /* string */
  private $prot_data;
  /* array */
  private $data;
  /* array */
  private $hender;
  public function __construct(string $prot_data)
  {
    $this->prot_data = $prot_data;
  }
  public function getData():?array
  {
    return $this->data;
  }
  public function getTimestamp():?string
  {
    return $this->getHandler(Protocol::TIME_STAMP);
  }
  public function getHandler(string $key)
  {
    return $this->handler[$key];
  }
  public function getHandlers()
  {
    return $this->handler;
  }
  public function parse():int
  {
    if(!preg_match_all('/\[TextWar\]\r\n([\s\S]+?)\r\n\r\n([\s\S]+?)\r\n/',$this->prot_data,$matches))
      return self::ERR_INVALID_HEAD;
      
    if(!$this->parseHead(explode(Protocol::CRLF,$matches[1][0])))
      return self::ERR_INVALID_CRLF;
      
    if(strlen($matches[2][0])!=$this->getHandler(Protocol::DATA_LENGTH))
      return self::ERR_DATA_LENGTH;
      
    if(!$this->parseData($matches[2][0]))
      return self::ERR_INVALID_DATA;
      
    return self::ERR_NO_ERROR;
  }
  public function append(string $prot_data):void
  {
    $this->prot_data .= $prot_data;
  }
  protected function parseHead(array $lines):bool
  {
    $handlers = [];
    foreach($lines as $line) {
      if(($p=strpos($line,Protocol::MIDDLE))===false)
        return false;
      $k = substr($line,0,$p);
      $v = substr($line,$p+2);
      $handlers[$k] = $v;
    }
    $this->handler = $handlers;
    return true;
  }
  protected function parseData(string $data):bool
  {
    if(($data=base64_decode($data))===false)
      return false;
    if(($data=json_decode($data,true))===null)
      return false;
    $this->data = $data;
    return true;
  }
}