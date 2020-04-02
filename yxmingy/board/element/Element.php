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
  
  public function getLocation(int $x,int $y)
  {
    $x += $this->origin[0];
    $y += $this->origin[1];
    return [$x,$y];
  }
  public function clear(string $fill = " ")
  {
    for($y=0;$y<$this->height;$y++) {
      for($x=0;$x<$this->width;$x++) {
        $loc = $this->getLocation($x,$y);
        $this->board->put($loc[0],$loc[1],$fill);
      }
    }
  }
  public function set(int $x,int $y,string $char)
  {
    $loc = $this->getLocation($x,$y);
    $this->board->isActived()
    ?
    $this->board->put($loc[0],$loc[1],$char)
    :
    $this->board->set($loc[0],$loc[1],$char);
  }
}