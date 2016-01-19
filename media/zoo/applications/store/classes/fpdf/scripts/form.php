<?php

class FormPDF extends GridPDF {
	public $form;
	public $app;
	public $_pages;
	public $resource = 'default';
	public $type;
	public $table_x = 0;

	public function __construct() {
    	parent::__construct();
	}

	public function generate() {
		$this->grid = (bool) $this->form->get('grid',0);
		$margins = $this->form->margins;
		$this->AliasNbPages();
		$font = $this->form->font;
		$this->SetFont($this->getFont('family'),$this->getFont('style'),$this->getFont('size'));
	    $this->_AddPage($this->form->startPage);
	    
	    return $this;
	        
	}

	public function getFont($attribute) {
		$font = $this->form->font;
		switch ($attribute) {
			case 'family':
				return $font->get('family','arial');
				break;
			case 'style':
				return $font->get('style','');
				break;
			case 'size':
				return $font->get('size',8);
				break;
			default: 
				return '';
		}
	}

	public function _AddPage($page) {

		$page = $this->form->pages->$page;
		$this->AddPage($page->get('orientation', 'P'), $page->get('size', 'Letter'));
		$this->SetAutoPageBreak(false);

	    $this->currentPage = $page->name;
	    foreach($page->fields as $field) {
	    	$this->{$field->type}($field);
	    }
	}

	public function getFields() {
		foreach($this->form->pages as $page) {
			foreach($page->fields as $key => $value) {
				$fields[] = $key;
			}
		}
		return $fields;
	}

	public function setData($order) {
		$path = $this->app->path->path('classes:fpdf/scripts/'.$this->resource.'/'.$this->type.'.xml');
	    $this->form = $this->xml2obj(simplexml_load_file($path));
	    $fields = $this->getFields();
	    $data = array();
	    foreach($fields as $field) {
			if(!is_null($order->get($field))) {
				$data[$field] = $order->get($field);
			}
		}

	    $company = $this->form->company;
	    $data['form_title'] = $this->form->title;
	    $data['companyname'] = $company->companyname;
	    $data['companyaddress'] = array(
	    	$company->address->street,
	    	$company->address->city.', '.$company->address->state.'  '.$company->address->zip,
	    	$company->phone,
	    	$company->website,
	    	$company->email
	    );

	    $this->order_data = $data;
	    return $this;
	}
	public function pageNumbers($field) {
		$field->text = "Page {$this->PageNo()} of {nb}";
		$this->textbox($field);
	}
	protected function format($format, $text = null) {

		if(is_string($format)) {
			$params = $this->form->formats->get($format,$this->app->data->create());
		} else {
			$params = $format;
		}

		$font = $this->form->font;
		$this->setFont($params->get('font-family',$font->get('family','Arial')),$params->get('font-style',$font->get('style','')), $params->get('font-size', $font->get('size', 8)));

		if($indent = $params->get('indent')) {
			$this->SetX($this->GetX()+$indent);
		}

		if($mask = $params->get('mask') && !is_null($text) && $text != '') {
			switch($mask) {
				case 'currency':
					$text = $this->app->number->currency($text,array('currency' => 'USD'));
					break;
			}
		}

		return $text;

	}
	public function table($field) {

		$this->SetXY($field->x,$field->y);
		$col_x = $field->x;
		$col_y = $field->y;
		$this->registerTableData($field, $this->order_data[$field->name]);
		$data = &$this->tableData[$field->name];
		$start = $data['starting_row'];
		$overflow = false;
		foreach($field->columns as $column) {
			$w = $field->w*$column->w;
			$this->SetXY($col_x,$col_y);
			if($header = $column->get('header')) {
				$this->format($header);
				$this->Cell($w, 5,$column->header->get('text',$column->header),1,1,'C');
				$this->SetXY($col_x,$col_y += 5);
			}
			$rows = $field->rows;
			if($rows < ($data['total_rows'] - $start)) {
				$overflow = TRUE;
				$data['starting_row'] = $start + $rows;
			}
			$i = $start;
			for($rows_used = 1; $rows_used <= $rows; $rows_used++) {
				switch(true) {
					case ($rows_used == 1 && $rows_used < $rows): //First row but not last.
						$b[] = 'T';
						break;
					case ($rows_used == 1 && $rows_used == $rows): //First Row and last row.
						$b[] = 'T';
						$b[] = 'B';
						break;
					case ($rows_used > 1 && $rows_used == $rows): //Last row but not first
						$b[] = 'B';
						break;
				}
				$b[] = 'R';
				$b[] = 'L';
				$border = implode(',',$b);
				$b=array();
				$text = isset($data['columns'][$i][$column->name]['text']) ? $data['columns'][$i][$column->name]['text'] : '';
					$this->Cell($w,$column->get('line-height',5), '',$border);
					$this->SetXY($col_x, $col_y);
					$text = $this->format($column, $text);
					if(isset($data['columns'][$i][$column->name]['format'])) {
						$text = $this->format($data['columns'][$i][$column->name]['format'], $text);
					}
					$this->Cell($w,$column->get('line-height',5), $text,0,1,$column->get('align','L'));
				$this->SetXY($col_x, $col_y += $column->get('line-height',5));
				$i++;
			}
			
			$col_y = $field->y;
			$col_x += $w;
			$column->x = $col_x;
			$column->y = $col_y;
		}
		if ($overflow) {
			$page = $this->form->pages->get($this->currentPage)->gotopage;
			$this->_AddPage($page);
		}
			
	}
	public function textbox($field) {
		$this->format($field);
		//var_dump($this->order_data);
		$text = isset($this->order_data[$field->name]) ? $this->order_data[$field->name] : $field->get('text','');
		//var_dump($text);
		$text = $field->get('all-caps',0) ? strtoupper($text) : $text;
		$this->SetXY($field->x, $field->y);
		if(is_array($text)) {
			$text = array_filter($text);
			$txt = implode("\n",$text);
			$this->Cell($field->w,$field->get('h', 0),'',$field->get('border', 0));
			$this->SetXY($field->x, $field->y);
			$this->MultiCell($field->w, $field->get('line-height',5), $txt, 0, $field->get('align','L'));
		} else {
			//var_dump($text);
			$text = $this->format($field, $text);
			$this->Cell($field->w, $field->get('h', 0), $text, $field->get('border', 0), 0, $field->get('align','L'));
		}
		
		if ($title = $field->get('title')) {
			if(is_object($title)) {
				$align = $title->get('align','L');
				$this->format($title);
				$w = $field->w;
				$h = 5;
				switch($align) {
					case 'R':
						$w = $this->GetStringWidth($title->get('text',''))+5;
						$this->SetXY($field->x+$title->get('w',$w), $field->y);
						break;
					case 'L':
						$w = $this->GetStringWidth($title->get('text',''))+5;
						$this->SetXY($field->x-$title->get('w',$w), $field->y);
						break;
					case 'T':
						$w = $field->w;
						$this->SetXY($field->x,$field->y-$title->get('h',$h));
						break;
					case 'B':
						$w = $field->w;
						$this->SetXY($field->x,$field->y+$title->get('h',$h));
						break;
					default:
						$this->SetXY($field->x-$title->get('w',$w), $field->y);
				}
				$this->Cell($title->get('w',$w), $title->get('h',$h), $title->get('text',''), $title->get('border',0),0, $title->get('text-align','L'));
			}
		}
	}

