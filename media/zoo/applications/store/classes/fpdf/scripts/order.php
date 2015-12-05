<?php

class OrderPDF extends GridPDF
{
    protected $company = array(
        "logo_path" => "images/logos/ttop/TTop_100x100.png",
        "name" => "Laporte's T-Top Boat Covers",
        "address" => array(
            "4651 Franchise Street",
            "North Charleston, SC  29418",
            "(843) 760-6101",
            "http://www.ttopcovers.com",
            "info@ttopcovers.com"
        )
    );
    public $order_data;
    public $items;
    public $fields = array();
    
    public $table = array(
        'columns' => array(
            'Item Description' => array(
                'w' => 80
            ),
            'Quantity' => array(
                'w' => 10
            ),
            'Unit Price' => array(
                'w' => 10
            )
        )
    );
    
    protected $angle = 0;

public function __construct($app, $orientation='P', $unit='mm', $size='A4') {
    parent::__construct($app, $orientation, $unit, $size);
}

public function generate($output = "F") {
    $this->grid = false;
    $this->AddPage('P','Letter');
    $this->Company();
    $this->Label('Work Order');
    $this->OrderData();
    $this->ShipTo();
    $this->BillTo();
    $this->table($this->items);
    $this->totals();
    foreach($this->order_data as $field => $value) {
        if(isset($this->fields[$field])) {
            $f = $this->fields[$field];
            $this->addData($f['x'], $f['y'], $f['w'], $f['h'], $value, (isset($f['align']) ? $f['align'] : 'C'), (isset($f['fontSize']) ? $f['fontSize'] : 8));
        } 
    }
    switch ($output) {
        case 'F':
            $name = '/'.$this->app->utility->generateUUID().'.pdf';
            $path = $this->app->path->path('assets:pdfs/');
            $this->Output($path.$name,$output);
            return $name;
            break;
        case 'I':
            $name = 'Order-'.$this->order_data['Order Number'];
            $this->Output($name, $output);
            break;
    }

    
    
        
}

public function setData($order) {
    //var_dump($order);
    $billing = $order->billing;
    $shipping = $order->shipping;
    $data['Bill To'] = array(
        $billing->firstname.' '.$billing->lastname,
        $billing->address,
        $billing->city.', '.$billing->state.'  '.$billing->zip,
        $billing->phoneNumber,
        $billing->altNumber,
        $billing->email
    );
    $data['Ship To'] = array(
        $shipping->firstname.' '.$shipping->lastname,
        $shipping->address,
        $shipping->city.', '.$shipping->state.'  '.$shipping->zip,
        $shipping->phoneNumber,
        $shipping->altNumber
    );
    
    $data['Order Date'] = $order->getOrderDate();
    $data['Salesperson'] = $order->getSalesPerson();
    $data['Order Number'] = $order->id;
    $data['Delivery'] = $order->localPickup ? 'Local Pickup' : 'UPS Ground';
    $data['Transaction ID'] = $order->transaction_id;
    $data['Subtotal'] = '$'.number_format($order->subtotal,2,'.','');
    $data['Shipping'] = '$'.number_format($order->ship_total,2,'.','');
    $data['Taxes'] = '$'.number_format($order->tax_total,2,'.','');
    $data['Total'] = '$'.number_format($order->total,2,'.','');
    $this->order_data = $data;
    //var_dump($this->order_data);
    $this->items = $order->items;
    return $this;
}

// private functions
function RoundedRect($x, $y, $w, $h, $r, $style = '')
{
    $k = $this->k;
    $hp = $this->h;
    if($style=='F')
        $op='f';
    elseif($style=='FD' || $style=='DF')
        $op='B';
    else
        $op='S';
    $MyArc = 4/3 * (sqrt(2) - 1);
    $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
    $xc = $x+$w-$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

    $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
    $xc = $x+$w-$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
    $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
    $xc = $x+$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
    $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
    $xc = $x+$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
    $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
    $this->_out($op);
}

function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
    $h = $this->h;
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
                        $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}

function Rotate($angle, $x=-1, $y=-1)
{
    if($x==-1)
        $x=$this->x;
    if($y==-1)
        $y=$this->y;
    if($this->angle!=0)
        $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0)
    {
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->k;
        $cy=($this->h-$y)*$this->k;
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
}

