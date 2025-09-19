
<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.abfragetyp.php");
include_once("class.lookuptype.php");
include_once("class.lookup.php");

class Suchabfrage {

/** Ext. Klassen *******/ 
  private $db; 
  private $info; 
/** Eigenschaften *******/  
  public $Beschreibung=''; 
  public $Ansicht=''; 
  public $AnsichtGruppe=''; // "Noten" oder "Schüler" 
  public $AnsichtEbene=''; // 
  public $edit_table=''; // Org. Tabellen-Name. Wird für den "Bearbeiten"-Link in der Ergebnistabelle benötigt 
  public $showResultsetSammlungNoten=false; 
  public $showResultsetSammlungMaterial=false; 
  public $showResultsetSchuler=false; 


  public $AnzahlFilter1=0; // Sammlung 
  public $AnzahlFilter2=0; // Material 

  public $AnsichtEbene1=''; // Obere Ergebnistabelle  Sammlung / Musikstück / Satz  (Noten) 
  public $AnsichtEbene2=''; // Untere Ergebnistabelle Sammung  / Material 
  
  public $txtTest=''; 
  public $printSQL=false; 

/** Filter-Parameter *******/
  public $Suchtext=''; 

  public $StandortID=''; 
  public $VerlagID='';   

   public $Linktypen=[];   

  public $KomponistID='';
  public $GattungID='';
  public $EpocheID='';  

  public $SchuelerID=''; 
  public $StatusID=''; 

  public $Besetzungen_all=[]; 
  public $Besetzungen_selected=[]; 
  public $Besetzungen_not_selected=[]; 
  public $besetzung_check_include=false; // Einschluss-Suche aktiviert 
  public $besetzung_check_exclude=false; // Ausschluss-Suche aktiviert 

  public $Verwendungszwecke=[]; 


  public $InstrumentSchwierigkeitsgrade=[]; // zu Filter Satz  

  public $MaterialtypID='';  

  public $InstrumentID_Material=''; 
  public $Schwierigkeitsgrade_Material=[];
  
  public $InstrumentID_Schueler='';  
  public $Schwierigkeitsgrade_Schueler=[];
  
  public $AllLookupTypes=[]; 

  public $printSammlung=false; // Ergebnistabelle "Sammlung" anzeigen 
  public $printMaterial=false; // Ergebnistabelle "Material" anzeigen 


/** Methoden ********/  

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