	public function logo($field) {
		$x = $field->get('x');
		$y = $field->get('y');
		$w = $field->get('w');
		$h = $field->get('h');
		$border = $field->get('border');
		$path = $this->form->company->logoPath;
		$this->Image($path,$x,$y,$w,$h);
	}

	public function toFile() {
	    $name = $this->app->utility->generateUUID().'.pdf';
	    $path = $this->app->path->path('assets:pdfs/');
	    $this->Output($path.'/'.$name,'F');
	    return $name;
	}

	public function toBrowser() {
	    return $this->Output($this->type.'.pdf',"I");
	}

	public function xml2obj($xml) {
		$arr = array();

	    foreach ($xml as $element)
	    {
	    	$attrs = $element->attributes();
	        $tag = $element->getName();
	        $e = get_object_vars($element);
	        if (!empty($e))
	        {
	        	$elem = $element instanceof SimpleXMLElement ? $this->xml2obj($element) : $e;
	        	foreach($attrs as $key =>$attr) {
	        		$elem->$key = is_float($attr) ? (float) $attr : (string) $attr;
	        	}
	        	$name = $elem->get('name',$tag);
	        	$xmlObj[$name] = $elem;
	        }
	        else
	        {
	            $xmlObj[$tag] = is_float($element) ? (float) $element : (string) $element;
	        }
	    }
	    foreach($xml->attributes() as $key => $attr) {
	    	$xmlObj[$key] = is_float($attr) ? (float) $attr : (string) $attr;
	    }
	    return $this->app->data->create($xmlObj);
	}

	public function loadPages() {

		$pages = $this->form->pages->page;
		
			$obj = $this->xml2obj($pages);
			$this->_pages = $obj;
	}