function _endpage()
{
    if($this->angle!=0)
    {
        $this->angle=0;
        $this->_out('Q');
    }
    parent::_endpage();
}

// public functions
function sizeOfText( $texte, $largeur )
{
    $index    = 0;
    $nb_lines = 0;
    $loop     = TRUE;
    while ( $loop )
    {
        $pos = strpos($texte, "\n");
        if (!$pos)
        {
            $loop  = FALSE;
            $ligne = $texte;
        }
        else
        {
            $ligne  = substr( $texte, $index, $pos);
            $texte = substr( $texte, $pos+1 );
        }
        $length = floor( $this->GetStringWidth( $ligne ) );
        $res = 1 + floor( $length / $largeur) ;
        $nb_lines += $res;
    }
    return $nb_lines;
}

public function addData($x, $y, $w, $h, $text, $align = 'L', $fontSize = 10) {
    $this->SetXY($x, $y);
    $this->SetFont('Arial','',$fontSize);
    if (is_array($text)) {
        $txt = implode("\n",$text);
        
        $this->MultiCell($this->GetStringWidth($txt), $h, $txt);
    } else {
        $this->cell($w, $h, $text,0,0, $align);
    }
    
    
}

// Company
function Company()
{
    $name = $this->company['name'];
    $address = implode("\n", $this->company['address']);
    $logo = $this->company['logo_path'];
    $x = 10;
    $y = 8;
    $this->SetXY($x, $y);
    $this->Image($logo, $x, $y, 23, 23, "png");
    //Positionnement en bas
    $this->SetXY( $x + 23, $y);
    $this->SetFont('Arial','B',12);
    $length = $this->GetStringWidth( $name );
    $this->Cell( $length, 2, $name);
    $this->SetXY( $x + 23, $y + 4 );
    $this->SetFont('Arial','',10);
    $length = $this->GetStringWidth( $address );
    $this->MultiCell($length, 4, $address);
}

// Label of invoice/estimate
function Label($text)
{
    $x = $this->w - 50;
    $y = 8;
    
    $text  = strtoupper($text);    
    $szfont = 30;
    $this->SetFont( "Arial", "B", $szfont );

    $this->SetXY( $x, $y);
    $this->Cell(40,5, $text, 0, 0, "R" );
}

function ShipTo()
{
    // if(!isset($this->order_data['Ship To'])) {
    //     return;
    // }
    $r1  = $this->w - 85;
    $r2  = $r1 + 75;
    $y1  = 40;
    $y2  = 35;
    $mid = $y1 + 5;
    $this->fields['Ship To'] = array(
        'x' => $r1 + 3,
        'y' => $y1 + 6,
        'w' => 25,
        'h' => 4,
        'align' => 'L',
        'multicell' => true,
        'fontSize' => 9
    );
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1, $y1 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell($r2 - $r1,5, "Ship To", 0, 0, "C");
}

function BillTo()
{
    $box_x = 10;
    $box_y = 40;
    $w  = 75;
    $h  = 35;
    $mid = $box_y + 5;
    $this->fields['Bill To'] = array(
        'x' => $box_x + 3,
        'y' => $box_y + 6,
        'w' => 25,
        'h' => 4,
        'align' => 'L',
        'multicell' => true,
        'fontSize' => 9
    );
    $this->RoundedRect($box_x, $box_y, $w, $h, 3.5, 'D');
    $this->Line( $box_x, $mid, $box_x + $w, $mid);
    $this->SetXY( $box_x, $box_y );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell($w,5, "Bill To", 0, 0, "C");
}

public function OrderData() {
//    Order Date
    $x = $this->w - 55;
    $y = 16;
    $w = 20;
    $h = 5;
    $this->fields['Order Date'] = array(
        'x' => $x + $w,
        'y' => $y,
        'w' => $w+10,
        'h' => $h,
        'align' => 'R'
    );
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "", 8);
    $this->Cell($w,$h, "Order Date:", 0, 0, "L");
    