   public function setAnsicht($Ansicht) {
    // Ansicht = die vom Anwender im Suchformular gewählte Ansicht  

    $this->Ansicht=$Ansicht;     

    $this->Beschreibung.='<b>Ansicht: '.$this->Ansicht.'</b><br>'; 

    switch ($this->Ansicht){

      case 'Sammlung':        
        $this->AnsichtGruppe='Noten';      // XXXX Parameter notwendig ?

        $this->AnsichtEbene1='Sammlung'; 
        $this->AnsichtEbene2='Sammlung';         

        break;         


      case 'Sammlung erweitert':
        $this->AnsichtGruppe='Noten'; 

        $this->AnsichtEbene1='Musikstueck'; 
        $this->AnsichtEbene2='Material';            
        break;   


      case 'Sammlung erweitert 2':
        $this->AnsichtGruppe='Noten'; 

        $this->AnsichtEbene1='Satz'; 
        $this->AnsichtEbene2='Material';            
        break;   


      case 'Sammlung erweitert 3':
        $this->AnsichtGruppe='Noten'; 

        $this->AnsichtEbene1='Satz'; 
        $this->AnsichtEbene2='Material';            
        break;   




      // case 'Sammlung Links': 
      //   $this->AnsichtGruppe='Noten';         
      //   $this->showResultsetSammlungNoten=true; 
      //   $this->showResultsetSammlungMaterial=false; 
      //   $this->showResultsetSchuler=false;                  
       
      //   break;   


      // case 'Musikstueck': 
      //   $this->AnsichtGruppe='Noten';         
      //   $this->showResultsetSammlungNoten=true;   
      //   $this->showResultsetSammlungMaterial=false; 
      //   $this->showResultsetSchuler=false;               
      //   break;   

      // case 'Satz Schueler': 
      //   $this->AnsichtGruppe='Noten';         
      //   $this->showResultsetSammlungNoten=true;    
      //   $this->showResultsetSammlungMaterial=false; 
      //   $this->showResultsetSchuler=false;              
      //   break;   


      // case 'Satz Besonderheiten':
      //   $this->AnsichtGruppe='Noten';         
      //   $this->showResultsetSammlungNoten=true;   
      //   $this->showResultsetSammlungMaterial=false; 
      //   $this->showResultsetSchuler=false;               
      //   break;   

      // case 'Satz':         
      //   $this->AnsichtGruppe='Noten';         
      //   $this->showResultsetSammlungNoten=true; 
      //   $this->showResultsetSammlungMaterial=false; 
      //   $this->showResultsetSchuler=false;                 
      //   break;   
                    

      // case 'Material':
      //   $this->AnsichtGruppe='Noten';         
      //   $this->showResultsetSammlungNoten=false; 
      //   $this->showResultsetSammlungMaterial=true; 
      //   $this->showResultsetSchuler=false;                
      //   break;   


      // case 'Material_erweitert':        
      //   $this->AnsichtGruppe='Noten';         
      //   $this->showResultsetSammlungNoten=false; 
      //   $this->showResultsetSammlungMaterial=true; 
      //   $this->showResultsetSchuler=false;          
      //   break;   
  
      // case 'Schueler':
      //   $this->AnsichtGruppe='Schueler';         
      //   $this->showResultsetSammlungNoten=false; 
      //   $this->showResultsetSammlungMaterial=false; 
      //   $this->showResultsetSchuler=true;   

      //   break;   

      // case 'Schueler erweitert':
      //   $this->AnsichtGruppe='Schueler';         
      //   $this->showResultsetSammlungNoten=false; 
      //   $this->showResultsetSammlungMaterial=false; 
      //   $this->showResultsetSchuler=true;   

      //   break;                        
        
      }
      $this->Beschreibung.='<br>'; 
  }
 
