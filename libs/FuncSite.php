<?php
class FuncSite extends Func
{
	public static function backend_page_function($curr_page,$last_page,$arr){
		//PHP_SELF 
		$PHPSELF = $_SERVER['PHP_SELF'];
		if(!empty($arr)){
				while(list($kk,$vv)=each($arr)){
					$tmp1 .= "$kk=$vv&";
					$tmp3 .='<input type="hidden" name="'.$kk.'" value="'.$vv.'" />';
				}
		}
		$tmp1 = substr ($tmp1, 0,strlen($tmp1)-1);
		if (strlen($tmp1)>0) $tmp1= '&'.$tmp1;
		$tmp2 = '<form method="get">【&nbsp;&nbsp;<a href="'.$PHPSELF.'?next_page=1' . $tmp1 . '">最前頁</a>&nbsp;|&nbsp;<a href="'.$PHPSELF.'?next_page='.($curr_page-1). $tmp1 .'">上一頁</a>&nbsp;|&nbsp;&nbsp;<a href="'.$PHPSELF.'?next_page='.($curr_page+1). $tmp1 .'">下一頁</a>|&nbsp;&nbsp;<a href="'.$PHPSELF.'?next_page='. $last_page . $tmp1 . '">最後頁</a>&nbsp;】&nbsp;&nbsp;頁碼:<input name="next_page" value="'.$_GET['next_page'].'" size="2">'.$tmp3.'</form>';
		return $tmp2;
	}
	public static function makeForm($arr){
		echo '<form role="form" class="form-horizontal col-md-12" name="'.$arr['form_name'].'" id="'.$arr['form_name'].'" method="post" enctype="multipart/form-data"><input type="hidden" name="flag" value="true" />';

		echo '<div class="row"><div class="col-sm-12 text-center">';
		echo '<button type="button" onclick="javascript:history.go(-1);" class="btn btn-outline-secondary">上一頁</button>';
		echo '&nbsp;';
		switch ($arr['func']) {
			case 'insert':
				echo '<button type="submit" class="btn btn-primary">新增</button>';
				break;
			case 'update':
				echo '<button type="submit" class="btn btn-primary">更新</button>';
				break;
			case 'show':
				echo '<button type="submit" class="btn btn-primary">返回</button>';
				break;
			case 'send':
				echo '<button type="submit" class="btn btn-primary">送出</button>';
				break;	
			case 'copy':
				echo '<button type="submit" class="btn btn-primary">複製</button>';
				break;		
			default:
				# code...
				break;
		}
		echo '&nbsp;';
		echo '<button type="reset" class="btn btn-outline-secondary">取消</button>';
		echo '</div></div>';

		if($arr['form_title']){
			echo ' <div class="panel panel-default panel-no-heading">
					<div class="panel-heading"><b>'.$arr['form_title'].'</b></div>';
		}
		
		echo '<div class="panel-body"><br/>';
		echo '<div class="row">';
		
		echo '<div class="col-md-1"></div>';
		if(is_array($arr['elements'])){
			echo '<div class="col-md-10">';
			foreach($arr['elements'] as $kk=>$vv){

				if(file_exists("func/form_elements/".$vv['type'].".php"))require("func/form_elements/".$vv['type'].".php");
				
			}			
		}
	echo '</div></div></div><br/>';
	// echo '<div class="col-md-1"></div>';
	echo '</div>';


	echo '<br/><br/><div class="row"><div class="col-sm-12 text-center">';
	// echo '</div></div></div><br/><div class="row"><div class="col-sm-12 text-center">';
	//捕button
	echo '<button type="button" onclick="javascript:history.go(-1);" class="btn btn-outline-secondary">上一頁</button>';
	echo '&nbsp;';
	switch ($arr['func']) {
		case 'insert':
			echo '<button type="submit" class="btn btn-primary">新增</button>';
			break;
		case 'update':
			echo '<button type="submit" class="btn btn-primary">更新</button>';
			break;
		case 'show':
			echo '<button type="submit" class="btn btn-primary">返回</button>';
			break;
		case 'send':
			echo '<button type="submit" class="btn btn-primary">送出</button>';
			break;	
		case 'copy':
			echo '<button type="submit" class="btn btn-primary">複製</button>';
			break;		
		default:
			# code...
			break;
	}
	echo '&nbsp;';
	echo '<button type="reset" class="btn btn-outline-secondary">取消</button>';
	echo '</div>';
	echo '</div>';
	echo '</form>';
	}
	public static function makeDate_admin($arr){	
		echo '<div class="col-md-4">
                                        <small>最後登入日期時間: '.$arr['last_login_date'].'</small>
                                    </div>
                                    <div class="col-md-4">
                                        <small>IP: '.$arr['last_login_ip'].'</small>
                                    </div>';
	}
	public static function makeDate($arr){	
		echo '<div class="col-md-4">
                                        <small>新增日期: '.date('Y-m-d H:i:s',$arr['create_date']).'</small>
                                    </div>
                                    <div class="col-md-4">
                                        <small>最近更新日期: '.date('Y-m-d H:i:s',$arr['update_date']).'</small>
                                    </div>';
	}
	public static function makeDate_upd($arr){	
		echo '<div class="col-md-4">
                                        <small>最近更新日期: '.date('Y-m-d H:i:s',$arr['update_date']).'</small>
                                    </div>';
	}
	public static function msg_box($msg){		
		if(is_array(Session::get('alert','client'))){
			array_push(Session::get('alert','client'),array($msg));
		}else{
			Session::set('alert',array($msg),'client');
		}
	}
	public static function msg_box_error($msg){		
		if(is_array(Session::get('alert1','client'))){
			array_push(Session::get('alert1','client'),array($msg));
		}else{
			Session::set('alert1',array($msg),'client');
		}
	}
	public static function fore_page($curr_page,$last_page,$arg=''){
		if($last_page<=0) {
			return 0;
		}
		if(is_array($arg)){
			foreach ($arg as $kk => $vv) {
				if($kk!='curr_page' && $vv!='' && $kk!='p'){
					$page_tmp .= "{$kk}={$vv}&";
				}
			}
		}
		// $page_tmp = $_SERVER['QUERY_STRING'];
	     echo '<ul class="pagination">';
	     if($curr_page <= 1){
	     	echo '<li class="disabled">
	                    <a href="javascript:void(0);" onclick="return false;">&laquo;</a>
	                  </li>';

	     }else{
			echo '<li>
	                    <a href="?'.$page_tmp.'&curr_page=1">&laquo;</a>
	                  </li>';    	

	     }
	    for($i=1;$i<=$last_page;$i++){
	    	if($i == $curr_page){
	    		echo '<li class="active">
	                    <a href="?'.$page_tmp.'&curr_page='.$i.'">'.$i.'</a>
	                  </li>';
	    	}else{
	    		echo '<li>
	                    <a href="?'.$page_tmp.'&curr_page='.$i.'">'.$i.'</a>
	                  </li>';
	    	}
	    }
		if($curr_page >= $last_page){
	     	echo '<li class="disabled">
	                    <a href="javascript:void(0);"  onclick="return false;">&raquo;</a>
	                  </li>';

	     }else{
			echo '<li>
	                    <a href="?'.$page_tmp.'&curr_page='.$last_page.'">&raquo;</a>
	                  </li>';    	

	     }     
	     echo '</ul>';
	}
	public static function fore_page1($curr_page,$last_page,$arg='',$rows){
		if($last_page<=0) {
			return 0;
		}
		if(is_array($arg)){
			foreach ($arg as $kk => $vv) {
				$page_tmp .= "{$kk}={$vv}&";
			}
		}
		$nowp = $_GET['p'];
	    if ($nowp == ''){
	        $nowp = 1;
	    }
	    if ($last_page >= 6){
	        $first = $nowp - 2;//3
	        $last = $nowp + 2;//7
	        if ($first <= 0){
	            $first = 1;
	            $last = 5;
	        }elseif($last > $last_page){
	            $first = $last_page - 4;
	            $last = $last_page;
	        }
	    }else{
	        $first = 1;
	        $last = $last_page;
	    }
	    $pre = $nowp-1;
	    if($pre<=0){
	    	$pre = '1';
	    }
	    $bef = $nowp+1;
	    if($bef>$last_page){
	    	$bef = $last_page;
	    }
		echo '<ul class="pagination">';
		// echo '<li class="pre"><a href="?'.$page_tmp.'p=1" title="第一頁"><i class="icon-pagination-first"><img src="images/comm/btn_pre2.png"></i></a></li>';
	     if($curr_page <= 1){
			 echo '<li class="pagination__pre">
			 	<a href="javascript:void(0);" title="前一頁" onclick="return false;"> pre</a></li>';
	     }else{
			echo '<li class="pagination__pre">
				<a href="?'.$page_tmp.'p='.$pre.'" title="前一頁"> pre</a></li>';

	     }
	    for($i=$first;$i<=$last;$i++){
	    	if($i == $curr_page){
	    		echo '<li class="is-active" ><a href="?'.$page_tmp.'p='.$i.'" class="pagination__link" ">'.$i.'</a></li>';
	    	}else{
	    		echo '<li><a href="?'.$page_tmp.'p='.$i.'" class="pagination__link" ">'.$i.'</a></li>';
	    	}
	    }
		if($curr_page >= $last_page){
			echo '<li class="pagination__next"><a href="javascript:void(0);" title="下一頁" onclick="return false;"> next</a></li>';
	     }else{
			echo '<li class="pagination__next"><a href="?'.$page_tmp.'p='.$bef.'" title="下一頁"> next</a></li>';
	     }
	     // echo '<li class="last"><a href="?'.$page_tmp.'p='.$rows.'" title="最後一頁"><i class="icon-pagination-last"><img src="images/comm/btn_next2.png"></i></a></li>';
	     echo '</ul> ';
	}
	public static function fore_page2($curr_page,$last_page,$arg=''){
		if($last_page<=0) {
			return 0;
		}
		if(is_array($arg)){
			foreach ($arg as $kk => $vv) {
				$page_tmp .= "{$kk}={$vv}&";
			}
		}
		
	  //    echo '<ul class="pagination pagination-sm">';
	  //    if($curr_page <= 1){
	  //    	echo '<li class="disabled">
	  //                   <a href="javascript:void(0);" onclick="return false;">&laquo;</a>
	  //                 </li>';

	  //    }else{
			// echo '<li>
	  //                   <a href="?'.$page_tmp.'curr_page=1">&laquo;</a>
	  //                 </li>';    	

	  //    }
	    for($i=1;$i<=$last_page;$i++){
	    	if($i == $curr_page){
	    		echo '<li class="is-active">
	                    <a href="?'.$page_tmp.'p='.$i.'">'.$i.'</a>
	                  </li>';
	    	}else{
	    		echo '<li>
	                    <a href="?'.$page_tmp.'p='.$i.'">'.$i.'</a>
	                  </li>';
	    	}
	    }
		// if($curr_page >= $last_page){
	 //     	echo '<li class="disabled">
	 //                    <a href="javascript:void(0);"  onclick="return false;">&raquo;</a>
	 //                  </li>';

	 //     }else{
		// 	echo '<li>
	 //                    <a href="?'.$page_tmp.'curr_page='.$last_page.'">&raquo;</a>
	 //                  </li>';    	

	 //     }     
	 //     echo '</ul>';
	}
} 