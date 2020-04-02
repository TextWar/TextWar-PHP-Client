<?php
namespace yxmingy\board\element;
use yxmingy\board\BaseBoard;
class Line extends Element
{
  public function __construct(int $y,BaseBoard $board)
  {
    parent::__construct($board);
    array_push($this->origin,0,$y);
    $this->height = 1;
    $this->width = $this->board->getWidth();
    //var_dump($this->width);
    $this->initBoardData();
  }
  public function print()
  {
    for($x=0;$x<$this->width;$x++) {
      $this->board->put($x,$this->origin[1],$this->board->getBorderChar());
    }
  }
}