//    Customer ID
    // $x = $this->w - 50;
    // $y = 20;
    // $w = 20;
    // $h = 5;
    // $this->fields['Customer ID'] = array(
    //     'x' => $x + $w,
    //     'y' => $y,
    //     'w' => $w,
    //     'h' => $h,
    //     'align' => 'R'
    // );
    // $this->SetXY( $x, $y );
    // $this->SetFont( "Arial", "", 8);
    // $this->Cell($w,$h, "Acct Number:", 0, 0, "L");
    
    // Salesperson
    $x = 10;
    $y = 80;
    $h = 10;
    $w = ($this->w - 20)/4;
    $this->fields['Salesperson'] = array(
        'x' => $x,
        'y' => $y+5,
        'w' => $w,
        'h' => 5
    );    
    $this->Rect($x, $y, $w, $h);
    $this->line($x, $y + 5, $x + $w, $y + 5);
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell($w,5, 'Salesperson', 0, 0, "C");
    
    // Order Number
    $x += $w;
    $y = 80;
    $h = 10;
    $w = ($this->w - 20)/4;
    $this->fields['Order Number'] = array(
        'x' => $x,
        'y' => $y+5,
        'w' => $w,
        'h' => 5
    );    
    $this->Rect($x, $y, $w, $h);
    $this->line($x, $y + 5, $x + $w, $y + 5);
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell($w,5, 'Order Number', 0, 0, "C");
    
    // Delivery Method
    $x += $w;
    $y = 80;
    $h = 10;
    $w = ($this->w - 20)/4;
    $this->fields['Delivery'] = array(
        'x' => $x,
        'y' => $y+5,
        'w' => $w,
        'h' => 5
    );    
    $this->Rect($x, $y, $w, $h);
    $this->line($x, $y + 5, $x + $w, $y + 5);
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell($w,5, 'Delivery Method', 0, 0, "C");
    
    // Transaction ID
    $x += $w;
    $y = 80;
    $h = 10;
    $w = ($this->w - 20)/4;
    $this->fields['Transaction ID'] = array(
        'x' => $x,
        'y' => $y+5,
        'w' => $w,
        'h' => 5
    );    
    $this->Rect($x, $y, $w, $h);
    $this->line($x, $y + 5, $x + $w, $y + 5);
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell($w,5, 'Transaction ID', 0, 0, "C");
    

}
public function table($items) {
    $x = 10;
    $y = 92;
    $header = array(
        'h' => 5
    );

    $table = array(
        'w' => $this->w - ($x*2),
        'h' => $this->h - ($y + $this->bMargin + 30)
    );
    
    foreach($this->table['columns'] as $heading => $values) {
        $col_width = $values['w']/100;
        $w = $table['w']*$col_width;
        $table['columns'][$heading] = array(
            'w' => $w,
            'h' => 5,
            'x' => $x,
            'y' => $y+$header['h']+2
        );
        $this->Rect($x, $y, $w, $header['h']);
        $this->SetXY( $x, $y );
        $this->SetFont( "Arial", "B", 8);
        $this->Cell($w,5, $heading, 0, 0, "C");
        $this->Rect($x, $y+ $header['h'], $w, $table['h']);
        $x += $w;
    }
    $top = 99;
    $bottom = 99;
    foreach($items as $key => $item) {
        
        // Item Description
        $col = $table['columns']['Item Description'];
        $name = $item->name;
        $this->addData($col['x'], $top, $col['w'], $col['h'], $name);
        $bottom += 5;
        foreach($item->options as $option => $text) {
            $text = $text['name'].':  '.$text['text'];
            $this->addData($col['x']+2, $bottom, $col['w'], $col['h'], $text, 'L', 8);
            $bottom += 5;
        }
        
        // Item Quantity
        $col = $table['columns']['Quantity'];
        $text = $item->qty;
        $this->addData($col['x'], $top, $col['w'], $col['h'], $text, 'C');
        // Item Total
        $col = $table['columns']['Unit Price'];
        $text = $item->getTotal();
        $this->addData($col['x'], $top, $col['w'], $col['h'], $text, 'C');
        $top = $bottom;
    }
    
    
}

