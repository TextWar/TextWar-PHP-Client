<?php
namespace yxmingy\board\element;
use yxmingy\board\BaseBoard;
class Map extends Element
{
  public function __construct(int $x1,int $y1,int $x2,int $y2,BaseBoard $board)
  {
    parent::__construct($board);
    array_push($this->origin,$x1,$y1);
    $this->height = abs($y1-$y2);
    $this->width = abs($x1-$x2);
    $this->clear();
  }
  public function set(int $x,int $y,string $char)
  {
    $loc = $this->getLocate($x,$y);
    $this->board->put($loc[0],$loc[1],$char);
  }
  public function print()
  {
    for($y=0;$y<$this->height;$y++) {
      for($x=0;$x<$this->width;$x++) {
        $loc = $this->getLocate($x,$y);
        $this->board->isActived()
        ?
        $this->board->put($loc[0],$loc[1],$this->board->getBorderChar())
        :
        $this->board->set($loc[0],$loc[1],$this->board->getBorderChar());
      }
    }
  }
}