	public function populate($data) {
		$this->SetFont('Arial','',8);
		$fields = $this->_pages->fields;
		foreach($data as $key => $value) {
			if(isset($fields->$key)) {
				$field = $fields->$key;
				if(is_string($value)) {
					$this->SetXY($field->params->x, $field->params->y);
					$this->Cell($field->params->w, $field->params->h, $value, 0, 0, $field->params->get('align'));
				} else {
					$this->SetXY($field->params->x+$field->params->get('data-padding'), $field->params->y);
					$txt = implode("\n",$value);
					$this->Multicell($field->params->w,5, $txt);
				}
			}
			
		}

		//var_dump($data);
	}

	public function registerTableData($field, $data) {
		if(isset($this->tableData[$field->name])) {
			return;
		}
		$table = array(
			'total_rows' => 0,
			'starting_row' => 0,
			'columns' => array()
		);
	    $last_row = 0;
	 //    echo '<pre>';
		// var_dump($data);
		// echo '</pre>';
	    foreach ($data as $item) {
	    	$itemNum = 1;
	    	$starting_row = $last_row;
	    	foreach($item as $column => $value) {
	    		$line_number = $starting_row;
	    		if(isset($value['text']))
	    			$value = array($value);
	    		foreach($value as $v) {
					if($v['text'] == '') 
						continue;
					$column_params = $field->columns->get($column,$this->app->data->create());
					if(isset($v['format'])) {
						$format = $this->form->formats->get($v['format'], $this->app->data->create());
						$indent = $format->get('indent', 0);
					} else {
						$indent = 0;
					}
					$lines = $this->NbLines(($field->w*$column_params->get('w',0))-$indent,$v['text']);
			    	foreach($lines as $line) {
			    		$table['columns'][$line_number][$column]['text'] = $line;
			    		$table['columns'][$line_number][$column]['format'] = isset($v['format']) ? $v['format'] : NULL;
			    		$line_number++;
			    	}
			    }
			    if(count($data) > 1 && $itemNum != count($data)) {
		    		$table['columns'][$line_number][$column]['text'] = '';
		    		$line_number++;
			    }
			    $itemNum++;
	    	$last_row = $last_row > $line_number ? $last_row : $line_number;
	    	}	
	    }
	    $table['total_rows'] = $last_row - 1;
	    
		// echo '<pre>';
		// var_dump($table);
		// echo '</pre>';
	    $this->tableData[$field->name] = $table;
		return $table;

	}

	public function populateTable($data) {
		$page = $this->currentPage;
		foreach($this->_pages->$page->fields as $field) {
			if ($field->type == 'table') {
				$table = $field;
			}
		}
	}

	function NbLines($w,$txt) {
	    //Computes the number of lines a MultiCell of width w will take
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
	        $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r",'',$txt);
	    $nb=strlen($s);
	    if($nb>0 and $s[$nb-1]=="\n")
	        $nb--;
	    $i=0;
	    $ll=0;
	    $wl=0;
	    $arr = array();
	    $text = '';
	    $word = '';
	    while($i<$nb)
	    {
	        $c=$s[$i];
	        // Check if the character is a newline
	        if($c=="\n")
	        {
	            $i++;
	            $ll=0;
	            $wl=0;
	            $text .= $word;
	            $arr[] = $text;
	            $text = '';
	            $word = '';
	            continue;
	        }
	        // Check if the character is a space
	        if($c==' ') {
	        	if (($ll + $wl) > $wmax) { // if the line length + word length is greater than the length allowed.
	        		$arr[] = trim($text);
	        		$word .= $c;
	        		$wl += $cw[$c];
	        		$text = $word;
	        		$ll = $wl;
	        		$word = '';
	        		$wl=0;
	        		$i++;

	        	} else {
	        		$word .= $c;
	        		$wl += $cw[$c];
	        		$text .= $word;
	        		$ll += $wl;
	        		$word = '';
	        		$wl=0;
	        		$i++;
	        	}
	        	continue;
	        }
	        $word .= $c;
	        $wl += $cw[$c];
	        $i++;

	    }
	    if(($ll + $wl) > $wmax) {
	    	$arr[] = trim($text);
	    	$arr[] = trim($word);
	    } else {
	    	$text .= $word;
	    	$arr[] = $text;
	    }
	    return $arr;
	}
}

class FormTable extends GridPDF {

	public function __construct($pdf, $params) {
		$this->pdf = $pdf;
		foreach($params as $key => $param) {
			$this->$key = $param;
		}
	}

	public function test() {
		$this->pdf->Cell(10,10,'This is a test!!.');
	}



}

?>