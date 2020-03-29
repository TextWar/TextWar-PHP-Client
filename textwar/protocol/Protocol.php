<?php
namespace textwar\protocol;
class Protocol
{
  const HEAD = "[TextWar]";
  const CRLF = "\r\n";
  const TIME_STAMP = "Time-Stamp";
  const DATA_LENGTH = "Data-Length";
  const MIDDLE = ": ";
  public static function encode(array $data):string
  {
    $data = base64_encode(json_encode($data));
    $code = self::HEAD.self::CRLF
            .self::TIME_STAMP.self::MIDDLE.((int)(microtime(true)*1e3)).self::CRLF
            .self::DATA_LENGTH.self::MIDDLE.strlen($data).self::CRLF
            .self::CRLF
            .$data.self::CRLF;
    return $code;
  }
}