<?php
namespace yxmingy\board\element;
use yxmingy\board\BaseBoard;
class Label extends Element
{
  private $content;
  public function __construct(int $x1,int $y1,int $x2,int $y2,BaseBoard $board)
  {
    parent::__construct($board);
    $pos1 = $this->board->getActualPosition($x1,$y1);
    $pos2 = $this->board->getActualPosition($x2,$y2);
    array_push($this->origin,$pos1[0],$pos1[1]); 
    //absolute pos
    $this->height = abs($pos1[1]-$pos2[1]);
    $this->width = abs($pos1[0]-$pos2[0]);
    $this->clear();
  }
  public function setContent(string $str)
  {
    $this->content = $str;
    $this->print();
  }
  public function getContent()
  {
    return $this->content;
  }
  public function print()
  {
    if(!$this->board->isActived())
      return;
    $i=0;
    $c = preg_split('/(?<!^)(?!$)/u',$this->content);
    $length = count($c);
    ob_start();
    for($y=0;$y<$this->height;$y++) {
      $loc = $this->getLocation(0,$y);
      $this->board->cursorLocate($loc[0],$loc[1]);
      for($x=0;$x<$this->width;$x++) {    
        //解决中文换行乱码
        if(strlen($c[$i])>1) {
          $d = $this->width-$x;
          if($d<2 && ($x+1)%2==0) {
            $x += $d;
            continue;
          }else{
            $x+=2;
          }
        }
        echo $c[$i];
        if(++$i==$length)
          goto outside;
      }
    }
    outside:
    $this->board->cursorEnd();
    ob_end_flush();
  }
  public function clear(string $fill = " ")
  {
    if(!$this->board->isActived())
      return;
    $i=0;
    ob_start();
    for($y=0;$y<$this->height;$y++) {
      $loc = $this->getLocation(0,$y);
      $this->board->cursorLocate($loc[0],$loc[1]);
      for($x=0;$x<$this->width;$x++) {    
        echo $fill;
      }
    }
    $this->board->cursorEnd();
    ob_end_flush();
  }
}