  private function getSQL_Sammlung_Noten() {
          // XXXX

    $strTmp=''; 

    // SELECT 
    switch ($this->Ansicht){ // Ebene Sammlung 

      case 'Sammlung': 
        $strTmp.="SELECT sammlung.ID
                        , sammlung.Name as Sammlung
                        , standort.Name as Standort                  
                        , verlag.Name as Verlag
                        , sammlung.Bemerkung 
                        , v_sammlung_lookuptypes.LookupList as `Besonderheiten` ".PHP_EOL;
        $this->edit_table='sammlung';                      
        break; 

      case 'Sammlung erweitert': // Ebene Sammlung / Musikstück   

        $strTmp.="SELECT musikstueck.ID
        , standort.Name as Standort        
        , sammlung.Name as Sammlung
        , musikstueck.Nummer as Nr
        , musikstueck.Name as Musikstueck
        , materialtyp.Name as Materialtyp        
        , komponist.Name as Komponist
        , v_musikstueck_besetzungen.Besetzungen 
        , v_musikstueck_verwendungszwecke.Verwendungszwecke 
        , GROUP_CONCAT(DISTINCT satz.Nr order by satz.Nr SEPARATOR ', ') Saetze         
        , musikstueck.Bearbeiter 
        , gattung.Name as Gattung 
        , epoche.Name as Epoche
        , v_musikstueck_lookuptypes.LookupList2 as `Musikstueck Besonderheiten`  
        , musikstueck.Bemerkung ".PHP_EOL;   

          $this->edit_table='musikstueck'; 
          break; 


      case 'Sammlung erweitert 2':  // Ebene Sammlung / Musikstück / Satz 
        $strTmp.="SELECT satz.ID
            , standort.Name as Standort        
            , sammlung.Name as Sammlung
            -- , musikstueck.Nummer as MNr
            , musikstueck.Name as Musikstueck
            , komponist.Name as Komponist                  
            , satz.Nr as Nr
            , satz.Name as Satz 
            , satz.Tempobezeichnung            
            , v_satz_instrumente_schwierigkeitsgrade.Schwierigkeitsgrade           
            , v_satz_lookuptypes.LookupList2 as `Satz Besonderheiten`                   
            , satz.Orchesterbesetzung 
            , satz.Bemerkung ".PHP_EOL;   

          $this->edit_table='satz';  

          break;   

            
      case 'Sammlung erweitert 3': // Ebene Sammlung / Musikstück / Satz + Schüler 

        $strTmp.="SELECT satz.ID
            , standort.Name as Standort
            , komponist.Name as Komponist  
            , CONCAT(
                'Sammlung: ',sammlung.Name, 
                ', Musikstück: ', musikstueck.Nummer, ' ', musikstueck.Name, 
                ', Satz: ', satz.Nr, '  ', satz.Name) `Sammlung / Musikstueck / Satz` 
            , v_satz_instrumente_schwierigkeitsgrade.Schwierigkeitsgrade           
            , v_satz_lookuptypes.LookupList2 as `Satz Besonderheiten`                   
            -- , satz.Orchesterbesetzung 
            -- , satz.Bemerkung 
            , GROUP_CONCAT(DISTINCT concat(schueler.Name, ' (Status: ', COALESCE(status.Name,''), ')')  ORDER BY schueler.Name SEPARATOR '<br > ') Schueler  ".PHP_EOL;   

          $this->edit_table='satz';  

        break;   
                


      // case 'Sammlung Links': // XXXX 
      //   $strTmp.="SELECT sammlung.ID
      //   , standort.Name as Standort
      //   , sammlung.Name as Sammlung
      //   , links.LinkText             
      //   , links.LinkTyp ".PHP_EOL; 

      //   $this->edit_table='sammlung';  
        
      //   break;   


      }
                  
      $strTmp.="FROM
        sammlung 
        LEFT JOIN standort on sammlung.StandortID = standort.ID    
        LEFT JOIN verlag on sammlung.VerlagID = verlag.ID
        LEFT JOIN v_links as links on links.SammlungID = sammlung.ID
        LEFT JOIN v_sammlung_lookuptypes as v_sammlung_lookuptypes on v_sammlung_lookuptypes.SammlungID = sammlung.ID 
        LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID 
        LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
        LEFT JOIN v_musikstueck_besetzungen ON v_musikstueck_besetzungen.MusikstueckID=musikstueck.ID 
        LEFT JOIN v_musikstueck_verwendungszwecke ON v_musikstueck_verwendungszwecke.MusikstueckID=musikstueck.ID 
        LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
        LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID  
        LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
        LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID
        LEFT JOIN v_satz_instrumente_schwierigkeitsgrade ON v_satz_instrumente_schwierigkeitsgrade.SatzID = satz.ID 
        LEFT JOIN materialtyp on materialtyp.ID = musikstueck.MaterialtypID         
        ".PHP_EOL;

      switch($this->Ansicht) {
        case 'Sammlung erweitert': // Musikstück- Ebene 
          $strTmp.="LEFT JOIN v_musikstueck_lookuptypes on v_musikstueck_lookuptypes.MusikstueckID = musikstueck.ID " . PHP_EOL;     
          break; 
                
        case 'Sammlung erweitert 2': // Satz- Ebene 
        case 'Sammlung erweitert 3': // Satz- Ebene 
          $strTmp.="LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID " . PHP_EOL;     
          break; 


      }  

      
      if ($this->Ansicht=='Sammlung erweitert 3') {

        $strTmp.="
              LEFT JOIN schueler_satz ON schueler_satz.SatzID = satz.ID ".PHP_EOL;
              if($this->SchuelerID!='') { 
                $strTmp.="AND schueler_satz.SchuelerID=".$this->SchuelerID." " . PHP_EOL;        
              }
              elseif($this->SchuelerID!='' & $this->StatusID!='') {
                $strTmp.="AND schueler_satz.SchuelerID=".$this->SchuelerID." AND StatusID=".$this->StatusID." " . PHP_EOL;        
              }
              elseif($this->SchuelerID=='' & $this->StatusID!='') {      
                $strTmp.="AND schueler_satz.StatusID=".$this->StatusID." ".PHP_EOL; 
              }                   

        $strTmp.="LEFT JOIN schueler on schueler.ID = schueler_satz.SchuelerID
                  LEFT JOIN status ON status.ID = schueler_satz.StatusID  ".PHP_EOL;
      }


    $strTmp.="WHERE 1=1 ".PHP_EOL;
       
    if ($this->Suchtext!='') {
      $strTmp.="AND (sammlung.Name LIKE '%".$this->Suchtext."%' OR  
                  sammlung.Bemerkung LIKE '%".$this->Suchtext."%' OR                              
                  musikstueck.Name LIKE '%".$this->Suchtext."%' OR                              
                  musikstueck.Opus LIKE '%".$this->Suchtext."%' OR
                  musikstueck.Bearbeiter LIKE '%".$this->Suchtext."%' OR 
                  musikstueck.Bemerkung LIKE '%".$this->Suchtext."%' OR                   
                  v_musikstueck_besetzungen.Besetzungen LIKE '%".$this->Suchtext."%' OR 
                  v_musikstueck_verwendungszwecke.Verwendungszwecke LIKE '%".$this->Suchtext."%' OR 
                  komponist.Name  LIKE '%".$this->Suchtext."%' OR 
                  epoche.Name  LIKE '%".$this->Suchtext."%' OR    
                  gattung.Name  LIKE '%".$this->Suchtext."%' OR                 
                  satz.Name LIKE '%".$this->Suchtext."%' OR
                  satz.Tempobezeichnung LIKE '%".$this->Suchtext."%' OR
                  satz.Orchesterbesetzung LIKE '%".$this->Suchtext."%' OR 
                  satz.Bemerkung LIKE '%".$this->Suchtext."%' OR 
                  satz_erprobt.Bemerkung LIKE '%".$this->Suchtext."%' 
                  ) ". PHP_EOL;           
    }
    if($this->SchuelerID!='' & $this->StatusID=='') { 
      // 1) Nur Schüler ausgewählt 
      $strTmp.="AND satz.ID IN (SELECT SatzID from schueler_satz where SchuelerID=".$this->SchuelerID.") " . PHP_EOL;        
    }
    elseif($this->SchuelerID!='' & $this->StatusID!='') {
      //  2) Schüler + Status ausgewählt 
      $strTmp.="AND satz.ID IN (SELECT SatzID from schueler_satz where SchuelerID=".$this->SchuelerID." AND StatusID=".$this->StatusID.") " . PHP_EOL;        
    }
    elseif($this->SchuelerID=='' & $this->StatusID!='') {
      // 3) Nur Status ausgewählt         
      $strTmp.="AND satz.ID IN (SELECT SatzID FROM schueler_satz WHERE StatusID=".$this->StatusID.") ".PHP_EOL; 
    }        
    if ($this->StandortID!='') {
      $strTmp.="AND sammlung.StandortID=".$this->StandortID." ". PHP_EOL; 
    }
    if ($this->VerlagID!='') {
      $strTmp.="AND sammlung.VerlagID=".$this->VerlagID." ". PHP_EOL; 
    }
    if (count($this->Linktypen) > 0) {
      $strTmp.='AND links.LinktypeID IN ('.implode(',', $this->Linktypen).') '.PHP_EOL; 
    }          
    if ($this->KomponistID!='') {
      $strTmp.="AND musikstueck.KomponistID=".$this->KomponistID." ". PHP_EOL; 
    }  
    if (count($this->Besetzungen_selected) > 0 & !$this->besetzung_check_include) {
      $strTmp.="AND musikstueck.ID IN (SELECT MusikstueckID FROM musikstueck_besetzung WHERE BesetzungID IN (".implode(',', $this->Besetzungen_selected).")) ".PHP_EOL; 
    } elseif (count($this->Besetzungen_selected) > 0 & $this->besetzung_check_include) {
      for ($i = 0; $i < count($this->Besetzungen_selected); $i++) {
        $strTmp.="AND musikstueck.ID IN (SELECT MusikstueckID FROM musikstueck_besetzung WHERE BesetzungID=".$this->Besetzungen_selected[$i].") ". PHP_EOL; 
      }   
    }
    if (count($this->Besetzungen_selected) > 0 & count($this->Besetzungen_not_selected) >0 & $this->besetzung_check_exclude) {
      $strTmp.="AND musikstueck.ID NOT IN (SELECT DISTINCT MusikstueckID from musikstueck_besetzung WHERE BesetzungID IN (".implode(',', $this->Besetzungen_not_selected)."))".PHP_EOL; 
    }
    if (count($this->Verwendungszwecke) > 0) {
      $strTmp.="AND musikstueck.ID IN (SELECT MusikstueckID FROM musikstueck_verwendungszweck WHERE VerwendungszweckID IN (".implode(',', $this->Verwendungszwecke).")) ".PHP_EOL; 
    }
    if ($this->GattungID!='') {
      $strTmp.="AND musikstueck.GattungID=".$this->GattungID." ". PHP_EOL; 
    }        
    if ($this->EpocheID!='') {
      $strTmp.="AND musikstueck.EpocheID=".$this->EpocheID." ". PHP_EOL; 
    }
    if ($this->MaterialtypID!='') {
      $strTmp.="AND musikstueck.MaterialtypID=".$this->MaterialtypID." ". PHP_EOL; 
    }    
    if (count($this->InstrumentSchwierigkeitsgrade) > 0) { // Satz InstrumentXSchwierigkeitsgrad 
      $strTmp.=$this->getSQL_FilterInstrumentSchwierigkeitsgrad($this->InstrumentSchwierigkeitsgrade).PHP_EOL;
    }
    // if ($this->MaterialtypID!='') {
    //   $strTmp.="AND material.MaterialtypID =".$this->MaterialtypID." ".PHP_EOL; 
    // }        
    // if ($this->InstrumentID_Material!='') {
    //   $strTmp.="AND material.ID IN (SELECT MaterialID FROM material_schwierigkeitsgrad WHERE InstrumentID=".$this->InstrumentID_Material.") ".PHP_EOL; 
    // }       
    // if (count($this->Schwierigkeitsgrade_Material) > 0) {
    //   $strTmp.='AND material.ID IN (SELECT MaterialID FROM material_schwierigkeitsgrad WHERE SchwierigkeitsgradID IN ('.implode(',', $this->Schwierigkeitsgrade_Material).')) '.PHP_EOL; 
    // }
    if (count($this->AllLookupTypes) > 0) {
      $strTmp.=$this->getSQL_FilterLookups('sammlung'); 
      $strTmp.=$this->getSQL_FilterLookups('satz');           
    }  
    
