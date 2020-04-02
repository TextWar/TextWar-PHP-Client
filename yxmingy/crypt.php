<?php
function rand_str(int $length)
{
  $chars = str_split(md5(microtime(true)));
  $str = "";
  $ii = 0;
  for($i=0;$i<$length;$i++) {
    $str .= $chars[$ii];
    if($ii++ == count($chars))
      $ii = 0;
  }
  return str_shuffle($str);
}
/**
 * 原理: 
 *   1. 将data base64
 *   2. 将data里的每一个byte的ascii码减一
 *   3. 生成比data长度多一的随机串rand
 *   4. 将data的每个byte插入rand的每个byte的间隙中，得到新串new
 *   (r[0]d[0]r[1]d[1]...r[n]d[n]r[n+1])
 *   5. 将new反转
 *   6. 将new base64 得到最终结果
 */
function yao_encode(string $data)
{
  $data = base64_encode($data);
  $rand = rand_str(strlen($data)+1);
  $rand = str_split($rand);
  $data = str_split($data);
  $new = [];
  $length = count($data);
  for($i=0;$i<$length;$i++) {
    array_push($new,$rand[$i],chr(ord($data[$i])-1));
  }
  $new[] = $rand[$i];
  return base64_encode(strrev(implode("",$new)));
}
function yao_decode(string $code)
{
  $code = str_split(strrev(base64_decode($code)));
  $length = count($code);
  for($i=0;$i<$length;$i++) {
    if($i%2 == 0) {
      unset($code[$i]);
    }else{
      $code[$i] = chr(ord($code[$i])+1);
    }
  }
  return base64_decode(implode("",$code));
}
/**
 * note: 以下函数生成的密文均被base64加密
 */
function aes256_encode(string $data,string $key):string
{
  $iv = openssl_random_pseudo_bytes(16, $isStrong);
  if (false === $iv && false === $isStrong) {
    die('IV generate failed');
  }
  return base64_encode(openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv).$iv);
}
function aes256_decode(string $data,string $key):string
{
  $data = base64_decode($data);
  $l = strlen($data);
  $iv = substr($data,$l-16);
  $crypted = substr($data,0,$l-16);
  return openssl_decrypt($crypted, 'aes-256-cbc', $key, 0, $iv);
}
/**
 * @param &$private_key
 * @param &$public_key
 * @param int $key_length -- 密钥长度
 * note: 待加密数据长度最大值为key_length-11
 * note: 所有key都被base64加密
 * @return bool -- 生成成功返回true
 */
function rsa_create_keys(&$private_key,&$public_key,int $key_length = 64):bool
{
  $config = array(
    "private_key_bits" => $key_length*8,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
    "config" => dirname(__FILE__).'/openssl.cnf'
  );
  if($res === false)
    return false;
  $res = openssl_pkey_new($config);
  openssl_pkey_export($res,$private_key,null,$config);
  $private_key = base64_encode($private_key);
  $public_key = openssl_pkey_get_details($res);
  $public_key = base64_encode($public_key["key"]);
  return true;
}
function rsa_private_encode(string $data,string $private_key):?string
{
  openssl_private_encrypt($data,$code,base64_decode($private_key));
  return base64_encode($code);
}
function rsa_public_encode(string $data,string $public_key):?string
{
  openssl_public_encrypt($data,$code,base64_decode($public_key));
  return base64_encode($code);
}
function rsa_private_decode(string $code,string $private_key):?string
{
  openssl_private_decrypt(base64_decode($code), $data, base64_decode($private_key));
  return $data;
}
function rsa_public_decode(string $code,string $public_key):?string
{
  openssl_public_decrypt(base64_decode($code), $data, base64_decode($public_key));
  return $data;
}
 function trans($content) {
        if ($content) {
            return trim(chunk_split($content, 64, "\n"));
        } 
        return false;
    }

    /**
     * append Falgs to content
     * @param $content
     * @param $isPublic
     * @return string
     */
     function append_flags($content, $isPublic = true) {
        if ($isPublic) {
            return "-----BEGIN PUBLIC KEY-----\n" . $content . "\n-----END PUBLIC KEY-----\n";
        }
        else {
            return "-----BEGIN PRIVATE KEY-----\n" . $content . "\n-----END PRIVATE KEY-----\n";
        }
    }