<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2003-2004 Christian Ehret (chris@ehret.name)
*  All rights reserved
*
*  This script is part of the ZVS project. The ZVS project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license 
*  from the author is found in LICENSE.txt distributed with these scripts.
*
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

class PDF extends FPDF {
    // -----------------------------------------------------------------------//
    // Définitions de variables                                             //
    // -----------------------------------------------------------------------//
    var $categorie_courante = '';
    var $sous_categorie_courante = '';
    var $B; // <B></B>
    var $U; // <U></U>
    var $I; // <I></I>
    var $HREF; // <A HREF=""></A>
    var $TABLE = array(); // <TABLE></TABLE> 
    // var $TR=array();        // <TR></TR>
    // var $TD=array();        // <TD></TD>
    // var $FONT;                // <FONT SIZE="" COLOR=""></FONT>
    var $UL = 0; // <UL></UL>
    var $OL = 0; // <OL></OL> 
    // var $LI;                // <LI></LI>
    var $contour = array();
    var $fond = array();
    var $num_astuce = 0; 
    // Page header
    function Header()
    {
        global $wwwroot, $request; 
        // Logo
        $this -> Image($wwwroot . 'logo/' . $request -> GetVar('img_hotel_pdfimage', 'session'), 5, 5, '35', '', '', $request -> GetVar('hotel_webpage', 'session'));
        /*
	    //Arial bold 15
	    $this->SetFont('Arial','B',15);
	    //Move to the right
	    $this->Cell(80);
	    //Title
	    $this->Cell(30,10,'Title',1,0,'C');
	    */ 
        // Line break
        $this -> Ln(20);
    } 
    // Page footer
    function Footer()
    {
        global $pagelanguage, $request;
        $pagename = 'Seite '; 
        // Position at 1.5 cm from bottom
        $this -> SetY(-16);
        $this -> SetTextColor(0, 0, 0); 
        // Arial italic 8
        $this -> SetFont('Times', '', 8);
        $this -> Cell(0, 10, $request -> GetVar('hotel_name', 'session') , 0, 0, 'C');
        $this -> Ln(3); 
        // Page number
        $this -> Cell(0, 10, $pagename . $this -> PageNo() . '/{nb}', 0, 0, 'C');
    } 