    switch ($this->AnsichtEbene1){
      case 'Sammlung':
        $strTmp.="GROUP BY sammlung.ID ".PHP_EOL;               
      break; 
      case 'Musikstueck':
        $strTmp.="GROUP BY musikstueck.ID ".PHP_EOL;                     
      break;         
      case 'Satz':
        $strTmp.="GROUP BY satz.ID ".PHP_EOL;                    
        break;                                 
    }

    // ORDER BY 
    switch ($this->AnsichtEbene1){
      case 'Sammlung':
        $strTmp.="ORDER BY sammlung.Name ".PHP_EOL;                     
      break; 
      case 'Musikstueck':
        $strTmp.="ORDER BY sammlung.Name, musikstueck.Nummer".PHP_EOL;                     
      break;         
      case 'Satz':
        $strTmp.="ORDER BY sammlung.Name, musikstueck.Nummer, satz.Nr ".PHP_EOL;                    
      break;                  
    }

    return $strTmp; 

  }

  private function getSQL_Sammlung_Material() {

    $strTmp=''; 

    switch ($this->Ansicht) 
    {
      case 'Sammlung': 
        $strTmp.="SELECT sammlung.ID
                , sammlung.Name as Sammlung
                , standort.Name as Standort                  
                , verlag.Name as Verlag
                , sammlung.Bemerkung 
                , v_sammlung_lookuptypes.LookupList as `Besonderheiten` ".PHP_EOL;        

        $this->edit_table='sammlung'; 
        
        break;  

      case 'Sammlung erweitert': 
      case 'Sammlung erweitert 2': 

        $strTmp.="select material.ID
        , sammlung.Name as Sammlung
        , material.Name as Material 
        , material.Bemerkung as `Material Bemerkung` 
        , materialtyp.Name as Materialtyp
        , v_material_instrumente_schwierigkeitsgrade.Schwierigkeitsgrade   
        , v_material_lookuptypes.LookupList2 as Besonderheiten 
         ".PHP_EOL;    

        $this->edit_table='material'; 

        break;  

      case 'Sammlung erweitert 3': 


        $strTmp.="select material.ID
        , sammlung.Name as Sammlung
        , material.Name as Material 
        , material.Bemerkung as `Material Bemerkung` 
        , materialtyp.Name as Materialtyp
        , v_material_instrumente_schwierigkeitsgrade.Schwierigkeitsgrade   
        , v_material_lookuptypes.LookupList2 as Besonderheiten 
        , GROUP_CONCAT(DISTINCT concat(schueler.Name, ' (Status: ', status.Name, ')')  ORDER BY schueler.Name SEPARATOR '<br > ') Schueler   ".PHP_EOL;        
            

        $this->edit_table='material'; 

        break;          






    }
    
    $strTmp.="FROM sammlung 
      INNER JOIN material on material.SammlungID = sammlung.ID
      LEFT JOIN materialtyp on materialtyp.ID = material.MaterialtypID                 
      LEFT JOIN standort  on sammlung.StandortID = standort.ID 
      LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID 
      LEFT JOIN v_sammlung_lookuptypes as v_sammlung_lookuptypes on v_sammlung_lookuptypes.SammlungID = sammlung.ID 
      LEFT JOIN v_material_lookuptypes on v_material_lookuptypes.MaterialID = material.ID                            
      LEFT JOIN v_material_instrumente_schwierigkeitsgrade ON v_material_instrumente_schwierigkeitsgrade.MaterialID = material.ID ".PHP_EOL;

      if ($this->Ansicht=='Sammlung erweitert 3') {
        $strTmp.="
              LEFT JOIN schueler_material ON schueler_material.MaterialID = material.ID ".PHP_EOL;
              if($this->SchuelerID!='') { 
                $strTmp.="AND schueler_material.SchuelerID=".$this->SchuelerID." " . PHP_EOL;        
              }
              elseif($this->SchuelerID!='' & $this->StatusID!='') {
                //  2) Schüler + Status ausgewählt 
                $strTmp.="AND schueler_material.SchuelerID=".$this->SchuelerID." AND StatusID=".$this->StatusID." " . PHP_EOL;        
              }
              elseif($this->SchuelerID=='' & $this->StatusID!='') {
                // 3) Nur Status ausgewählt         
                $strTmp.="AND schueler_material.StatusID=".$this->StatusID." ".PHP_EOL; 
              }                   

        $strTmp.="LEFT JOIN schueler on schueler.ID = schueler_material.SchuelerID
                  LEFT JOIN status ON status.ID = schueler_material.StatusID  ".PHP_EOL;
        }
      
   
    $strTmp.="WHERE material.ID IS NOT NULL ".PHP_EOL;
 
    if ($this->Suchtext!='') {
      $strTmp.="AND (sammlung.Name LIKE '%".$this->Suchtext."%' OR  
                  sammlung.Bemerkung LIKE '%".$this->Suchtext."%' OR                              
                  material.Name LIKE '%".$this->Suchtext."%' OR 
                  material.Bemerkung LIKE '%".$this->Suchtext."%' 
                  ) ". PHP_EOL;           
    }
    if($this->SchuelerID!='' & $this->StatusID=='') { 
      // 1) Nur Schüler ausgewählt 
      $strTmp.="AND material.ID IN (SELECT MaterialID from schueler_material WHERE SchuelerID=".$this->SchuelerID.") " . PHP_EOL;        
    }
    elseif($this->SchuelerID!='' & $this->StatusID!='') {
      //  2) Schüler + Status ausgewählt 
      $strTmp.="AND material.ID IN (SELECT MaterialID from schueler_material WHERE SchuelerID=".$this->SchuelerID." AND StatusID=".$this->StatusID.") " . PHP_EOL;        
    }
    elseif($this->SchuelerID=='' & $this->StatusID!='') {
      // 3) Nur Status ausgewählt         
      $strTmp.="AND material.ID IN (SELECT MaterialID FROM schueler_material WHERE StatusID=".$this->StatusID.") ".PHP_EOL; 
    }        
    if ($this->StandortID!='') {
      $strTmp.="AND sammlung.StandortID=".$this->StandortID." ". PHP_EOL; 
    }
    if ($this->VerlagID!='') {
      $strTmp.="AND sammlung.VerlagID=".$this->VerlagID." ". PHP_EOL; 
    }
    if (count($this->Linktypen) > 0) {
      $strTmp.='AND sammlung.ID IN (SELECT SammlungID FROM link WHERE LinktypeID IN ('.implode(',', $this->Linktypen).')) '.PHP_EOL; 
    }              
    if ($this->MaterialtypID!='') {
      $strTmp.="AND material.MaterialtypID =".$this->MaterialtypID." ".PHP_EOL; 
    }        
    if ($this->InstrumentID_Material!='') {
      $strTmp.="AND material.ID IN (SELECT MaterialID FROM material_schwierigkeitsgrad WHERE InstrumentID=".$this->InstrumentID_Material.") ".PHP_EOL; 
    }       
    if (count($this->Schwierigkeitsgrade_Material) > 0) {
      $strTmp.='AND material.ID IN (SELECT MaterialID FROM material_schwierigkeitsgrad WHERE SchwierigkeitsgradID IN ('.implode(',', $this->Schwierigkeitsgrade_Material).')) '.PHP_EOL; 
    }
    if (count($this->AllLookupTypes) > 0) {
      $strTmp.=$this->getSQL_FilterLookups('sammlung');       
      $strTmp.=$this->getSQL_FilterLookups('material'); 
    }        
    
    // echo 'Ansicht Ebene2: '.$this->AnsichtEbene2.'<br>'; 
    
    switch ($this->AnsichtEbene2){
      case 'Sammlung':
        $strTmp.="GROUP BY sammlung.ID ".PHP_EOL;               
      break; 
      case 'Material':
        $strTmp.="GROUP BY sammlung.ID, material.ID ".PHP_EOL;                     
      break;         
                            
    }
    
    switch ($this->AnsichtEbene2){
      case 'Sammlung':
        $strTmp.="ORDER BY sammlung.Name ".PHP_EOL;              
      break; 
      case 'Material':
        $strTmp.="ORDER BY sammlung.Name, material.Name ".PHP_EOL;                
      break;         
                            
    }

    return $strTmp; 

  }

  private function getSQL_FilterInstrumentSchwierigkeitsgrad($Schwierigkeitsgrade){

    $strFilter=''; 
    $query = "SELECT DISTINCT InstrumentID 
                      FROM instrument_schwierigkeitsgrad  
                      WHERE ID IN (".implode(',', $Schwierigkeitsgrade).") 
                      order by ID";
    // echo $query; 

    $select = $this->db->prepare($query); 
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      $arrTmp=[]; 
      $strFilter.="AND satz.ID IN (SELECT SatzID FROM satz_schwierigkeitsgrad WHERE InstrumentID=".$row["InstrumentID"]." "; 
      $query2 = "SELECT DISTINCT SchwierigkeitsgradID 
                FROM instrument_schwierigkeitsgrad  
                WHERE ID IN (".implode(',', $Schwierigkeitsgrade).") 
                AND InstrumentID=".$row["InstrumentID"]."  
                ORDER by ID";
      // echo $query2; 
      $select2 = $this->db->prepare($query2); 
      $select2->execute(); 
      $result2 = $select2->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result2 as $row2) {
        $arrTmp[]=$row2["SchwierigkeitsgradID"]; 
      }
      $strFilter.="AND SchwierigkeitsgradID IN (".implode(',', $arrTmp)."))".PHP_EOL; 
    }
    return  $strFilter; 
  }

  private function getSQL_FilterLookups($table) {
    // XXXX Unterscheidung Ein/Ausschluss-Suche 
    
    $this->txtTest.='getSQL_FilterLookups $ table: '.$table.'<br'; 
    $relations=[]; 
    $lookup_values_selected=[]; 
    $lookup_values_not_selected=[];    
    $lookuptype_check_include=false; 
    $lookuptype_check_exclude=false; 

    $strTmp=''; 

    foreach($this->AllLookupTypes as $lookuptype=>$lookups) {
      $relations=$lookups["lookuptype_relations"]; 
      $lookup_values_selected= $lookups["lookup_values_selected"]; 
      $lookup_values_not_selected= $lookups["lookup_values_not_selected"]; 
      $lookuptype_check_include= $lookups["lookuptype_check_include"]; 
      $lookuptype_check_exclude= $lookups["lookuptype_check_exclude"]; 
      
      for ($r = 0; $r < count($relations); $r++) {
        $relation=$relations[$r]; 
        if($relation==$table) {
            // $this->txtTest.='relation == table <br'; 
          if($lookuptype_check_include) {
            for ($ls = 0; $ls < count($lookup_values_selected); $ls++) { 
              $strTmp.='AND '.$table.'.ID IN (SELECT '.ucfirst($table).'ID from '.$table.'_lookup WHERE LookupID='.$lookup_values_selected[$ls].') '. PHP_EOL; 
            }
          } else {
            $strTmp.='AND '.$table.'.ID IN (SELECT '.ucfirst($table).'ID from '.$table.'_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
          }
          if($lookuptype_check_exclude) {
            $strTmp.='AND '.$table.'.ID NOT IN (SELECT '.ucfirst($table).'ID from '.$table.'_lookup WHERE LookupID IN ('.implode(',', $lookup_values_not_selected).')) '. PHP_EOL; 
          }
        }
      }
      return $strTmp; 
    }
  }

  public function printTable($resutTable) {

    $table_caption=''; 

    switch($resutTable) {
      case 'Sammlung_Noten': 
        $query = $this->getSQL_Sammlung_Noten(); 
        $table_caption='1) Sammlungen und Noten:'; 
      break; 

      case 'Sammlung_Material': 
        $query = $this->getSQL_Sammlung_Material(); 
        $table_caption='2) Sammlungen und Material:'; 
             
      break; 

      case 'Schueler': 
        // XXXX $query = $this->getSQL_Sammlung_Material(); 
        // $title='Schüler';               
      break; 


    }


    $select = $this->db->prepare($query); 
      
    try {
      $select->execute();  
      $html = new HTML_Table($select); 
      $html->add_link_edit=true; 
      $html->edit_link_table=$this->edit_table; 
      $html->edit_link_open_newpage=true; 
      $html->show_row_count=true;
      $html->caption=$table_caption;  
      $html->print_table2(); 
    }
    catch (PDOException $e) {
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }   
    
    echo '<pre style="font-size: 11px; '.($this->printSQL?'':'display: none').';">'.$query .'</pre>'; // Test  
    

  }
  
  public function printDescription() {
      if ($this->Beschreibung!='') {
        echo '<p>'.$this->Beschreibung.'</p>'; 
      }
  }

  public function printLookupsTest() {
    $relations=[]; 
    $count_relations=0; 

    foreach($this->AllLookupTypes as $lookuptype=>$lookups) {

      $relations=$lookups["lookuptype_relations"]; 
      $count_relations = count($relations); 

     // /* TEST Ausgabe  */      
      echo '<pre>'; 
      // print_r($lookups); 
      echo 'Lookuptyp Name: '.$lookups["lookuptype_name"].PHP_EOL;
    
      echo 'Relationen: (Anzahl: '. $count_relations.')'.PHP_EOL; 
      print_r($relations); 

      if($lookups["lookuptype_check_include"]) {
          echo 'lookuptype_check_include wurde gesetzt.'.PHP_EOL; 
      }
      else  {
          echo 'lookuptype_check_include wurde nicht gesetzt.'.PHP_EOL;         
      }

      echo 'ausgewählte Lookups:'.PHP_EOL; 
      print_r($lookups["lookup_values_selected"]); 
      echo '</pre>'; 


      
    }

    echo '<hr>'; 

    // echo '<pre>'; 
    // print_r($this->AllLookupTypes); 
    // echo '</pre>'; 



  }

  
  public function printTest() {
    
    echo '<pre>XXXX TEST: '; 
    echo $this->txtTest; 
    echo '</pre>'; 


  }


}
?>