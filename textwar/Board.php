<?php
namespace textwar;
class Board
{
  private $height;
  private $width;
  private $data = [];
  private $border = "#";
  public function __construct(int $height = 16,int $width = 20)
  {
    $this->height = $height;
    $this->width = $width;
  }
  public function active()
  {
    ob_implicit_flush();   
    for($row=0;$row<$this->height;$row++) {
      for($col=0;$col<$this->width;$col++) {
        $this->set($col,$row," ",false);
      }
    }
    $this->printAll(true);
  }
  public function set(int $x,int $y,string $char,bool $fresh = true)
  {
    $this->data[$x][$y] = $char;
    $fresh && $this->refresh();
  }
  public function put(int $x,int $y,string $char)
  {
    $this->set($x,$y,$char,false);
    $x = $x*2 + 2;
    $y = $y + 2;
    echo "\033[{$y};{$x}H$char";
    $this->ce();
  }
  public function get(int $x,int $y)
  {
    return $this->data[$x][$y];
  }
  public function ce()
  {
    echo "\033[".($this->height+3).";0H";
  }
  public function refresh()
  {
    echo "\033[0;0H";
    $this->printAll();
  }
  public function clear()
  {
    for($row=0;$row<$this->height;$row++) {
      for($col=0;$col<$this->width;$col++) {
        $this->set($col,$row," ",false);
      }
    }
    $this->printAll();
  }
  public function putBorder()
  {
    echo "\033[0;0H";
    $border_row = [];
    for($i=0;$i<$this->width;$i++) {
      $border_row[] = $this->border;
    }
    echo $this->border;
    echo implode(" ",$border_row);
    echo $this->border;
    
  }
  public function printRow(int $row)
  {
    $rows = [];
    for($i=0;$i<$this->width;$i++) {
      $rows[] = $this->data[$i][$row];
    }
    echo implode(" ",$rows);
  }
  public function setBorder(string $char)
  {
    $this->border = $char;
  }
  public function printAll(bool $sleep = false)
  {
    $border_row = [];
    for($i=0;$i<$this->width;$i++) {
      $border_row[] = $this->border;
    }
    echo $this->border;
    echo implode(" ",$border_row);
    echo $this->border;
    for($i=0;$i<$this->height;$i++) {
      echo PHP_EOL.$this->border;
      $this->printRow($i);
      echo $this->border; 
      $sleep && usleep(5e4);
    }
    echo PHP_EOL.$this->border;
    echo implode(" ",$border_row);
    echo $this->border.PHP_EOL;
  }
}