public function totals() {
    $w = 40;
    $h = 20;
    $x = $this->w - ($w + 10);
    $y = $this->h - ($h + $this->bMargin);
    
    $this->Rect($x, $y, $w, $h);
    
    $this->fields['Subtotal'] = array(
        'x' => $x + 20,
        'y' => $y,
        'w' => 20,
        'h' => 5,
        'align' => 'R'
    );
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell(20,4, 'Subtotal', 0, 0, "L");
    
    $y += 5;

    $this->fields['Taxes'] = array(
        'x' => $x + 20,
        'y' => $y,
        'w' => 20,
        'h' => 5,
        'align' => 'R'
    );
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell(20,4, 'Taxes', 0, 0, "L");
    
    $y += 5;

    $this->fields['Shipping'] = array(
        'x' => $x + 20,
        'y' => $y,
        'w' => 20,
        'h' => 5,
        'align' => 'R'
    );
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell(20,4, 'Shipping', 0, 0, "L");
    
    $y += 5;

    $this->fields['Total'] = array(
        'x' => $x + 20,
        'y' => $y,
        'w' => 20,
        'h' => 5,
        'align' => 'R'
    );
    $this->SetXY( $x, $y );
    $this->SetFont( "Arial", "B", 8);
    $this->Cell(20,4, 'Total', 0, 0, "L");

    
}

// Mode of payment
function addReglement( $mode )
{
    $r1  = 10;
    $r2  = $r1 + 60;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1+1 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell(10,4, "MODE DE REGLEMENT", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1 + 5 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$mode, 0,0, "C");
}

// Expiry date
function addEcheance( $date )
{
    $r1  = 80;
    $r2  = $r1 + 40;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2 - $r1)/2 - 5 , $y1+1 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell(10,4, "DATE D'ECHEANCE", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5 , $y1 + 5 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$date, 0,0, "C");
}

// VAT number
function addNumTVA($tva)
{
    $this->SetFont( "Arial", "B", 10);
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + 16 , $y1+1 );
    $this->Cell(40, 4, "TVA Intracommunautaire", '', '', "C");
    $this->SetFont( "Arial", "", 10);
    $this->SetXY( $r1 + 16 , $y1+5 );
    $this->Cell(40, 5, $tva, '', '', "C");
}

function addReference($ref)
{
    $this->SetFont( "Arial", "", 10);
    $length = $this->GetStringWidth( "Références : " . $ref );
    $r1  = 10;
    $r2  = $r1 + $length;
    $y1  = 92;
    $y2  = $y1+5;
    $this->SetXY( $r1 , $y1 );
    $this->Cell($length,4, "Références : " . $ref);
}

function addCols( $tab )
{
    global $colonnes;
    
    $r1  = 10;
    $r2  = $this->w - ($r1 * 2) ;
    $y1  = 100;
    $y2  = $this->h - 50 - $y1;
    $this->SetXY( $r1, $y1 );
    $this->Rect( $r1, $y1, $r2, $y2, "D");
    $this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
    $colX = $r1;
    $colonnes = $tab;
    while ( list( $lib, $pos ) = each ($tab) )
    {
        $this->SetXY( $colX, $y1+2 );
        $this->Cell( $pos, 1, $lib, 0, 0, "C");
        $colX += $pos;
        $this->Line( $colX, $y1, $colX, $y1+$y2);
    }
}

function addLineFormat( $tab )
{
    global $format, $colonnes;
    
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        if ( isset( $tab["$lib"] ) )
            $format[ $lib ] = $tab["$lib"];
    }
}

function lineVert( $tab )
{
    global $colonnes;

    reset( $colonnes );
    $maxSize=0;
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $texte = $tab[ $lib ];
        $longCell  = $pos -2;
        $size = $this->sizeOfText( $texte, $longCell );
        if ($size > $maxSize)
            $maxSize = $size;
    }
    return $maxSize;
}

