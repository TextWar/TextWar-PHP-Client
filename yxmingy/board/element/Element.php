<?php
namespace yxmingy\board\element;
use yxmingy\board\BaseBoard;
abstract class Element
{
  public $board;
  /* int x,int y */
  public $origin = [];
  public $height;
  public $width;
  public function __construct(BaseBoard $board)
  {
    $this->board = $board;
  }
  
  abstract public function print();
  
  public function getLocate(int $x,int $y)
  {
    $x += $this->origin[0];
    $y += $this->origin[1];
    return [$x,$y];
  }
  public function initBoardData(string $fill = null)
  {
    $fill = $fill ?? $this->board->getBorderChar();
    for($y=0;$y<$this->height;$y++) {
      for($x=0;$x<$this->width;$x++) {
        $loc = $this->getLocate($x,$y);
        $this->board->set($loc[0],$loc[1],$fill);
      }
    }
  }
  public function clear(string $fill = " ")
  {
    for($y=0;$y<$this->height;$y++) {
      for($x=0;$x<$this->width;$x++) {
        $loc = $this->getLocate($x,$y);
        $this->board->put($loc[0],$loc[1],$fill);
      }
    }
  }
}