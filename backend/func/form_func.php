<?php

function make_form($arr)
{
    echo '<div class="panel panel-success">';
    if ($arr['form_title'])
    {
        echo '<div class="panel-heading">
                <h3 class="panel-title">' . $arr['form_title'] . '</h3>
              </div>	';
    }
    echo '<div class="panel-body">';
    if (is_array($arr['elements']))
    {
        echo '<form role="form" name="' . $arr['form_name'] . '" id="' . $arr['form_name'] . '" method="post" enctype="multipart/form-data"><input type="hidden" name="flag" value="true" />';
        foreach ($arr['elements'] as $kk => $vv)
        {

            if (file_exists("func/form_elements/" . $vv['type'] . ".php"))
                require("func/form_elements/" . $vv['type'] . ".php");
            /*
              switch($vv['type']):
              case "text":
              require("func/form_elements/".$vv['type'].".php");
              break;
              case "html":
              require("func/form_elements/".$vv['type'].".php");
              break;
              case "image":
              require("func/form_elements/".$vv['type'].".php");
              break;
              case "select":
              require("func/form_elements/".$vv['type'].".php");
              break;
              default:
              endswitch;
             */
        }
        //捕button
        switch ($arr['func'])
        {
            case 'insert':
                echo '<div class="text-right"><input value="新增"  type="submit" class="btn btn-success"></div>';
                break;
            case 'update':
                echo '<div class="text-right"><input value="更新"  type="submit" class="btn btn-success"></div>';
                break;
            case 'show':
                echo '<div class="text-right"><input value="回上頁"  type="submit" class="btn btn-success"></div>';
                break;
            default:
                # code...
                break;
        }

        echo '</form>';
    }
    echo '</div>';
    echo '</div>';
}

/*
  <div class="panel panel-primary">
  <div class="panel-heading">
  <h3 class="panel-title">Panel primary</h3>
  </div>
  <div class="panel-body">
  Panel content
  </div>
  </div>
 */
?>