// add a line to the invoice/estimate
/*    $ligne = array( "REFERENCE"    => $prod["ref"],
                      "DESIGNATION"  => $libelle,
                      "QUANTITE"     => sprintf( "%.2F", $prod["qte"]) ,
                      "P.U. HT"      => sprintf( "%.2F", $prod["px_unit"]),
                      "MONTANT H.T." => sprintf ( "%.2F", $prod["qte"] * $prod["px_unit"]) ,
                      "TVA"          => $prod["tva"] );
*/
function addLine( $ligne, $tab )
{
    global $colonnes, $format;

    $ordonnee     = 10;
    $maxSize      = $ligne;

    reset( $colonnes );
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $longCell  = $pos -2;
        $texte     = $tab[ $lib ];
        $length    = $this->GetStringWidth( $texte );
        $tailleTexte = $this->sizeOfText( $texte, $length );
        $formText  = $format[ $lib ];
        $this->SetXY( $ordonnee, $ligne-1);
        $this->MultiCell( $longCell, 4 , $texte, 0, $formText);
        if ( $maxSize < ($this->GetY()  ) )
            $maxSize = $this->GetY() ;
        $ordonnee += $pos;
    }
    return ( $maxSize - $ligne );
}

function addRemarque($remarque)
{
    $this->SetFont( "Arial", "", 10);
    $length = $this->GetStringWidth( "Remarque : " . $remarque );
    $r1  = 10;
    $r2  = $r1 + $length;
    $y1  = $this->h - 45.5;
    $y2  = $y1+5;
    $this->SetXY( $r1 , $y1 );
    $this->Cell($length,4, "Remarque : " . $remarque);
}

function addCadreTVAs()
{
    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 40;
    $y2  = $y1+20;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $y1+4, $r2, $y1+4);
    $this->Line( $r1+5,  $y1+4, $r1+5, $y2); // avant BASES HT
    $this->Line( $r1+27, $y1, $r1+27, $y2);  // avant REMISE
    $this->Line( $r1+43, $y1, $r1+43, $y2);  // avant MT TVA
    $this->Line( $r1+63, $y1, $r1+63, $y2);  // avant % TVA
    $this->Line( $r1+75, $y1, $r1+75, $y2);  // avant PORT
    $this->Line( $r1+91, $y1, $r1+91, $y2);  // avant TOTAUX
    $this->SetXY( $r1+9, $y1);
    $this->Cell(10,4, "BASES HT");
    $this->SetX( $r1+29 );
    $this->Cell(10,4, "REMISE");
    $this->SetX( $r1+48 );
    $this->Cell(10,4, "MT TVA");
    $this->SetX( $r1+63 );
    $this->Cell(10,4, "% TVA");
    $this->SetX( $r1+78 );
    $this->Cell(10,4, "PORT");
    $this->SetX( $r1+100 );
    $this->Cell(10,4, "TOTAUX");
    $this->SetFont( "Arial", "B", 6);
    $this->SetXY( $r1+93, $y2 - 8 );
    $this->Cell(6,0, "H.T.   :");
    $this->SetXY( $r1+93, $y2 - 3 );
    $this->Cell(6,0, "T.V.A. :");
}

function addCadreEurosFrancs()
{
    $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 40;
    $y2  = $y1+20;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+20,  $y1, $r1+20, $y2); // avant EUROS
    $this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
    $this->Line( $r1+38,  $y1, $r1+38, $y2); // Entre Euros & Francs
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+22, $y1 );
    $this->Cell(15,4, "EUROS", 0, 0, "C");
    $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+42, $y1 );
    $this->Cell(15,4, "FRANCS", 0, 0, "C");
    $this->SetFont( "Arial", "B", 6);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(20,4, "TOTAL TTC", 0, 0, "C");
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(20,4, "ACOMPTE", 0, 0, "C");
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(20,4, "NET A PAYER", 0, 0, "C");
}

