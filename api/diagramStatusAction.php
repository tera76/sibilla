<?php


class diagramStatusAction
{
    public function __construct()
{

}

    function getDiagramStatus($action)
    {
        $diagramName = $action["parameters"]["diagram"];
        $query =  "select state from syb_gojs_diagrams where name = '$diagramName' order by id desc limit 1; ";
        $internalAction['parameters']['query'] = $query;
        return sql($internalAction);
    }

    function saveDiagramStatus($action)
    {
        $diagramName = $action["parameters"]["diagram"];

        $status = $action["parameters"]["status"]  ;
      //  $status = str_replace("\n","<br>",$status);
        $pattern ="/\\n/"  ;
        $status2 = preg_replace($pattern,"\\\\\n",$status);
       // $status = \MongoDB\BSON\fromJSON($status);
          $query = "INSERT INTO syb_gojs_diagrams ( name,state)  VALUES ( '$diagramName' , '"    . $status2 . "');";
        // replace \n with char

    //   var_dump($query);
    //     $query = "INSERT INTO syb_gojs_diagrams ( name,state)  VALUES ( '$diagramName' , REPLACE('$status','↵','\\n'));";
      //  var_dump($status);

      //  $internalAction['parameters']['query']  = $query;
        $internalAction['parameters']['query'] = preg_replace($pattern,"\\\\n",$query);;
        sql($internalAction);
    }

}

