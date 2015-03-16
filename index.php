<html>

<head>
	<title>Test</title>
<head>

<body>

<?php

	function check_arr($arr_ch, $cell_num) {

		for($i=0, $arr_count=count($arr_ch); $i<$arr_count; $i++) {
			$pos = strpos($arr_ch[$i]['cells'],(string)$cell_num);
			if ($pos !== false) {
				return $i;
				break;
			}
		}
		return false;
	}
	
	function get_arr_div_glob($arr) {
	
		$x = 100; /*ширина ячейки*/
		$y = 100; /*высота ячейки*/
		
		$arr_div_glob = array(); /*массив результирующих структур областей*/
		
		for ($i=1;$i<=9;$i++) {

			$arr_div = array(); /*структура области*/			
			$arr_ind_i = check_arr($arr,$i);
			
			$coord_x_i = (((($i%3)==0)?(3):($i%3))-1)*$x;
			$coord_y_i = floor(($i-1)/3)*$y;
		
			if ($arr_ind_i !== false) {
			
				$arr_div_glob_ind_i = check_arr($arr_div_glob,$i);
			
				if ($arr_div_glob_ind_i === false) {
					/*создаём новую область*/
					$arr_div['cells'] = (string)$i;
					$arr_div['arr_ind'] = $arr_ind_i;
					$arr_div['coord_x'] = $coord_x_i;
					$arr_div['coord_y'] = $coord_y_i;
					$arr_div['width'] = $x;
					$arr_div['height'] = $y;
					$arr_div['text'] = $arr[$arr_ind_i]['text'];
					$arr_div['align'] = $arr[$arr_ind_i]['align'];
					$arr_div['valign'] = $arr[$arr_ind_i]['valign'];
					$arr_div['color'] = $arr[$arr_ind_i]['color'];
					$arr_div['bgcolor'] = $arr[$arr_ind_i]['bgcolor'];
					
					$arr_div_glob[] = $arr_div;
					
					$ind = count($arr_div_glob)-1;
				}
				else {
					$ind = $arr_div_glob_ind_i;
				}
				
				/*проверка смежных ячеек*/
				for ($j=1;$j<=9;$j++) {
					$n = $j-$i;
					$arr_ind_j = check_arr($arr,$j);
					$arr_div_glob_ind_j = check_arr($arr_div_glob,$j);
					
					$coord_x_j = (((($j%3)==0)?(3):($j%3))-1)*$x;
					$coord_y_j = floor(($j-1)/3)*$y;
					
					if (($arr_ind_j === $arr_ind_i)&&($arr_div_glob_ind_j === false)) {
						if ($n==1) {						
							if (($j!=4)&&($j!=7)) {
	
								/*увеличить ширину  области в массиве областей*/
								$arr_div_glob[$ind]['cells'] = $arr_div_glob[$ind]['cells'] .','. (string)$j;
								$arr_div_glob[$ind]['width'] = ($arr_div_glob[$ind]['width']>$coord_x_j)?($arr_div_glob[$ind]['width']):($arr_div_glob[$ind]['width']+$x);
							}
						}
						elseif ($n==3) {

							/*увеличить высоту  области в массиве областей*/
							$arr_div_glob[$ind]['cells'] = $arr_div_glob[$ind]['cells'] .','. (string)$j;
							$arr_div_glob[$ind]['height'] = ($arr_div_glob[$ind]['height']>$coord_y_j)?($arr_div_glob[$ind]['height']):($arr_div_glob[$ind]['height']+$y);
						}
					}
				}				
			}
			else {
				/*создаём пустую область, добавляем в массив*/
				
				$arr_div['cells'] = (string)$i;
				$arr_div['arr_ind'] = 10;
				$arr_div['coord_x'] = $coord_x_i;
				$arr_div['coord_y'] = $coord_y_i;
				$arr_div['width'] = $x;
				$arr_div['height'] = $y;
				$arr_div['text'] = '';
				$arr_div['align'] = '';
				$arr_div['valign'] = '';
				$arr_div['color'] = '';
				$arr_div['bgcolor'] = '';
				
				$arr_div_glob[] = $arr_div;
			}
		}
		
		return $arr_div_glob;
	}
	
	function show_table() {
	
		$arr_conditions = array(
				array( 'text' => 'Text'
					, 'cells' => '1,2,4,5'
					, 'align' => 'center'
					, 'valign' => 'center'
					, 'color' => 'FF0000'
					, 'bgcolor' => '33CC00')
			, array( 'text' => 'Text'
					, 'cells' => '3,6'
					, 'align' => 'center'
					, 'valign' => 'top'
					, 'color' => '0033CC'
					, 'bgcolor' => 'CC3399')
			, array( 'text' => 'Text'
					, 'cells' => '8,9'
					, 'align' => 'right'
					, 'valign' => 'bottom'
					, 'color' => '00FF00'
					, 'bgcolor' => 'FFFF00'));
	
		$arr_div_glob = get_arr_div_glob($arr_conditions);
				
		for($i=0, $arr_count=count($arr_div_glob); $i<$arr_count; $i++) {
		
				
			$valign = ($arr_div_glob[$i]['valign']=='center')?('middle'):($arr_div_glob[$i]['valign']);
				
			echo('<div style="
			border: 1px solid black; 
			background-color: '.$arr_div_glob[$i]['bgcolor'].'; 
			color: '.$arr_div_glob[$i]['color'].';
			text-align: '.$arr_div_glob[$i]['align'].';
			display: table;
			position: absolute;
			top: '.$arr_div_glob[$i]['coord_y'].'px;
			left: '.$arr_div_glob[$i]['coord_x'].'px;
			width: '.$arr_div_glob[$i]['width'].'px;
			height: '.$arr_div_glob[$i]['height'].'px;">
				<div style="
				display: table-cell; 
				vertical-align: '.$valign.';">'
				.$arr_div_glob[$i]['text'].'
				</div>
			</div>');			
		}		
	}
	
	show_table();

?>

</body>

</html>