// remplit les cadres TVA / Totaux et la remarque
// params  = array( "RemiseGlobale" => [0|1],
//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
//                      "remise"         => value,     // {montant de la remise}
//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
//                  "FraisPort"     => [0|1],
//                      "portTTC"        => value,     // montant des frais de ports TTC
//                                                     // par defaut la TVA = 19.6 %
//                      "portHT"         => value,     // montant des frais de ports HT
//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
//                  "AccompteExige" => [0|1],
//                      "accompte"         => value    // montant de l'acompte (TTC)
//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
//                  "Remarque" => "texte"              // texte
// tab_tva = array( "1"       => 19.6,
//                  "2"       => 5.5, ... );
// invoice = array( "px_unit" => value,
//                  "qte"     => qte,
//                  "tva"     => code_tva );
function addTVAs( $params, $tab_tva, $invoice )
{
    $this->SetFont('Arial','',8);
    
    reset ($invoice);
    $px = array();
    while ( list( $k, $prod) = each( $invoice ) )
    {
        $tva = $prod["tva"];
        @ $px[$tva] += $prod["qte"] * $prod["px_unit"];
    }

    $prix     = array();
    $totalHT  = 0;
    $totalTTC = 0;
    $totalTVA = 0;
    $y = 261;
    reset ($px);
    natsort( $px );
    while ( list($code_tva, $articleHT) = each( $px ) )
    {
        $tva = $tab_tva[$code_tva];
        $this->SetXY(17, $y);
        $this->Cell( 19,4, sprintf("%0.2F", $articleHT),'', '','R' );
        if ( $params["RemiseGlobale"]==1 )
        {
            if ( $params["remise_tva"] == $code_tva )
            {
                $this->SetXY( 37.5, $y );
                if ($params["remise"] > 0 )
                {
                    if ( is_int( $params["remise"] ) )
                        $l_remise = $param["remise"];
                    else
                        $l_remise = sprintf ("%0.2F", $params["remise"]);
                    $this->Cell( 14.5,4, $l_remise, '', '', 'R' );
                    $articleHT -= $params["remise"];
                }
                else if ( $params["remise_percent"] > 0 )
                {
                    $rp = $params["remise_percent"];
                    if ( $rp > 1 )
                        $rp /= 100;
                    $rabais = $articleHT * $rp;
                    $articleHT -= $rabais;
                    if ( is_int($rabais) )
                        $l_remise = $rabais;
                    else
                        $l_remise = sprintf ("%0.2F", $rabais);
                    $this->Cell( 14.5,4, $l_remise, '', '', 'R' );
                }
                else
                    $this->Cell( 14.5,4, "ErrorRem", '', '', 'R' );
            }
        }
        $totalHT += $articleHT;
        $totalTTC += $articleHT * ( 1 + $tva/100 );
        $tmp_tva = $articleHT * $tva/100;
        $a_tva[ $code_tva ] = $tmp_tva;
        $totalTVA += $tmp_tva;
        $this->SetXY(11, $y);
        $this->Cell( 5,4, $code_tva);
        $this->SetXY(53, $y);
        $this->Cell( 19,4, sprintf("%0.2F",$tmp_tva),'', '' ,'R');
        $this->SetXY(74, $y);
        $this->Cell( 10,4, sprintf("%0.2F",$tva) ,'', '', 'R');
        $y+=4;
    }

    if ( $params["FraisPort"] == 1 )
    {
        if ( $params["portTTC"] > 0 )
        {
            $pTTC = sprintf("%0.2F", $params["portTTC"]);
            $pHT  = sprintf("%0.2F", $pTTC / 1.196);
            $pTVA = sprintf("%0.2F", $pHT * 0.196);
            $this->SetFont('Arial','',6);
            $this->SetXY(85, 261 );
            $this->Cell( 6 ,4, "HT : ", '', '', '');
            $this->SetXY(92, 261 );
            $this->Cell( 9 ,4, $pHT, '', '', 'R');
            $this->SetXY(85, 265 );
            $this->Cell( 6 ,4, "TVA : ", '', '', '');
            $this->SetXY(92, 265 );
            $this->Cell( 9 ,4, $pTVA, '', '', 'R');
            $this->SetXY(85, 269 );
            $this->Cell( 6 ,4, "TTC : ", '', '', '');
            $this->SetXY(92, 269 );
            $this->Cell( 9 ,4, $pTTC, '', '', 'R');
            $this->SetFont('Arial','',8);
            $totalHT += $pHT;
            $totalTVA += $pTVA;
            $totalTTC += $pTTC;
        }
        else if ( $params["portHT"] > 0 )
        {
            $pHT  = sprintf("%0.2F", $params["portHT"]);
            $pTVA = sprintf("%0.2F", $params["portTVA"] * $pHT / 100 );
            $pTTC = sprintf("%0.2F", $pHT + $pTVA);
            $this->SetFont('Arial','',6);
            $this->SetXY(85, 261 );
            $this->Cell( 6 ,4, "HT : ", '', '', '');
            $this->SetXY(92, 261 );
            $this->Cell( 9 ,4, $pHT, '', '', 'R');
            $this->SetXY(85, 265 );
            $this->Cell( 6 ,4, "TVA : ", '', '', '');
            $this->SetXY(92, 265 );
            $this->Cell( 9 ,4, $pTVA, '', '', 'R');
            $this->SetXY(85, 269 );
            $this->Cell( 6 ,4, "TTC : ", '', '', '');
            $this->SetXY(92, 269 );
            $this->Cell( 9 ,4, $pTTC, '', '', 'R');
            $this->SetFont('Arial','',8);
            $totalHT += $pHT;
            $totalTVA += $pTVA;
            $totalTTC += $pTTC;
        }
    }

    $this->SetXY(114,266.4);
    $this->Cell(15,4, sprintf("%0.2F", $totalHT), '', '', 'R' );
    $this->SetXY(114,271.4);
    $this->Cell(15,4, sprintf("%0.2F", $totalTVA), '', '', 'R' );

    $params["totalHT"] = $totalHT;
    $params["TVA"] = $totalTVA;
    $accompteTTC=0;
    if ( $params["AccompteExige"] == 1 )
    {
        if ( $params["accompte"] > 0 )
        {
            $accompteTTC=sprintf ("%.2F", $params["accompte"]);
            if ( strlen ($params["Remarque"]) == 0 )
                $this->addRemarque( "Accompte de $accompteTTC Euros exigé à la commande.");
            else
                $this->addRemarque( $params["Remarque"] );
        }
        else if ( $params["accompte_percent"] > 0 )
        {
            $percent = $params["accompte_percent"];
            if ( $percent > 1 )
                $percent /= 100;
            $accompteTTC=sprintf("%.2F", $totalTTC * $percent);
            $percent100 = $percent * 100;
            if ( strlen ($params["Remarque"]) == 0 )
                $this->addRemarque( "Accompte de $percent100 % (soit $accompteTTC Euros) exigé à la commande." );
            else
                $this->addRemarque( $params["Remarque"] );
        }
        else
            $this->addRemarque( "Drôle d'acompte !!! " . $params["Remarque"]);
    }
    else
    {
        if ( strlen ($params["Remarque"]) > 0 )
            $this->addRemarque( $params["Remarque"] );
    }
    $re  = $this->w - 50;
    $rf  = $this->w - 29;
    $y1  = $this->h - 40;
    $this->SetFont( "Arial", "", 8);
    $this->SetXY( $re, $y1+5 );
    $this->Cell( 17,4, sprintf("%0.2F", $totalTTC), '', '', 'R');
    $this->SetXY( $re, $y1+10 );
    $this->Cell( 17,4, sprintf("%0.2F", $accompteTTC), '', '', 'R');
    $this->SetXY( $re, $y1+14.8 );
    $this->Cell( 17,4, sprintf("%0.2F", $totalTTC - $accompteTTC), '', '', 'R');
    $this->SetXY( $rf, $y1+5 );
    $this->Cell( 17,4, sprintf("%0.2F", $totalTTC * EURO_VAL), '', '', 'R');
    $this->SetXY( $rf, $y1+10 );
    $this->Cell( 17,4, sprintf("%0.2F", $accompteTTC * EURO_VAL), '', '', 'R');
    $this->SetXY( $rf, $y1+14.8 );
    $this->Cell( 17,4, sprintf("%0.2F", ($totalTTC - $accompteTTC) * EURO_VAL), '', '', 'R');
}

// add a watermark (temporary estimate, DUPLICATA...)
// call this method first
function watermark( $text )
{
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(203,203,203);
    $this->Rotate(45,55,190);
    $this->Text(55,190,$text);
    $this->Rotate(0);
    $this->SetTextColor(0,0,0);
}

}
?>