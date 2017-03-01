<?php
  namespace ksu\domain\PieData;

  use JsonSerializable;

  class PieData implements JsonSerializable{

    public function __construct(array $array){
      $this->array = $array;
    }

    public function jsonSerialize(){
      return $this->array;
    }

    public function object_to_array($data)
    {
        if(is_array($data) || is_object($data))
        {
            $result = array();

            foreach($data as $key => $value) {
                $result[$key] = $this->object_to_array($value);
            }

            return $result;
        }

        return $data;
    }

  }
