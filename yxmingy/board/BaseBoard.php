<?php
namespace yxmingy\board;
class BaseBoard
{
  protected $actived = false;
  protected $height;
  protected $width;
  protected $data = [];
  protected $border = "#";
  public function __construct(int $height = 16,int $width = 20)
  {
    $this->height = $height;
    $this->width = $width;
  }
  public function active()
  {
    //ob_implicit_flush();   
    for($row=0;$row<$this->height;$row++) {
      for($col=0;$col<$this->width;$col++) {
        $this->set($col,$row,$this->data[$col][$row] ?? " ");
      }
    }
    $this->printAll(true);
    $this->actived = true;
  }
  public function isActived()
  {
    return $this->actived;
  }
  public function set(int $x,int $y,string $char,bool $fresh = false)
  {
    $this->data[$x][$y] = $char;
    $fresh && $this->refreshAll();
  }
  public function getActualPosition($x,$y)
  {
    $x = $x*2 + 2;
    $y = $y + 2;
    return [$x,$y];
  }
  public function put(int $x,int $y,string $char,bool $change_data = true)
  {
    $change_data && $this->set($x,$y,$char);
    $x = $x*2 + 2;
    $y = $y + 2;
    $this->cursorLocate($x,$y);
    echo $char;
    $this->cursorEnd();
  }
  public function get(int $x,int $y)
  {
    return $this->data[$x][$y];
  }
  public function refresh(int $x,int $y)
  {
    $this->put($x,$y,$this->data[$x][$y]);
  }
  public function getHeight()
  {
    return $this->height;
  }
  public function getWidth()
  {
    return $this->width;
  }
  public function getAllData()
  {
    return $this->data;
  }
  public function cursorBegin()
  {
    echo "\033[0;0H";
  }
  public function cursorEnd()
  {
    echo "\033[".($this->height+3).";0H";
  }
  public function cursorLocate(int $x,int $y)
  {
    echo "\033[{$y};{$x}H";
  }
  public function refreshAll()
  {
    $this->cursorBegin();
    $this->clearScreen();
    $this->printAll();
  }
  public function clearScreen()
  {
    echo "\033[2J";
  }
  public function clearAll($change_data = false)
  {
    ob_start();
    for($row=0;$row<$this->height;$row++) {
      for($col=0;$col<$this->width;$col++) {
        $this->put($col,$row," ",$change_data);
      }
    }
    ob_end_flush();
  }
  public function printRow(int $row)
  {
    $rows = [];
    for($i=0;$i<$this->width;$i++) {
      $rows[] = $this->data[$i][$row];
    }
    echo implode(" ",$rows);
  }
  public function setBorderChar(string $char)
  {
    $this->border = $char;
  }
  public function getBorderChar()
  {
    return $this->border;
  }
  public function printAll(bool $sleep = false)
  {
    !$sleep && ob_start();
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
    !$sleep && ob_end_flush();
  }
}