    function WriteHTML($text)
    {
        $starttag = '<table';
        $endtag = '</table>';
        /*
    	print '<pre>';
    	print '<br><br><br><br>text: '.$text;
    	print '<pre>';
    	*/
        $endtaglen = strlen($endtag);

        $lenorg = strlen($text);

        $tmptext = stristr($text, $starttag); 
        // print '<br><u>temptext</u>: '. $tmptext;
        $tmptext2 = stristr($text, $endtag); 
        // print '<br>temptext2: '.$tmptext2;
        // $lenkey = strlen($keyword);
        if ($tmptext) {
            $lentmp = strlen($tmptext);

            $stop = $lenorg - $lentmp;

            $this -> parseHTML(substr ($text, 0, $stop)); 
            // print '<br><br><u>text to parse: </u>'.substr ( $text, 0, $stop);
            $lentmp2 = strlen($tmptext2);

            $stop2 = $lenorg - $stop - $lentmp2;

            $this -> decomposerTableau(substr($text, $stop, $stop2)); 
            // print '<br><br><u>table: </u>'.substr($text, $stop, $stop2+$endtaglen);
            $resttext = substr($tmptext, $lentmp - $lentmp2 + $endtaglen, $lentmp2 - $endtaglen); 
            // print '<br><br><u>rest: </u>'.$resttext;
            if (strlen($resttext) > 0) {
                $this -> WriteHTML($resttext);
            } 
        } else {
            $this -> parseHTML($text);
        } 
    } 
    // -----------------------------------------------------------------------//
    // Parseur HTML basic                                                   //
    // -----------------------------------------------------------------------//
    // *¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*
    // Moteur central du parseur HTML
    // *¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*¤*
    function parseHTML ($chaine)
    {
        $chaine = str_replace("&#8211;", '-', $chaine);
        $chaine = str_replace("&#8217;", '\'', $chaine);
        $chaine = str_replace("&#8220;", '"', $chaine);
        $chaine = str_replace("&#8221;", '"', $chaine);
        $chaine = str_replace("&nbsp;", ' ', $chaine);
        $contenu = preg_split('/<(.*)>/Ui', $chaine, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($contenu AS $i => $e) {
            if ($i % 2 == 0) {
                // Lien hypertexte à afficher
                if ($this -> HREF) {
                    $this -> PutLink($this -> HREF, $e);
                } 
                // Un bout de texte à afficher
                else {
                    $this -> Write(5, $e);
                } 
            } else {
                // Balise fermante
                if ($e{0} == '/') {
                    $this -> CloseTag(strtoupper(substr($e, 1)));
                } 
                // Balise ouvrante
                else {
                    $prop_temp = split(' ', $e); // Chaque élément de $prop_temp contient 
                    // un attribut + sa valeur
                    // Le premier élément est la balise en elle même
                    $tag = strtoupper(array_shift($prop_temp)); // on récupère la balise
                    $prop = array(); 
                    // On récupère dans un tableau associatif les couples attibut-valeur
                    // $prop['attribut'] = valeur
                    foreach ($prop_temp AS $v) {
                        if (ereg('^(.*)=["\']?([^"\']*)["\']?$', $v, $a3)) {
                            $prop[strtoupper($a3[1])] = $a3[2];
                        } 
                    } 
                    $this -> OpenTag($tag, $prop);
                } 
            } 
        } 
    } 
    // -----------------
    // Ouvre une balise
    // -----------------
    function OpenTag ($tag, $prop)
    {
        switch ($tag) {
            // Gras, italique ou souligné
            case 'B':
            case 'I':
            case 'U':
                $this -> SetStyle($tag, true);
                break; 
            // Lien hypertexte
            case 'A':
                $this -> HREF = $prop['HREF'];
                break; 
            // Retour à la ligne
            case 'BR':
                $this -> ln();
                break; 
            // Police utilisée
            case 'FONT':
                if ($prop['FACE'] == "System" || $prop['FACE'] == "system") {
                    $this -> SetFontSystem(true);
                } 
                break; 
            // Nouvelle liste à puce
            case 'UL':
                $this -> UL++;
                $this -> SetLeftMargin($this -> lMargin + 10);
                break; 
            // Nouvelle liste à puce
            case 'OL':
                $this -> OL++;
                $this -> SetLeftMargin($this -> lMargin + 10);
                break; 
            // Nouvelle puce dans la liste
            case 'LI':
                $this -> WritePuce();
                break; 
            // Image
            case 'IMG':
                if (is_file($prop['SRC']) == true) {
                    $infos = @getimagesize($prop['SRC']);
                    if ($infos[2] == 2 || $infos[2] == 3/*ereg ('.jpg|.png',$prop['SRC'])*/) {
                        if ((297 - $this -> GetY()) < $infos[0] * 0.35)
                            $this -> AddPage();
                        $this -> Image($prop['SRC'], $this -> GetX(), $this -> GetY(), $infos[0] * 0.35, $infos[1] * 0.35);
                    } 
                    $this -> SetY($this -> GetY() + $infos[1] * 0.35);
                    $this -> SetX($this -> GetX() + $infos[0] * .35);
                } 
                break; 
            // Paragraphe
            case 'P':
                $this -> ln();
                break; 
            // Barre de séparation entre la description de l'astuce et l'astuce elle même
            case 'BARRE':
                $this -> ln();
                $this -> SetLineWidth(0.5); 
                // $this->SetDrawColor(0,0,0);
                $this -> Line((210-100) / 2, $this -> GetY(), (210-100) / 2 + 100, $this -> GetY());
                break; 
            // Indentation d'un bloc
            case 'blockquote':
                $this -> ln();
                $this -> SetLeftMargin($this -> lMargin + 10);
                break;
        } 
    } 
    // -----------------
    // Ferme une balise
    // -----------------
    function CloseTag($tag)
    {
        switch ($tag) {
            // Gras, italique ou souligné
            case 'B':
            case 'I':
            case 'U':
                $this -> SetStyle($tag, false);
                break; 
            // Lien hypertexte
            case 'A':
                $this -> HREF = '';
                break; 
            // Police utilisée
            case 'FONT':
                $this -> SetFontSystem(false);
                break; 
            // Fin d'une liste à puce
            case 'UL':
                $this -> UL--;
                $this -> SetLeftMargin($this -> lMargin-10);
                $this -> Ln();
                break; 
            // Fin d'une liste à puce
            case 'OL':
                $this -> OL--;
                $this -> SetLeftMargin($this -> lMargin-10);
                $this -> Ln();
                break; 
            // Indentation d'un bloc
            case 'blockquote':
                $this -> ln();
                $this -> SetLeftMargin($this -> lMargin-10);
                break;
        } 
    } 
    // --------------------------------------------
    // Gère les balises gras, italique et souligné
    // --------------------------------------------
    function SetStyle ($tag, $enable)
    {
        $this -> $tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this -> $s > 0) {
                $style .= $s;
            } 
        } 
        $this -> SetFont('', $style);
    } 

    function PutTable($URL, $txt)
    { 
        // Put a table
        $this -> decomposerTableau($txt, '');
    } 

    function PutLink($URL, $txt)
    { 
        // Put a hyperlink
        $this -> SetTextColor(0, 0, 255);
        $this -> SetStyle('U', true); 
        // if($txt != 'zum Seitenanfang') {
        $this -> Write(5, $txt, $URL); 
        // }
        $this -> SetStyle('U', false);
        $this -> SetTextColor(0);
    } 
    // --------------------------------------------------------
    // Gère les affichages des clés du registre et des valeurs
    // --------------------------------------------------------
    function SetFontSystem ($enable)
    {
        if ($enable == true)
            $this -> SetFont('courier', 'B', 10);
        else
            $this -> SetFont('arial', '', 10);
    } 
    // -----------------------
    // Gère les listes à puce
    // -----------------------
    function WritePuce()
    {
        $this -> ln();
        $this -> cell(10);
        $this -> SetFont('', 'B', 14); 
        // Niveau 1 d'indentation : puce ronde remplie
        if ($this -> UL == 1) {
            $this -> SetX($this -> GetX()-20);
            $this -> Cell(10, 5, chr(149), 0, 0, 'C');
        } 
        // Niveau 2 d'indentation : contours puce ronde
        elseif ($this -> UL == 2) {
            $this -> SetFont('', 'B', 7);
            $this -> SetX($this -> GetX()-20);
            $this -> Cell(10, 5, chr(111), 0, 0, 'C');
            $this -> SetFont('', '', 10);
        } 
        // Niveau 3 et + d'indentation : puce carrée remplie
        elseif ($this -> UL >= 3) {
            $this -> SetFont('zapfdingbats', '', 6);
            $this -> SetX($this -> GetX()-20);
            $this -> Cell(10, 5, chr(110), 0, 0, 'C');
            $this -> SetFont('arial', '', 10);
        } 
        $this -> SetFont('', '', 10);
    } 

    function decomposerTableau ($tab_string) // $tab_string est le code html du tableau, $path est une chaine de caractères contenant le chemin du fichier contenant le code du tableau html
    {
        // echo $tab_string;
        $this -> Ln(5);
        $l = 0;
        $max_l = 0; //line?
        $c = 0;
        $max_c = 0; //cell?
        $tab_string = eregi_replace('</td>', '', $tab_string);
        $tab_string = eregi_replace('</tr>', '', $tab_string);
        $tab_string = eregi_replace('</table>', '', $tab_string);
        $tab_split = preg_split('/<(t.*)>/Ui', $tab_string, -1, PREG_SPLIT_DELIM_CAPTURE); //séparer balises et texte associé aux balises
         
        // TEST
        /*
				for ( $tst = 0; $tst < count($tab_split); $tst++ ) {
					echo $tst.': ';
					echo htmlentities ($tab_split[$tst]).'<br>';
				}
				*/
        // TESTENDE
        for ($i = 1; $i < count($tab_split); $i += 2) {
            // echo htmlentities ($tab_split[$i]).$tab_split[$i+1].'<br>';
            // nouvelle ligne
            if (ereg ('tr', strtolower($tab_split[$i]))) {
                $l ++;
                $c = 0;
                if ($l > $max_l)
                    $max_l = $l;
            } 
            // nouvelle cellule
            if (ereg ('td', strtolower($tab_split[$i]))) {
                $c ++;
                if ($c > $max_c)
                    $max_c = $c;
                if ($tab_split[$i + 1])
                    $tab[$l][$c]["texte"] = $tab_split[$i + 1];

                $att = preg_split('/ |(=")|"/', $tab_split[$i], -1, PREG_SPLIT_NO_EMPTY);
                for ($j = 1; $j < count($att); $j += 2)
                $tab[$l][$c][strtolower($att[$j])] = $att[$j + 1] ;
            } 
        } 
        // TEST
        /*
					echo "max_c: $max_c\n";
					echo "c: $c\n";
					echo "max_l: $max_l\n";
					echo "l: $l\n";
				*/
        // TESTENDE
        // analyse colspan & rowspan
        for ($l = 1; $l <= $max_l; $l++) {
            for ($c = 1; $c <= $max_c; $c++) {
                if ($tab[$l][$c]["colspan"]) {
                    // echo $tab[$l][$c]["colspan"];
                    for ($j = count($tab[$l]); $j >= $c + 1; $j--) {
                        $tab[$l][$j + intval($tab[$l][$c]["colspan"])-1] = $tab[$l][$j]; 
                        // echo intval($tab[$l][$c]["colspan"]);
                        $tab[$l][$j] = $tab[0][0]; //tab[0][0] est vide, on initialise ainsi la cellule
                    } 
                } 
                if ($tab[$l][$c]["rowspan"]) {
                    for ($k = 1; $k < intval($tab[$l][$c]["rowspan"]); $k++) {
                        for ($j = $max_c-1; $j >= $c; $j--) {
                            $tab[$l + $k][$j + 1] = $tab[$l + $k][$j];
                            $tab[$l + $k][$j] = $tab[0][0];
                        } 
                    } 
                } 
            } 
        } 
        // TEST
        /*
        	print'<pre>';
		print_r($tab);
		print'</pre>';
*/
        // TESTENDE
        $maxcols = 0;
        $colwidth = array();
        $rows = 0; 
        // iterate rows
        for ($i = 1; $i <= count($tab); ++$i) {
            // iterate columns
            for ($j = 1; $j <= count($tab[$i]); ++$j) {
                // get number of columns
                if ($maxcols <= $j) {
                    $maxcols = $j;
                } 
                // get max width of columns
                if ($colwidth[$j] < $tab[$i][$j][width]) {
                    $colwidth[$j] = $tab[$i][$j][width];
                } 
            } 
        } 

        $rows = $i;
        /*       
        print 'maxcols: '.$maxcols.'<br>';
        
        for ($i = 1; $i <= $maxcols; ++$i) {
        
        	print $i.' column width: '.$colwidth[$i].'<br>';
        	
        }
*/ 
        // actual X position;
        $xorg = $this -> GetX();
        $pagenr = 1; 
        // rows
        for ($i = 1; $i <= $rows; ++$i) {
            $ytop = $this -> GetY(); 
            // columns
            for ($j = 1; $j <= count($tab[$i]); ++$j) {
                $pagenr = $this -> PageNo();

                if ($ytop < $ybottom) {
                    $ybottomold = $ybottom;
                    $this -> SetY($ytop);
                } 

                $x = $this -> GetX(); 
                // no colspan
                if (!isset($tab[$i][$j][colspan])) {
                    $sum = $x + $colwidth[$j] * 0.35; 
                    // colspan
                } else {
                    $this -> SetY($ytop);
                    $sum = $x + $colwidth[$j] * 0.35;
                    for ($k = 1; $k <= $tab[$i][$j][colspan]; ++$k) {
                        $sum += $colwidth[$j + $k] * 0.35;
                    } 
                } 

                $rightmargin = 210 - $sum;

                if ($rightmargin < 0) {
                    $rightmargin = 10;
                } 

                $this -> SetRightMargin($rightmargin); 
                // $this->parseHTML($tab[$i][$j][texte]);
                $this -> WriteHTML($tab[$i][$j][texte]);

                if ($pagenr < $this -> PageNo()) {
                    $ytop = $this -> GetY();
                    $this -> SetY($ytop);
                } 

                $this -> SetLeftMargin($x + $colwidth[$j] * 0.35 + 2);
                $ybottom = $this -> GetY();

                if ($ybottomold > $ybottom && $pagenr >= $this -> PageNo()) {
                    $this -> SetY($ybottomold);
                    $ybottomold = 0;
                } 
            } 
            // $this->Ln(2.5);
            $this -> Ln(5);
            $this -> SetLeftMargin($xorg);
            $this -> SetX($xorg);
        } 

        /*
        //test pour savoir si l'on doit faire un saut de page avant d'afficher le tableau
        $hauteur_tableau = 0;
        for ( $l = 1; $l <= $max_l; $l++ )
            $hauteur_tableau += $tab[$l][0];

        if ( $this->GetY() + 2*$this->GetFontSize()*$hauteur_tableau > 267/0.35 )
        //if ( $this->GetY() + 2*$this->GetFontSize()*$hauteur_tableau > 267/0.2 )
        {

            $this->AddPage();
            $this->AcceptPageBreak();
        }
        $this->AddPage();

        $x0 = $this->GetX();
        for ( $l = 1; $l <= $max_l; $l ++ )
        {

            $x1 = $x0;
            $y1 = $this->GetY();
            $this->SetLeftMargin( $x1 );
            $this->SetX( $x1 );
            for ( $c = 1; $c <= $max_c; $c ++)
            {
                //$this->SetDrawColor(intval('F6',16), intval('E8',16), intval('C3',16));

                //$this->SetLineWidth(0);
                //echo 207*0.35 - ($x1 + $tab[$l][$c]["largeur"]).'<BR>';
                
                $this->SetRightMargin( 210*0.35 - ($x1 + $tab[$l][$c]["largeur"]*0.35) );
                //$this->SetRightMargin( 210*0.2 - ($x1 + $tab[$l][$c]["largeur"]*0.2) );

                if ( $tab[$l][$c]["texte"] )
                {
                    $this->WriteHTML($tab[$l][$c]["texte"]);
                  //  $this->Rect( $x1, $y1, $this->GetFontSize()*$tab[$l][$c]["largeur"], 0.35*2*$this->GetFontSize()*$tab[$l][$c]["hauteur"] );
                }
                $x1 += $this->GetFontSize()*$tab[0][$c]*0.35;
                //$x1 += $this->GetFontSize()*$tab[0][$c]*0.2;
                
                $this->SetLeftMargin( $x1 );
                $this->SetX( $x1 );
                $this->SetY( $y1 );
            }

            $this->Ln(2*$this->GetFontSize()*($tab[$l][0])*0.35);
            //$this->Ln(2*$this->GetFontSize()*($tab[$l][0])*0.2);
        }
        $this->SetLeftMargin( $x0 );
        
        //$this->SetRightMargin( 10/0.35 );
        $this->SetRightMargin( 10/0.2 );
  */
    } 

    function NbLines($w, $txt)
    {
        $nl = 1;

        $chaine = '';
        $split = preg_split('/ /U', $txt, -1, PREG_SPLIT_NO_EMPTY); //on découpe à chaque espace
        for ($a = 0; $a < count($split); $a++) {
            if ($split[$a] == '¿' || $split[$a] == '¿1') {
                $nl ++;
                $chaine = '';
            } else {
                $chaine .= ' ' . $split[$a] . ' ';
                if ($this -> GetStringWidth($chaine) > $w) {
                    $nl ++;
                    $chaine = $split[$a];
                } 
            } 
        } 
        return $nl;
    } 
    // -----------------------------------------------------------------------//
    // Fonctions diverses                                                   //
    // -----------------------------------------------------------------------//
    function GetFontSize ()
    {
        return $this -> FontSizePt * .35;
    } 
    // --------------------------------------------------------------------
    // Supprime les entitees HTML en les remplacant par leur equivalent le
    // plus proche : par exemple, &eacute; => e.
    // --------------------------------------------------------------------
    function simplifie_HTML($texte)
    {
        $spec[192] = "A";
        $spec[224] = "a";
        $spec[193] = "A";
        $spec[225] = "a";
        $spec[194] = "A";
        $spec[226] = "a";
        $spec[195] = "A";
        $spec[227] = "a";
        $spec[196] = "A";
        $spec[228] = "a";
        $spec[197] = "A";
        $spec[229] = "a";
        $spec[198] = "A";
        $spec[230] = "a";
        $spec[199] = "C";
        $spec[231] = "c";
        $spec[200] = "E";
        $spec[232] = "e";
        $spec[201] = "E";
        $spec[233] = "e";
        $spec[202] = "E";
        $spec[234] = "e";
        $spec[203] = "E";
        $spec[235] = "e";
        $spec[204] = "I";
        $spec[236] = "i";
        $spec[205] = "I";
        $spec[237] = "i";
        $spec[206] = "I";
        $spec[238] = "i";
        $spec[207] = "I";
        $spec[239] = "i";
        $spec[208] = "E";
        $spec[240] = "e";
        $spec[209] = "N";
        $spec[241] = "n";
        $spec[210] = "O";
        $spec[242] = "o";
        $spec[211] = "O";
        $spec[243] = "o";
        $spec[212] = "O";
        $spec[244] = "o";
        $spec[213] = "O";
        $spec[245] = "o";
        $spec[214] = "O";
        $spec[246] = "o";
        $spec[215] = "t";
        $spec[247] = "d";
        $spec[216] = "O";
        $spec[248] = "o";
        $spec[217] = "U";
        $spec[249] = "u";
        $spec[218] = "U";
        $spec[250] = "u";
        $spec[219] = "U";
        $spec[251] = "u";
        $spec[220] = "U";
        $spec[252] = "u";
        $spec[221] = "Y";
        $spec[253] = "y";
        $spec[222] = "T";
        $spec[254] = "t";
        $spec[223] = "s";
        $spec[255] = "y";

        while (list($iso, $entite) = each($spec)) {
            $texte = ereg_replace("&#$iso;", $entite, $texte);
        } 
        $texte = preg_replace("/&(.).{2,6};/", "\\1", $texte);
        return $texte;
    } 
    // ---------------------------------------------------------------
    // Convertit une couleur au format hexadécimal en composantes RVB
    // ---------------------------------------------------------------
    function HexToRVB ($hex)
    {
        $rvb[0] = hexdec(substr($hex, 0, 2));
        $rvb[1] = hexdec(substr($hex, 2, 2));
        $rvb[2] = hexdec(substr($hex, 4, 2));
        return $rvb;
    } 
    // -------------------------------------------
    // Convertit les couleurs de base du document
    // -------------------------------------------
    function TransCouleurs()
    {
        $this -> contour = $this -> HexToRVB('09999f');
        $this -> fond = $this -> HexToRVB('b0d0ef');
    } 
    /*
     function SetStyle($tag,$enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}
   */

} 

?>
