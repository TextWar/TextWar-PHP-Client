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
    $this->print();
  }
  public function print()
  {
    for($x=0;$x<$this->width;$x++) {
      $this->set($x,0,$this->board->getBorderChar());
    }
  }
}