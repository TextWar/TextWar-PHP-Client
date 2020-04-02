<?php
namespace yxmingy\board;
use yxmingy\board\element\
{
  Rectangle,Map,Label,Line,Border
};
class CustomBoard extends BaseBoard
{
  public $labels = [];
  public function addRectangle(int $x1,int $y1,int $x2,int $y2,$char = "*")
  {
    return new Rectangle($x1,$y1,$y2,$x2,$char,$this);
  }
  public function addMap(int $x1,int $y1,int $x2,int $y2)
  {
    return new Map($x1,$y1,$y2,$x2,$this);
  }
  public function addLabel(int $x1,int $y1,int $x2,int $y2)
  {
    $l = new Label($x1,$y1,$x2,$y2,$this);
    $this->labels[] = $l;
    return $l;
  }
  public function addLine(int $y)
  {
    return new Line($y,$this);
  }
  public function addBorder(int $x1,int $y1,int $x2,int $y2)
  {
    return new Border($x1,$y1,$x2,$y2,$this);
  }
  public function printAll(bool $sleep = false)
  {
    parent::printAll($sleep);
    foreach($this->labels as $label) {
      $label->print();
    }
  }
}