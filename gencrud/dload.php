<?php
session_start();
require('../skul_database.php');

 $user_access = $_SESSION['user_access'];
 $sec_id_fac = $_SESSION['sec_id_fac'];//sec id from faculty table
 if (isset($_GET['137'])){
 	$f137 = $_GET['137'];

 //this will check that the only user who can download a 137 is the admin or the adviser by setting ara to TRUE
 $sec_id_checker = queryMysql("SELECT * FROM learner WHERE learner_id=$f137");
            if (mysqli_num_rows($sec_id_checker))
            {
              $row = mysqli_fetch_row($sec_id_checker);
              $sec_id_learner = $row[13];//sec_id from learner table
              if($sec_id_fac==$sec_id_learner){$ara = TRUE;}else{$ara = FALSE;}
            }



}else {$f137 = "";}





	//downloading form 1
	if (isset($_GET['f1'])) {
	$id = linis($_GET['f1']);
	require_once 'src/PHPExcel.php';
	try {
		$sheet = new PHPExcel();

		// Set metadata
		$sheet->getProperties()->setCreator('www.loreselem.com')
		                       ->setLastModifiedBy('www.loreselem.com')
		                       ->setTitle('Profile of $profile_name')
		                       ->setKeywords('profile pupil data informations');
		
		// Set default settings
		$sheet->getDefaultStyle()->getAlignment()->setVertical(
	            PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getDefaultStyle()->getAlignment()->setHorizontal(
				PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getDefaultStyle()->getFont()->setName('Cambria');
		$sheet->getDefaultStyle()->getFont()->setSize(12);

        
		
		// Get reference to active spreadsheet in workbook
		$sheet->setActiveSheetIndex(0);
		$activeSheet = $sheet->getActiveSheet();
		
        //wrap text
		$activeSheet->getStyle('A8:Y9')->getAlignment()->setWrapText(true);
		$activeSheet->getStyle('A10:Y65')->getAlignment()->setWrapText(true);

		// Set print options
		$activeSheet->getPageSetup()->setOrientation(
	            PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
				->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
				
		
		$activeSheet->getPageMargins()->setTop(0.25);
		$activeSheet->getPageMargins()->setRight(0.25);
		$activeSheet->getPageMargins()->setLeft(0.25);
		$activeSheet->getPageMargins()->setBottom(0.25);
		$activeSheet->getPageSetup()->setPrintArea('A1:Y80');
		
		//set font sizes
		$activeSheet->getStyle('A3:Y7')->getFont()->setSize(10);
		$activeSheet->getStyle('A8:Y9')->getFont()->setSize(7);
		$activeSheet->getStyle('A10:Y80')->getFont()->setSize(7);



		// draw borders
		$styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);
		$styleArray2 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('argb' => '221E1F'),),),);

		$makebottom = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);
		
	
		
		// merge cells
		$merge_array = array("J1:R1", "Q4:R4", "J2:R2", "F6:K6", "M4:P4", "N6:O6", "P6:Q6", "V6:X6", "S4:V4", "R6:S6", "V6:X6", "S4:V4",
			"R6:S6", "L6:M6", "K4:L4", "C6:E6", "D4:E4", "H4:I4", "A8:A9", "B8:B9", "C8:F9", "G8:G9", "H8:H9", "J8:J9", "K8:K9", "L8:L9",
			"M8:M9", "N8:Q8", "V8:W8", "R8:U8", "R9:S9", "T9:U9", "X8:X9");
		
	
		foreach ($merge_array as $value) {
			$activeSheet->mergeCells($value);
		}
		


		//allignment
		$activeSheet->getStyle('A10:Y65')->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        
		

        $list_of_male = queryMysql("SELECT * FROM learner WHERE sec_id=$id AND gender='m' ORDER BY last_name ASC");//ask from messages
	    $male_num = mysqli_num_rows($list_of_male)+9; $gdfg=$male_num-9;

			$rownum = 9;
			$numbr = 0;


       do {
             //values
		    if($row[7]=="NONE"  OR $row[7]==""){$ext="";}else{$ext=$row[7];}
			$name = strtoupper($row[4].", ".$row[6]." ".$row[5]." ". $ext);
			$lrn = $row[1];
            $b_day = $row[9]."/".$row[10]."/".$row[11];
            $le_id = $row[0];
            $result2 = queryMysql("SELECT * FROM learner WHERE learner_id='$le_id'");
			    if (mysqli_num_rows($result2))
			    {
			        $roww = mysqli_fetch_assoc($result2);
			        $bplace= ucwords($roww["birth_province"]);
			        $dialect= ucwords($roww["dialect"]);
			        $ethnic= ucwords($roww["ethnic"]);
			        $religion= ucwords($roww["religion"]);
			        $stsubd= ucwords($roww["stsubd"]);
			        $brgy= ucwords($roww["barangay"]);
			        $municipality= ucwords($roww["municipality"]);
			        $province= ucwords($roww["province"]);
			        if($row[5]==$roww["frlast"]){$father=$roww["frname"];}else{$father=ucwords($roww["frname"]." ".$roww["frlast"]);}
			        $maiden= ucwords($roww["mrname"]." ".$roww["mrmaiden"]." ".$roww["mrlast"]);
			        if($row[17]=="")
			        	{if($roww["frname"] ==""){$rela="";}else{$rela="Parent"; } if($roww["frname"] != ""){$guardian = ucwords($roww["frname"]." ".$roww["frlast"]);}else{$guardian = ucwords($roww["mrname"]." ".$roww["mrlast"]);}}else{$guardian = ucwords($row[17]); $rela="Relative";}

			        if($roww['mrcell'] !=""){$cn=$roww['mrcell'];}elseif($roww['frcell'] !=""){$cn=$roww['frcell'];}else{$cn="";}
			    }


			$m = $row[9]; $d = $row[10]; $y = $row[11];
			 $age = 2017-$y; if($m >= 6){$age = $age+1;}


			//insert to cell
			 $activeSheet->setCellValue("C".$rownum, "$name");
			 $activeSheet->setCellValue("B".$rownum, "$lrn");
			 $activeSheet->setCellValue("A".$rownum, "$numbr");
			 $activeSheet->setCellValue("G".$rownum, "M");
			 $activeSheet->setCellValue("H".$rownum, "$b_day");
			 $activeSheet->setCellValue("I".$rownum, "$age");
			 $activeSheet->setCellValue("J".$rownum, "$bplace");
			 $activeSheet->setCellValue("K".$rownum, "$dialect");
			 $activeSheet->setCellValue("L".$rownum, "$ethnic");
			 $activeSheet->setCellValue("M".$rownum, "$religion");
			 $activeSheet->setCellValue("N".$rownum, "$stsubd");
			 $activeSheet->setCellValue("O".$rownum, "$brgy");
			 $activeSheet->setCellValue("P".$rownum, "$municipality");
			 $activeSheet->setCellValue("Q".$rownum, "$province");
			 $activeSheet->setCellValue("R".$rownum, "$father");
			 $activeSheet->setCellValue("T".$rownum, "$maiden");
			 $activeSheet->setCellValue("V".$rownum, "$guardian");
			 $activeSheet->setCellValue("W".$rownum, "$rela");
			 $activeSheet->setCellValue("X".$rownum, "$cn");



			 
           
			$rownum++;
            $numbr++;
           //merge cells
			$activeSheet->mergeCells("C".$rownum.':'."F".$rownum);
			$activeSheet->mergeCells("R".$rownum.':'."S".$rownum);
			$activeSheet->mergeCells("T".$rownum.':'."U".$rownum);

           //set height
			$activeSheet->getRowDimension($rownum)->setRowHeight(20);
			//set to center allignment
			$activeSheet->getStyle("G".$rownum.":"."I".$rownum)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			//cell value format
		    $activeSheet->getStyle("B".$rownum)->getNumberFormat()
		    ->setFormatCode('############');
             $activeSheet->getStyle("X".$rownum)->getNumberFormat()
		    ->setFormatCode('00000000000');
  
  			//apply borders
             $activeSheet->getStyle("A".$rownum.':'."Y".$rownum)->applyFromArray($styleArray);

			//set font size
			$activeSheet->getStyle("T".$rownum)->getFont()->setSize(5);

		} while ($row = mysqli_fetch_array($list_of_male) AND $rownum <= $male_num);

        
        //breaker
        $kgkg = $male_num+1;$fhfh= $male_num-9;
        $activeSheet->setCellValue("B".$kgkg, "$fhfh");
        $activeSheet->setCellValue("C".$kgkg, "<=== TOTAL MALE");

        $activeSheet->getStyle("A".$kgkg. ':' . "Y".$kgkg)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$activeSheet->getStyle("A".$kgkg. ':' . "Y".$kgkg)->getFill()->getStartColor()->setARGB('E5E6E7');

		$activeSheet->getStyle("B".$kgkg. ':' . "C".$kgkg)->getFont()->setBold(true);
		$activeSheet->getStyle("B".$kgkg)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




     //loop all female
	         $list_of_female = queryMysql("SELECT * FROM learner WHERE sec_id=$id AND gender='f' ORDER BY last_name ASC");//ask from messages
   			 $female_num = mysqli_num_rows($list_of_male)+11+$male_num; 

	        
			$rownum = $male_num+2;
			$numbr = 0;

		    do {
             //values
		    if($row[7]=="NONE" OR $row[7]==""){$ext="";}else{$ext=$row[7];}
			$name = strtoupper($row[4].", ".$row[6]." ".$row[5]." ". $ext);
			$lrn = $row[1];
            $b_day = $row[9]."/".$row[10]."/".$row[11];
            $le_id = $row[0];
            $result2 = queryMysql("SELECT * FROM learner WHERE learner_id='$le_id'");
			    if (mysqli_num_rows($result2))
			    {
			        $roww = mysqli_fetch_assoc($result2);
			        $bplace= ucwords($roww["birth_province"]);
			        $dialect= ucwords($roww["dialect"]);
			        $ethnic= ucwords($roww["ethnic"]);
			        $religion= ucwords($roww["religion"]);
			        $stsubd= ucwords($roww["stsubd"]);
			        $brgy= ucwords($roww["barangay"]);
			        $municipality= ucwords($roww["municipality"]);
			        $province= ucwords($roww["province"]);
			        if($row[5]==$roww["frlast"]){$father=$roww["frname"];}else{$father=ucwords($roww["frname"]." ".$roww["frlast"]);}
			        $maiden= ucwords($roww["mrname"]." ".$roww["mrmaiden"]." ".$roww["mrlast"]);
			        if($row[17]=="")
			        	{if($roww["frname"] ==""){$rela="";}else{$rela="Parent"; } if($roww["frname"] != ""){$guardian = ucwords($roww["frname"]." ".$roww["frlast"]);}else{$guardian = ucwords($roww["mrname"]." ".$roww["mrlast"]);}}else{$guardian = ucwords($row[17]); $rela="Relative";}

			        if($roww['mrcell'] !=""){$cn=$roww['mrcell'];}elseif($roww['frcell'] !=""){$cn=$roww['frcell'];}else{$cn="";}
			    }


			$m = $row[9]; $d = $row[10]; $y = $row[11];
			 $age = 2017-$y; if($m >= 6){$age = $age+1;}



			//insert to cell
			 $activeSheet->setCellValue("C".$rownum, "$name");
			 $activeSheet->setCellValue("B".$rownum, "$lrn");
			 $activeSheet->setCellValue("A".$rownum, "$numbr");
			 $activeSheet->setCellValue("G".$rownum, "F");
			 $activeSheet->setCellValue("H".$rownum, "$b_day");
			 $activeSheet->setCellValue("I".$rownum, "$age");
			 $activeSheet->setCellValue("J".$rownum, "$bplace");
			 $activeSheet->setCellValue("K".$rownum, "$dialect");
			 $activeSheet->setCellValue("L".$rownum, "$ethnic");
			 $activeSheet->setCellValue("M".$rownum, "$religion");
			 $activeSheet->setCellValue("N".$rownum, "$stsubd");
			 $activeSheet->setCellValue("O".$rownum, "$brgy");
			 $activeSheet->setCellValue("P".$rownum, "$municipality");
			 $activeSheet->setCellValue("Q".$rownum, "$province");
			 $activeSheet->setCellValue("R".$rownum, "$father");
			 $activeSheet->setCellValue("T".$rownum, "$maiden");
			 $activeSheet->setCellValue("V".$rownum, "$guardian");
			 $activeSheet->setCellValue("W".$rownum, "$rela");
			 $activeSheet->setCellValue("X".$rownum, "$cn");

			 
           
			$rownum++;
            $numbr++;
           //merge cells
			$activeSheet->mergeCells("C".$rownum.':'."F".$rownum);
			$activeSheet->mergeCells("R".$rownum.':'."S".$rownum);
			$activeSheet->mergeCells("T".$rownum.':'."U".$rownum);


			 //set height
			$activeSheet->getRowDimension($rownum)->setRowHeight(20);
			//set to center allignment
			$activeSheet->getStyle("G".$rownum.":"."I".$rownum)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			//cell value format
		    $activeSheet->getStyle("B".$rownum)->getNumberFormat()
		    ->setFormatCode('############');
             $activeSheet->getStyle("X".$rownum)->getNumberFormat()
		    ->setFormatCode('00000000000');

		    //apply borders
             $activeSheet->getStyle("A".$rownum.':'."Y".$rownum)->applyFromArray($styleArray);

			//set font size
			$activeSheet->getStyle("T".$rownum)->getFont()->setSize(5);

		} while ($row = mysqli_fetch_array($list_of_female) AND $rownum <= $female_num);  


			$zero = $male_num+2;
            $activeSheet->getRowDimension($zero)->setRowHeight(0);
            
        //breaker
        $number_of_all = mysqli_num_rows (queryMysql("SELECT * FROM learner WHERE sec_id=$id"))+12;   
        $fhfh= mysqli_num_rows($list_of_female);
        $activeSheet->setCellValue("B".$number_of_all, "$fhfh");

         $activeSheet->getStyle("A".$number_of_all. ':' . "Y".$number_of_all)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$activeSheet->getStyle("A".$number_of_all. ':' . "Y".$number_of_all)->getFill()->getStartColor()->setARGB('E5E6E7');

        $activeSheet->setCellValue("C".$number_of_all, "<=== TOTAL FEMALE");
        $activeSheet->getStyle("C".$number_of_all)->getAlignment()->setWrapText(false);
		$activeSheet->getStyle("B".$number_of_all. ':' . "C".$number_of_all)->getFont()->setBold(true);
		$activeSheet->getStyle("B".$number_of_all)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

       //breaker
        $combined_total = $number_of_all-12;  
        $number_of_all =  $number_of_all+1;
        $activeSheet->mergeCells("C".$number_of_all.":"."F".$number_of_all);
		$activeSheet->mergeCells("R".$number_of_all.':'."S".$number_of_all);
		$activeSheet->mergeCells("T".$number_of_all.':'."U".$number_of_all);
		$activeSheet->getStyle("A".$number_of_all.':'."Y".$number_of_all)->applyFromArray($styleArray);

		 $activeSheet->getStyle("A".$number_of_all. ':' . "Y".$number_of_all)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$activeSheet->getStyle("A".$number_of_all. ':' . "Y".$number_of_all)->getFill()->getStartColor()->setARGB('AEB2B6');

        $activeSheet->setCellValue("B".$number_of_all, "$combined_total");
        $activeSheet->setCellValue("C".$number_of_all, "<=== COMBINED");
		$activeSheet->getStyle("B".$number_of_all. ':' . "C".$number_of_all)->getFont()->setBold(true);
		$activeSheet->getStyle("B".$number_of_all)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		// fonts and sizes
		$activeSheet->getStyle('J2')->getFont()->setItalic(true);
		$activeSheet->getStyle('J2')->getFont()->setSize(7);
		$activeSheet->getStyle('J1')->getFont()->setSize(16);
		$activeSheet->getStyle('R9')->getFont()->setSize(6);
		$activeSheet->getStyle('P9')->getFont()->setSize(6);

		
		// set width of all the columns
		 $width_array = array("A"=>"2","B"=>"9.1", "C"=>"2.6", "D"=>"2.3", "E"=>"6.6", "F"=>"7.4", "G"=>"3.2", "H"=>"5.7", 
		 	"I"=>"4.6", "J"=>"7", "K"=>"6", "L"=>"5.6", "M"=>"6.1", "N"=>"6.5", "O"=>"5.9", "P"=>"6.7", "Q"=>"5.6", "R"=>"3.9",
		 	"S"=>"1.6", "T"=>"1.9", "U"=>"5.7", "V"=>"6", "W"=>"5.9", "X"=>"8.6", "Y"=>"7.1");

			foreach ($width_array as $key => $value) {
			 $activeSheet->getColumnDimension($key)->setWidth($value);
			}
		// set the height of other important rows 
		$activeSheet->getRowDimension('8')->setRowHeight(34.5);

		$activeSheet->getRowDimension('9')->setRowHeight(66);
		$activeSheet->getRowDimension('12')->setRowHeight(15);
		


		
		//set value of data fieldset
		$activeSheet->setCellValue('J2', "This replace  Form 1, Master List & STS Form 2-Family Background and Profile");
		$activeSheet->setCellValue('J1', "School Form 1 (SF 1) School Register");
		$activeSheet->setCellValue('D4', "School ID");
		$activeSheet->getStyle('D4')->getFont()->setBold(true);
		$activeSheet->setCellValue('C6', "School Name");
		$activeSheet->getStyle('C6')->getFont()->setBold(true);
		$activeSheet->setCellValue('H4', "Region");
		$activeSheet->getStyle('H4')->getFont()->setBold(true);
		$activeSheet->setCellValue('K4', "Division");
		$activeSheet->getStyle('K4')->getFont()->setBold(true);
		$activeSheet->setCellValue('L6', "School Year");
		$activeSheet->getStyle('L6')->getFont()->setBold(true);
		$activeSheet->setCellValue('Q4', "District");
		$activeSheet->getStyle('Q4')->getFont()->setBold(true);
		$activeSheet->setCellValue('P6', "Grade Level");
		$activeSheet->getStyle('P6')->getFont()->setBold(true);
		$activeSheet->setCellValue('U6', "Section");
		$activeSheet->getStyle('U6')->getFont()->setBold(true);


        //set value of skul data
		 $skul_data = queryMysql("SELECT * FROM school_data WHERE idofskul=1");
		    if (mysqli_num_rows($skul_data))
		    {
		        $row = mysqli_fetch_assoc($skul_data);

		        $skul_id = $row["skul_id"];
		        $skul_name = strtoupper($row["school_name"]);
		        $skul_region = strtoupper($row["region"]);
		        $skul_division = strtoupper($row["division"]);
		        $skul_year = $row["skul_year"];
		        $skul_head = strtoupper($row["office_head"]);
		        $skul_district = strtoupper($row["district"]);


		        $activeSheet->setCellValue('F4', "$skul_id");
		        $activeSheet->setCellValue('F6', "$skul_name");
		        $activeSheet->setCellValue('J4', "$skul_region");
		        $activeSheet->setCellValue('M4', "$skul_division");
		        $activeSheet->setCellValue('N6', "$skul_year");
		        $activeSheet->setCellValue('S4', "$skul_district");

		    }

		  $section_data = queryMysql("SELECT * FROM lores_section WHERE sec_id=$id");
		    if (mysqli_num_rows($section_data))
		    {
		        $row = mysqli_fetch_assoc($section_data);
                $sec_name = strtoupper($row["sec_name"]);
                $sec_grade = $row["sec_grade"]; if($sec_grade==6){$sec_grade="SIX";}elseif($sec_grade==5){$sec_grade="FIVE";}elseif($sec_grade==4){$sec_grade="FOUR";}elseif($sec_grade==3){$sec_grade="THREE";}elseif($sec_grade==2){$sec_grade="TWO";}elseif($sec_grade==1){$sec_grade="ONE";}elseif($sec_grade=="k"){$sec_grade="KINDER";}
		         $activeSheet->setCellValue('V6', "$sec_name");
			     $activeSheet->setCellValue('R6', "$sec_grade");
		    }


		     $adviser_data = queryMysql("SELECT * FROM faculty WHERE sec_id=$id");
		    if (mysqli_num_rows($adviser_data))
		    {
		        $row = mysqli_fetch_assoc($adviser_data);
                $adviser = strtoupper($row["first_name"]." ".$row["middle_name"]." ".$row["last_name"]." ".$row["extension_name"]);
                
		    }



             //merge cells in the summary
		$sumary_strt = $number_of_all+2;
		$sumary_breaker = $number_of_all+1;
        $activeSheet->mergeCells("C".$sumary_breaker.":"."L".$sumary_breaker);
        $activeSheet->getStyle("C".$sumary_breaker)->getFont()->setSize(10);
        $activeSheet->getStyle("C".$sumary_breaker)->getFont()->setItalic(true);
		$activeSheet->setCellValue("C".$sumary_breaker, "List and Code of Indicators under REMARKS column");

		//bosy
		$r1 = $sumary_breaker+1;
		$r2 = $sumary_breaker+2;
		$r3 = $sumary_breaker+3;
		$r4 = $sumary_breaker+4;
		$r5 = $sumary_breaker+5;
		$r6 = $sumary_breaker+6;
		$r7 = $sumary_breaker+7;
		$r8 = $sumary_breaker+8;
		$r9 = $sumary_breaker+9;


        $activeSheet->getRowDimension("$r1")->setRowHeight(14);
        $activeSheet->getRowDimension("$r2")->setRowHeight(14);
        $activeSheet->getRowDimension("$r3")->setRowHeight(14);
        $activeSheet->getRowDimension("$r4")->setRowHeight(14);
        $activeSheet->getRowDimension("$r5")->setRowHeight(14);
        $activeSheet->getRowDimension("$r6")->setRowHeight(14);
        $activeSheet->getRowDimension("$r7")->setRowHeight(14);
        $activeSheet->getRowDimension("$r8")->setRowHeight(14);


        //merge cells
		$activeSheet->mergeCells("M".$r1.":"."M".$r2);
		$activeSheet->mergeCells("M".$r3.":"."M".$r4);
		$activeSheet->mergeCells("M".$r5.":"."M".$r6);
		$activeSheet->mergeCells("M".$r7.":"."M".$r8);
		$activeSheet->mergeCells("N".$r1.":"."N".$r2);
		$activeSheet->mergeCells("N".$r3.":"."N".$r4);
		$activeSheet->mergeCells("N".$r5.":"."N".$r6);
		$activeSheet->mergeCells("N".$r7.":"."N".$r8);
		$activeSheet->mergeCells("O".$r1.":"."O".$r2);
		$activeSheet->mergeCells("O".$r3.":"."O".$r4);
		$activeSheet->mergeCells("O".$r5.":"."O".$r6);
		$activeSheet->mergeCells("O".$r7.":"."O".$r8);


		$activeSheet->mergeCells("Q".$r1.":"."U".$r1);
		$activeSheet->setCellValue("Q".$r1, "Prepared by:");
		$activeSheet->getStyle("Q".$r1.":"."Y".$r1)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$activeSheet->mergeCells("Q".$r2.":"."U".$r4);$activeSheet->setCellValue("Q".$r2, "$adviser");
		$activeSheet->getStyle("Q".$r2.":"."Y".$r4)->getAlignment()
		    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
		$activeSheet->getStyle("Q".$r2.":"."Y".$r6)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$activeSheet->getStyle("Q".$r2.":"."Y".$r4)->getFont()->setBold(true);
		$activeSheet->getStyle("Q".$r2.":"."U".$r4)->applyFromArray($makebottom);
		$activeSheet->mergeCells("Q".$r5.":"."U".$r6);$activeSheet->setCellValue("Q".$r5, "(Signature of Adviser over Printed Name)");
		$activeSheet->mergeCells("Q".$r7.":"."U".$r8);$activeSheet->setCellValue("Q".$r7, "BoSY Date:_______     EoSY Date:_______");
		$activeSheet->getStyle("Q".$r7.":"."Y".$r7)->getAlignment()
		    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
		$activeSheet->getStyle("Q".$r7.":"."Y".$r7)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


       



		$activeSheet->mergeCells("W".$r1.":"."Y".$r1);$activeSheet->setCellValue("W".$r1, "Certified correct:");
		$activeSheet->mergeCells("W".$r2.":"."Y".$r4);$activeSheet->setCellValue("W".$r2, "$skul_head");
		$activeSheet->getStyle("W".$r2.":"."Y".$r4)->applyFromArray($makebottom);
		$activeSheet->mergeCells("W".$r5.":"."Y".$r6);
		$activeSheet->mergeCells("W".$r5.":"."Y".$r6);$activeSheet->setCellValue("W".$r5, "(Signature of School Head over Printed Name)");
		$activeSheet->mergeCells("W".$r7.":"."Y".$r8);$activeSheet->setCellValue("W".$r7, "BoSY Date:_______    EoSY Date:_______");
        $gen_date = date("F j, Y");
		$activeSheet->setCellValue("A".$r9, "This form was generated last $gen_date.");
		$activeSheet->mergeCells("A".$r9.":"."F".$r9);
		$activeSheet->getStyle("A".$r9.":"."F".$r9)->getAlignment()
		    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
		$activeSheet->getStyle("A".$r9)->getFont()->setItalic(true);
        
		//apply border
		$activeSheet->getStyle("M".$r1.":"."O".$r8)->applyFromArray($styleArray);

		//apply center allignment
		$activeSheet->getStyle("M".$r1.":"."O".$r8)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//make bold
		 $activeSheet->getStyle("M".$r1.":"."O".$r8)->getFont()->setBold(true);
        //make unbold
		 $activeSheet->getStyle("N".$r3.":"."N".$r8)->getFont()->setBold(false);
        
        //set value
        $activeSheet->setCellValue("M".$r1, "REGISTERED");
        $activeSheet->getStyle("M".$r1)->getFont()->setSize(6);
        $activeSheet->setCellValue("N".$r1, "BOSY");
        $activeSheet->setCellValue("O".$r1, "EOSY");
        $activeSheet->setCellValue("M".$r3, "MALE");
        $activeSheet->setCellValue("M".$r5, "FEMALE");
        $activeSheet->setCellValue("M".$r7, "TOTAL");

        $activeSheet->setCellValue("N".$r3, "$gdfg");
        $activeSheet->setCellValue("N".$r5, "$fhfh");
        $fgtg = $gdfg+$fhfh;
        $activeSheet->setCellValue("N".$r7, "$fgtg");

        // insert ind
		



		//value of static data
		 $value_array = array("A8"=>"#","B8"=>"LRN","C8"=>"NAME (Last Name, First Name, Middle Name)", "G8"=>"Sex (M/F)",
		 	"H8"=>"BIRTH DATE  (mm/ dd/yy)","I8"=>"AGE as of 1st Friday of June","I9"=>"(nos. of years as per last birthday)",
		 	"J8"=>"BIRTH PLACE (Province)", "K8"=>"MOTHER TONGUE", "L8"=>"IP (Specify Ethnic Group)", "M8"=>"RELIGION",
		 	"N8"=>"ADDRESS", "N9"=>"House # / Street/Sitio/", "O9"=>"Province", "R8"=>"NAME OF PARENTS", "V8"=>"GUARDIAN (If not Parent)",
		 	"R9"=>"Father (1st name only if family name identical to learner)", "T9"=>"Mother (Maiden)", "V9"=>"Name", 
		 	"W9"=>"Relationship", "X8"=>"Contact Number (Parent /Guardian)", "Y8"=>"REMARK/S", 
		 	"Y9"=>"(Please refer to the legend on last page)");

			foreach ($value_array as $key => $value) {
			  $activeSheet->setCellValue($key, $value);
			}





		//apply border
        $border_array = array("F4","F6:K6","J4","M4:P4","N6:O6","S4:V4","R6:S6","R6:S6","V6:X6","A8:Y9");

			foreach ($border_array as $value) {
			  $activeSheet->getStyle($value)->applyFromArray($styleArray);
			}
      


       

	     $activeSheet->getStyle('A8:Y9')->applyFromArray($styleArray2);//this is the header border
		//apply color fill
		$activeSheet->getStyle('A8:Y9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$activeSheet->getStyle('A8:Y9')->getFill()->getStartColor()->setARGB('E5E6E7');

		
		


		
		
		//makes font bold
		$activeSheet->getStyle('A8:Y9')->getFont()->setBold(true);


	    $legend = "A".$sumary_strt;
		$head_sign = "W".$r2;
        $image_array = array("deped.png|100|B1","lores.png|100|X1","head_sign.png|70|$head_sign", "ind.png|150|$legend");

		foreach ($image_array as $value) {
			list($img, $h, $coor) = explode('|', $value);
		    $objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath("images/$img");
			$objDrawing->setHeight($h);
			$objDrawing->setCoordinates($coor);
			$objDrawing->setWorksheet($activeSheet);
		}



		
		
		
		
		// Give spreadsheet a title
		//$activeSheet->setTitle('VI-Capricorn (SF1)');
		
		// Generate Excel file and download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$fl = $sec_name.'_SF1.xlsx';
		header("Content-Disposition: attachment;filename=$fl");
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel2007');
		ob_end_clean();
		$writer->save('php://output');
		exit;
	} catch (Exception $e) {
		$error = $e->getMessage();
	}
	
}




//downloading form 1
	if (isset($_GET['f2'])) {
	$id = linis($_GET['f2']);
	require_once 'src/PHPExcel.php';
	try {
		$sheet = new PHPExcel();

		// Set metadata
		$sheet->getProperties()->setCreator('www.loreselem.com')
		                       ->setLastModifiedBy('www.loreselem.com')
		                       ->setTitle('Daily Attendance Report of Learners (SF2)')
		                       ->setKeywords('profile pupil data informations');
		
		// Set default settings
		$sheet->getDefaultStyle()->getAlignment()->setVertical(
	            PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getDefaultStyle()->getAlignment()->setHorizontal(
				PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getDefaultStyle()->getFont()->setName('Cambria');
		$sheet->getDefaultStyle()->getFont()->setSize(7);
		//$sheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B &LPage &P of &N');// for showing the page number in the footer

        
		
		// Get reference to active spreadsheet in workbook
		$sheet->setActiveSheetIndex(0);
		$activeSheet = $sheet->getActiveSheet();
		

		// Set print options
		$activeSheet->getPageSetup()->setOrientation(
	            PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
				->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
				
		
		$activeSheet->getPageMargins()->setTop(0.25);
		$activeSheet->getPageMargins()->setRight(0.25);
		$activeSheet->getPageMargins()->setLeft(0.25);
		$activeSheet->getPageMargins()->setBottom(0.25);
		$activeSheet->getPageSetup()->setPrintArea('A1:AJ100');
		



		//outline border
		$outborder = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);
		$allborder = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);
	    $leftborder = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('argb' => '221E1F'),),),);
		$thickborder = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('argb' => '221E1F'),),),);
		$bottomborder = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);

		$allthick = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('argb' => '221E1F'),),),);

		

		


		//get the school data
		
     	$result = queryMysql("SELECT * FROM school_data  WHERE idofskul=1");
     if (mysqli_num_rows($result))
	    {
	        $row = mysqli_fetch_assoc($result);
           $skid= $row['skul_id'];
           $skyr = $row['skul_year'];
           $snm = strtoupper($row['school_name']);
           
	    }

	$gr = show_info1("lores_section", "sec_id", $id, "sec_grade");
    $sec = strtoupper(show_info1("lores_section", "sec_id", $id, "sec_name"));
    $fi = show_info1("lores_section", "sec_id", $id, "sec_adviser_id");//faculty_id
    $teacher = Teacher::find($fi);
    $sec_adviser = strtoupper($teacher->first_name." ".$teacher->middle_name." ".$teacher->last_name." ".$teacher->extension_name);
    $schoolhead = strtoupper(show_info1("school_data", "idofskul", 1, "office_head"));

	//value
		$value_array = array("B4"=>"School ID", "F4"=>"School Year", "P4"=>"Report for the Month of", "B6"=>"Name of School",
			"P6"=>"Grade Level", "Z6"=>"Section", "A2"=>"School Form 2 (SF2) Daily Attendance Report of Learners", 
			"A3"=>"(This replaces Form 1, Form 2 & STS Form 4 - Absenteeism and Dropout Profile)", "A8"=>"LEARNER'S NAME",
			"A10"=>"(Last Name, First Name, Middle Name)", "D8"=>"(1st row for date)", "AC8"=>"Total for the Month",
			"AC10"=>"ABSENT", "AD10"=>"TARDY","AE8"=>"REMARKS (If DROPPED OUT, state reason, please refer to legend number 2.",
			"D10"=>"M", "E10"=>"T", "F10"=>"W", "G10"=>"TH", "H10"=>"F", "I10"=>"M", "J10"=>"T", "K10"=>"W", "L10"=>"TH", "M10"=>"F",
			 "N10"=>"M", "O10"=>"T", "P10"=>"W", "Q10"=>"TH", "R10"=>"F", "S10"=>"M", "T10"=>"T", "U10"=>"W", "V10"=>"TH", "W10"=>"F",
			  "X10"=>"M", "Y10"=>"T", "Z10"=>"W", "AA10"=>"TH", "AB10"=>"F", "C4"=>$skid, "K4"=>$skyr, "C6"=>$snm,
			  "X6"=>$gr, "AC6"=>$sec);


		foreach ($value_array as $key => $value) {
		  $activeSheet->setCellValue($key, $value);
		}





    $list_of_male = queryMysql("SELECT * FROM learner WHERE sec_id=$id AND gender='m' ORDER BY last_name ASC");//query all males
	$malecount = mysqli_num_rows($list_of_male);	

	$list_of_female = queryMysql("SELECT * FROM learner WHERE sec_id=$id AND gender='f' ORDER BY last_name ASC");//query all males
    $femalecount = mysqli_num_rows($list_of_female);

	$rowcount = $malecount+$femalecount+12;//add the first 10 rows plus breaker plus male and femALE to get the number of cells to wrap
		$wrap_name = "B11:C".$rowcount;
		 $activeSheet->getStyle($wrap_name)->getAlignment()->setWrapText(true);//WRAP TEXT all the names

    //make border
	$allbord_array = array("D9:AB10", "AC10:AD10", "A11:AJ".$rowcount);
			foreach ($allbord_array as $value) {
			  $activeSheet->getStyle($value)->applyFromArray($allborder);
			}


		//make border
 	$outbord_array = array("C4:E4","K4:O4", "X4:AC4", "C6:O6", "AC6:AH6", "X6:Y6", "A8:C10", "D8:AB8", "AC8:AD9", "AE8:AJ10");
		foreach ($outbord_array as $value) {
		  $activeSheet->getStyle($value)->applyFromArray($outborder);
		}


    //loop the male

	$i = 0;
	$cell = 10;

		do {
			$i++;//increment i
			$cell++;//increment the row number
			$cell2 = $cell-1;

			//merge important cells in each row as it loops
			// merge cells
			$ncell = "B".$cell.":"."C".$cell;
			$rcell = "AE".$cell.":"."AJ".$cell;
		$merge_array = array($ncell, $rcell);
		
			foreach ($merge_array as $value) {
				$activeSheet->mergeCells($value);
			}
		

      

		 $activeSheet->getRowDimension($cell)->setRowHeight(18);// set height of rows	

            $lid = $row['learner_id'];//learner_id2
            $pupil = Pupil::find($lid);
             $activeSheet->setCellValue("A".$cell, $i);
		     $activeSheet->setCellValue("B".$cell2, strtoupper($pupil->last_name.", ".$pupil->first_name." ".$pupil->middle_name));//set value
		  


        

		} while ($row = mysqli_fetch_assoc($list_of_male));



     

    //query female
    
		
	$i = 0;
	$cell = $malecount+11;

		do {
			$i++;//increment i
			$cell++;//increment the row number
			$cell2 = $cell-1;

			//merge important cells in each row as it loops
			// merge cells
			$ncell = "B".$cell.":"."C".$cell;
			$rcell = "AE".$cell.":"."AJ".$cell;
		$merge_array = array($ncell, $rcell);
		
			foreach ($merge_array as $value) {
				$activeSheet->mergeCells($value);
			}

			$activeSheet->getRowDimension($cell)->setRowHeight(20);// set height of rows	
			

            $lid = $row['learner_id'];//learner_id2
            $pupil = Pupil::find($lid);
             $activeSheet->setCellValue("A".$cell, $i);
		     $activeSheet->setCellValue("B".$cell2, strtoupper($pupil->last_name.", ".$pupil->first_name." ".$pupil->middle_name));//set value
		     //$activeSheet->mergeCells("$value");//merge
		     

		} while ($row = mysqli_fetch_assoc($list_of_female));



		//this is where you will set other values and appearance after to consecutive loops

          


      $rowcount = $malecount+$femalecount+13;//add the first 10 rows plus breaker plus male and femALE to get the number of cells to wrap
 		//this is the breaker
		$bcell = $malecount+11;
         $mtotal = $malecount."  <== MALE | TOTAL Per Day ==>";
         $ftotal = $femalecount."  <== FEMALE | TOTAL Per Day ==>";
         $tot = $malecount+$femalecount;
         $atotal = $tot."  <== COMBINED | TOTAL Per Day ==>";
        
        //unmerge it first
        $activeSheet->unmergeCells("B".$bcell.":"."C".$bcell);
        $activeSheet->mergeCells("A".$bcell.":"."C".$bcell);
        $activeSheet->setCellValue("A".$bcell, $mtotal);
        $activeSheet->getRowDimension($bcell)->setRowHeight(20);// set height of rows
        
        $rowcountt = $rowcount-1;
         $activeSheet->unmergeCells("B".$rowcountt.":"."C".$rowcountt);
        $activeSheet->mergeCells("A".$rowcountt.":"."C".$rowcountt);
         $activeSheet->setCellValue("A".$rowcountt, $ftotal);


        
        $activeSheet->mergeCells("A".$rowcount.":"."C".$rowcount);
         $activeSheet->setCellValue("A".$rowcount, $atotal);
   



		
		
		 
		//set the thick border

		$sr = 9;
		
		$st2 = "I".$sr.":"."I".$rowcount; 
		$st3 = "N".$sr.":"."N".$rowcount; 
		$st4 = "S".$sr.":"."S".$rowcount; 
		$st5 = "X".$sr.":"."X".$rowcount; 
		$st7 = "AD10".":"."AD".$rowcount; 
		$st8 = "AE8".":"."AE".$rowcount;

		$st1 = "D8".":"."AB".$rowcount;
		$st6 = "A".$bcell.":"."AJ".$bcell; 
		$st9 = "A".$rowcount.":"."AJ".$rowcount;
		$st10 = "AE8".":"."AJ".$rowcount;
		$st11 = "A".$rowcountt.":"."AJ".$rowcountt;
		$st12 = "D".$rowcount.":"."AB".$rowcount;
		$st13 = "A8".":"."AJ".$rowcount;

	
		
		

	    
 
// set width of all the columns
	  $w=10;
	  $x=5;
	 $col_array = array("A"=>5, "B"=>35, "C"=>5, "D"=>$x, "E"=>$x, "F"=>$x, "G"=>$x, "H"=>$x, "I"=>$x, "J"=>$x, "K"=>$x,
	  "L"=>$x, "M"=>$x, "N"=>$x, "O"=>$x, "P"=>$x, "Q"=>$x, "R"=>$x, "S"=>$x, "T"=>$x, "U"=>$x, "V"=>$x, "W"=>$x, "X"=>$x, 
	 	"Y"=>$x, "Z"=>$x, "AA"=>$x, "AB"=>$x, "AC"=>$w, "AD"=>$w, "AE"=>5, "AF"=>5, "AG"=>5, "AH"=>7, "AI"=>7, "AJ"=>13);
	
        //loop the subjects
		foreach($col_array as $key => $value)
		{
          $activeSheet->getColumnDimension($key)->setWidth($value);

		}




	   

		//fill
		 $fb = "A".$bcell.":"."AJ".$bcell;
		 $ff = "A".$rowcountt.":"."AJ".$rowcountt;
		 $tf = "A".$rowcount.":"."AJ".$rowcount;
		 $fill2_array = array($fb, $ff, "A8:AJ10");

		foreach ($fill2_array as $value) {            
		  $activeSheet->getStyle($value)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('D9D9D9');

      //this will make a darker fill for the total of male and female
	      $activeSheet->getStyle($tf)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('AEB2B6');

		}

		//set font sizes
		$font_array = array("A4:AJ6"=>10, "A2"=>16, "A3"=>7);
		foreach ($font_array as $key => $value) {
			$activeSheet->getStyle($key)->getFont()->setSize($value);
		}
     
        //summary
        $r1 = $rowcount+2;
        $r2 = $r1+1;
        $r3 = $r1+2; 
        $r4 = $r1+3; 
        $r5 = $r1+4; 
        $r6 = $r1+5; 
        $r7 = $r1+6;


        $r8 = $r1+7;
        $r9 = $r1+8; 
        $r10 = $r1+9; 
        $r11 = $r1+10; 
        $r12 = $r1+11; 
        $r13 = $r1+12;

        $r14 = $r1+13;
        $r15 = $r1+14; 
        $r16 = $r1+15; 
        $r17 = $r1+16; 
        $r18 = $r1+17; 
        $r19 = $r1+18;

        $r20 = $r1+19;
        $r21 = $r1+20; 
        $r22 = $r1+21; 
        $r23 = $r1+22; 
        $r24 = $r1+23; 
        $r25 = $r1+24;

        $r26 = $r1+25;
        $r27 = $r1+26; 
        $r28 = $r1+27; 
        $r29 = $r1+28; 
        $r30 = $r1+29; 
        $r31 = $r1+30;

        $r32 = $r1+31;
        $value_array = array("X4"=>"NOVEMBER", "A".$r1=>"GUIDELINES:", "Q".$r1=>"1. CODES FOR CHECKING ATTENDANCE", "AB".$r1=>"Month:",
        	"AE".$r1=>"No. of Days of Classes:", "AH".$r1=>"Summary", "A".$r2=>"1. The attendance shall be accomplished daily. Refer to the codes for checking learners' attendance.", "Q".$r2=>"(blank) - Present; (x)- Absent; Tardy (half shaded= Upper for", "AH".$r2=>"M","AI".$r2=>"F",
        	    "AJ".$r2=>"TOTAL", "A".$r3=>"2. Dates shall be written in the columns after Learner's Name.", 
        	    "Q".$r3=>"Late Commer, Lower for Cutting Classes)", "AB".$r3=>"* Enrolment  as of  (1st Friday of June)",
        	    "A".$r4=>"3. To compute the following:", "Q".$r4=>"2. REASONS/CAUSES FOR DROPPING OUT", "A".$r5=>"a.", "B".$r5=>"Percentage of Enrolment =",
        	    "D".$r5=>"Registered Learners as of end of the month", "N".$r5=>"x 100", "Q".$r5=>"a. Domestic-Related Factors", 
        	    "AB".$r5=>"Late Enrollment during the month (beyond cut-off)", "D".$r6=>"Enrolment as of 1st Friday of the school year", 
        	    "Q".$r6=>"a.1. Had to take care of siblings", "A".$r7=>"b.", "B".$r7=>"Average Daily Attendance = ", 
        	    "D".$r7=>"Total Daily Attendance", "Q".$r7=>"a.2. Early marriage/pregnancy", "AB".$r7=>"Registered Learners as of end of the month",
        	    "D".$r8=>"Number of School Days in reporting month", "Q".$r8=>"a.3. Parents' attitude toward schooling", "A".$r9=>"c.", 
        	    "B".$r9=>"Percentage of Attendance for the month =", "D".$r9=>"Average daily attendance", "Q".$r9=>"a.4. Family problems",
        	    "AB".$r9=>"Percentage of Enrolment as of end of the month", "D".$r10=>"Registered Learners as of end of the month", 
        	    "N".$r9=>"x 100", "A".$r12=>"4. Every end of the month, the class adviser will submit this form to the office of the principal for recording of summary table into School Form 4. Once signed by the principal, this form should be returned to the adviser.",
        	    "A".$r14=>"5. The adviser will provide neccessary interventions including but not limited to home visitation to learner/s who were absent for 5 consecutive days and/or those at risk of dropping out.", "A".$r16=>"6. Attendance performance of learners will be reflected in Form 137 and Form 138 every grading period.", "A".$r17=>"*", 
        	    "B".$r17=>"Beginning of School Year cut-off report is every 1st Friday of the School Year", 
        	    "Q".$r9=>"b. Individual-Related Factors", "Q".$r10=>"b.1. Illness", "Q".$r10=>"b.2. Overage", "Q".$r11=>"b.3. Death", 
        	    "Q".$r12=>"b.4. Drug Abuse", "Q".$r13=>"b.5. Poor academic performance", "Q".$r14=>"b.6. Lack of interest/Distractions", 
        	    "Q".$r15=>"b.7. Hunger/Malnutrition", "Q".$r16=>"c. School-Related Factors", "Q".$r17=>"c.1. Teacher Factor", 
        	    "Q".$r18=>"c.2. Physical condition of classroom", "Q".$r19=>"c.3. Peer influence", "Q".$r20=>"d. Geographic/Environmental", 
        	    "Q".$r21=>"d.1. Distance between home and school", "Q".$r22=>"d.2. Armed conflict (incl. Tribal wars & clanfeuds)", 
        	    "Q".$r23=>"d.3. Calamities/Disasters", "Q".$r24=>"e. Financial-Related", "Q".$r25=>"e.1. Child labor, work", 
        	    "Q".$r26=>"f. Others (Specify)", "AB".$r11=>"Average Daily Attendance", "AB".$r13=>"Percentage of Attendance for the month",
        	    "AB".$r15=>"Number of students absent for 5 consecutive days:", "AB".$r17=>"Drop out", "AB".$r19=>"Transferred out", 
        	    "AB".$r21=>"Transferred in","AB".$r24=>"I certify that this is a true and correct report.", 
				 "AD".$r27=>"(Signature of Teacher over Printed Name)", "AB".$r29=>"Attested by:", 
				 "AD".$r31=>"(Signature of School Head over Printed Name)", "AD".$r26=>$sec_adviser, "AD".$r30=>$schoolhead
        	    );
  
			foreach ($value_array as $key => $value) {
			 $activeSheet->setCellValue($key, $value);
			}
		


 	//set allignment to left
		$left_array = array("A11:C".$rowcount, "A".$r1.":"."AJ".$r31);

			foreach ($left_array as $value) {
			   $activeSheet->getStyle($value)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}
      
      //set allignment to right
		$right_array = array("B4", "B6", "F4", "P4", "P6", "Z6", "A".$r5.":"."A".$r10, "A".$r17);

			foreach ($right_array as $value) {
			   $activeSheet->getStyle($value)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}



      
		// merge cells
		$merge_array = array("A2:AJ2", "A3:AJ3", "C4:E4", "F4:J4", "K4:O4", "X4:AC4", "P4:W4", "C6:O6", "Z6:AB6", "P6:W6",
			"AC6:AH6", "X6:Y6", "A8:C9", "A10:C10", "D8:AB8", "AC8:AD9", "AE8:AJ10", "A".$r5.":"."A".$r6, "B".$r5.":"."C".$r6, "N".$r5.":"."O".$r6,
			"D".$r5.":"."M".$r5, "A".$r7.":"."A".$r8, "B".$r7.":"."C".$r8, "D".$r6.":"."M".$r6, "D".$r7.":"."M".$r7, "D".$r8.":"."M".$r8,
			 "D".$r9.":"."M".$r9, "D".$r10.":"."M".$r10, "A".$r9.":"."A".$r10, "B".$r9.":"."C".$r10, "N".$r9.":"."N".$r10, "A".$r12.":"."M".$r13,
			 "A".$r14.":"."M".$r15,  "Q".$r2.":"."Z".$r2, "Q".$r3.":"."Z".$r3, "AB".$r1.":"."AD".$r2, "AE".$r1.":"."AG".$r2, 
			 "AH".$r1.":"."AJ".$r1, "AB".$r3.":"."AG".$r4, "AB".$r5.":"."AG".$r6, "AB".$r7.":"."AG".$r8, "AB".$r9.":"."AG".$r10, 
			 "AB".$r11.":"."AG".$r12, "AB".$r13.":"."AG".$r14, "AB".$r15.":"."AG".$r16, "AB".$r17.":"."AG".$r18, "AB".$r19.":"."AG".$r20,
			 "AB".$r21.":"."AG".$r22, "AH".$r3.":"."AH".$r4,"AH".$r5.":"."AH".$r6, "AH".$r7.":"."AH".$r8, "AH".$r9.":"."AH".$r10, 
			 "AH".$r11.":"."AH".$r12, "AH".$r13.":"."AH".$r14, "AH".$r15.":"."AH".$r16, "AH".$r17.":"."AH".$r18, "AH".$r19.":"."AH".$r20,
			 "AH".$r21.":"."AH".$r22,  "AI".$r3.":"."AI".$r4, "AI".$r5.":"."AI".$r6, "AI".$r7.":"."AI".$r8, 
			 "AI".$r9.":"."AI".$r10, "AI".$r11.":"."AI".$r12, "AI".$r13.":"."AI".$r14, "AI".$r15.":"."AI".$r16, "AI".$r17.":"."AI".$r18,
			 "AI".$r19.":"."AI".$r20, "AI".$r21.":"."AI".$r22,
			 "AJ".$r3.":"."AJ".$r4, "AJ".$r5.":"."AJ".$r6, "AJ".$r7.":"."AJ".$r8, 
			 "AJ".$r9.":"."AJ".$r10, "AJ".$r11.":"."AJ".$r12, "AJ".$r13.":"."AJ".$r14, "AJ".$r15.":"."AJ".$r16, "AJ".$r17.":"."AJ".$r18,
			 "AJ".$r19.":"."AJ".$r20, "AJ".$r21.":"."AJ".$r22, "AD".$r27.":"."AJ".$r27,"AD".$r31.":"."AJ".$r31, "AD".$r26.":"."AJ".$r26,
			 "AD".$r30.":"."AJ".$r30
			 );
		
	
		foreach ($merge_array as $value) {
			$activeSheet->mergeCells($value);
		}



		//set allignment to center
		$center_array = array("A".$bcell, "A".$rowcountt, "A".$rowcount, "D".$r10.":"."M".$r10, "D".$r9.":"."M".$r9, "D".$r8.":"."M".$r8,
			"D".$r7.":"."M".$r7, "D".$r5.":"."M".$r5, "D".$r6.":"."M".$r6, "Q".$r2.":"."Z".$r2, "Q".$r3.":"."Z".$r3, "AB".$r1.":"."AJ".$r22,
			"AD".$r26.":"."AJ".$r31);
		foreach ($center_array as $value) {
			//set to center allignment
			$activeSheet->getStyle($value)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		}



		$wrap_name = "B11:C".$rowcount;
		$wrap_array = array($wrap_name, "AE8", "A".$r12.":"."M".$r13, "A".$r14.":"."M".$r15, "AB".$r1.":"."AJ".$r22);
		foreach ($wrap_array as $value) {
			$activeSheet->getStyle($value)->getAlignment()->setWrapText(true);//WRAP TEXT all the names
		 }


      //height
	   $sh = 13;//$sh height of summary rows
		$height_array = array(5=>10, 1=>3, 7=>10, 4=>15, 6=>15, 2=>30, 3=>15, 1=>0, 8=>15, 9=>15, 10=>15, $rowcount=>20, $r1=>$sh, $r2=>$sh, 
			$r3=>$sh, $r4=>$sh, $r5=>$sh, $r6=>$sh, $r7=>$sh, $r8=>$sh, $r9=>$sh, $r10=>$sh, $r11=>$sh, $r12=>$sh, $r13=>$sh, $r14=>$sh, 
			$r15=>$sh, $r16=>$sh, $r17=>$sh, $r16=>$sh, $r17=>$sh, $r18=>$sh, $r19=>$sh, $r20=>$sh, $r21=>$sh, $r22=>$sh, $r23=>$sh, $r24=>$sh,
			$r25=>$sh, $r26=>$sh, $r27=>$sh, $r28=>$sh, $r29=>$sh, $r30=>$sh, $r31=>$sh, $r32=>$sh);

		foreach ($height_array as $key => $value) {
			$activeSheet->getRowDimension($key)->setRowHeight($value);//dummy values
		}




        
        $sumbox = "Q".$r1.":"."Z".$r28;
        $bot1 = "D".$r5.":"."M".$r5;
        $bot2 = "D".$r9.":"."M".$r9;
        $bot3 = "D".$r7.":"."M".$r7;
        $st14 = "AC".$sr.":"."AC".$rowcount; 
        $st15 = "D".$rowcount.":"."AB".$rowcount;
        $st16 = "AB".$r1.":"."AJ".$r22; 
        $st17 = "AB".$r1.":"."AJ".$r2;
        $st18 = "AB".$r3.":"."AJ".$r22;
        $st19 = "AD".$r26.":"."AJ".$r26;
        $st20 = "AD".$r30.":"."AJ".$r30;

       $all_border = array($st1=>$thickborder, $st6=>$thickborder, "D9:AB10"=>$thickborder, "AC10:AD10"=>$thickborder, "A8:AJ10"=>$thickborder, 
       	$st9=>$thickborder, $st11=>$thickborder, $st13=>$thickborder, $sumbox=>$thickborder, $st1=>$leftborder, $st2=>$leftborder, 
       	$st3=>$leftborder, $st4=>$leftborder, $st5=>$leftborder, $st7=>$leftborder, $st8=>$leftborder, $st12=>$allborder, $bot1=>$bottomborder,
       	$bot2=>$bottomborder, $bot3=>$bottomborder, "AC8:AD9"=>$thickborder, $st14=>$thickborder, $st15=>$thickborder, $st16=>$allborder, 
       	$st17=>$allthick, $st18=>$thickborder, $st19=>$bottomborder, $st20=>$bottomborder);

        foreach ($all_border as $key=>$value) {
       	$activeSheet->getStyle($key)->applyFromArray($value);
       }




		//make text bold
		$bold_array = array("A8:AJ10", "B4", "B6", "F4", "P4", "P6", "Z6", "A".$bcell, "A".$rowcountt, "A".$rowcount, "Q".$r1, "Q".$r4, 
			"Q".$r5,"Q".$r9, "Q".$r16, "Q".$r24, "Q".$r26,"A".$r1, $st17, "AB".$r17.":"."AB".$r22, "AD".$r26, "AD".$r30);
 
			foreach ($bold_array as $value) {
			  $activeSheet->getStyle($value)->getFont()->setBold(true);
	
			}



		$image_array = array("deped.png|100|A1", "school.png|100|AH1");

		foreach ($image_array as $value) {
			list($img, $h, $coor) = explode('|', $value);
		    $objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath("images/$img");
			$objDrawing->setHeight($h);
			$objDrawing->setCoordinates($coor);
			$objDrawing->setWorksheet($activeSheet);
		}	


		$sec_name = $gr."_".$sec;
		
		// Give spreadsheet a title
		//$activeSheet->setTitle('VI-Capricorn (SF1)');
		
		// Generate Excel file and download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$fl = $sec_name.'_SF2.xlsx';
		header("Content-Disposition: attachment;filename=$fl");
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel2007');
		ob_end_clean();
		$writer->save('php://output');
		exit;
	} catch (Exception $e) {
		$error = $e->getMessage();
	}
	
}


































	if ($user_access==1 OR $ara == TRUE) {
		$id = $_GET['137'];
		require_once 'src/PHPExcel.php';
	
	try {


		$sheet = new PHPExcel();
		// Set metadata
		$sheet->getProperties()->setCreator("learner=".$sec_id_learner." fac=".$sec_id_fac)
		                       ->setLastModifiedBy('www.scdesign.ph')
		                       ->setTitle('Permanent Record')
		                       ->setKeywords('137 permanent record');
		
		// Set default settings
		$sheet->getDefaultStyle()->getAlignment()->setVertical(
	            PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getDefaultStyle()->getAlignment()->setHorizontal(
				PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getDefaultStyle()->getFont()->setName('Cambria');
		$sheet->getDefaultStyle()->getFont()->setSize(7);
		//$sheet->getDefaultRowDimension()->setRowHeight(11);
	
        
		// Get reference to active spreadsheet in workbook
		$sheet->setActiveSheetIndex(0);
		$activeSheet = $sheet->getActiveSheet();

        
		$activeSheet->getProtection()->setSheet(true);
		$activeSheet->getProtection()->setSort(true);
		$activeSheet->getProtection()->setInsertRows(true);
		$activeSheet->getProtection()->setFormatCells(true);
		$activeSheet->getProtection()->setPassword('sidandchloe');
     


		$styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);
		$styleArray2 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('argb' => '221E1F'),),),);
		$outborder = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);
        $botborder = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '221E1F'),),),);
        $thickborder = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('argb' => '221E1F'),),),);
		

		//getDefaultRowDimension()->setRowHeight(-1);
		
       

		// Set print options
		$activeSheet->getPageSetup()->setOrientation(
	            PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
				->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
				
		
		$activeSheet->getPageMargins()->setTop(0.25);
		$activeSheet->getPageMargins()->setRight(0.25);
		$activeSheet->getPageMargins()->setLeft(0.25);
		$activeSheet->getPageMargins()->setBottom(0.25);

		
		
		
		// set width of all the columns
	  $w=6;
	 $col_array = array("A"=>"5", "B"=>"11", "C"=>"10.8", "D"=>"4.8", "E"=>"4.8", "F"=>"4.8", "G"=>"4.8", "H"=>"6", "I"=>"6", "J"=>"12",
	 	                "K"=>"7", "L"=>"5", "M"=>"11", "N"=>"10.8", "O"=>"4.8", "P"=>"4.8", "Q"=>"4.8", "R"=>"4.8", "S"=>"6", "T"=>"6",
	 	                "U"=>"12", "V"=>"1.4", "W"=>"17", "AA"=>$w, "AB"=>$w, "AC"=>$w, "AD"=>$w, "AE"=>$w, "AF"=>$w, "AG"=>$w, 
	 	                "AH"=>$w, "AI"=>$w, "AJ"=>$w, "AK"=>$w,"AL"=>$w,"AM"=>$w, "AN"=>$w, "AO"=>$w, "X"=>"10", "Y"=>"9", "Z"=>"20");
	
        //loop the subjects
		foreach($col_array as $key => $value)
		{
          $activeSheet->getColumnDimension($key)->setWidth($value);

		}


		

		//set height of all cells
		$i = 1;
		do {
			$i++;
		    $activeSheet->getRowDimension($i)->setRowHeight(10.5);
		} while ($i < 85);
       
        

     
    

		//apply color fill
		$fill1_array = array("A31", "L31", "J31", "U31", "A44:B44", "J44", "L44:N44", "U44", "A49", "J49", "A63:C63", "J63", "L49", "U49", 
			"L63:N63","U63", "A68", "J68", "A82:C82", "J82", "L68", "U68", "L82:N82", "U82", "W3:Z4", "W31:Z32");
 
			foreach ($fill1_array as $value) {
			  $activeSheet->getStyle($value)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		    ->getStartColor()->setARGB('BFBFBF');
	
			} 

	    $fill2_array = array("D31:I32", "D44:I44", "D49:I50", "D63:I63", "D31:I32", "D68:I69", "D82:I82", "O31:T32", "O44:T44", "O49:T50", "O63:T63", 
	    	                  "O68:T69", "O82:T82", "AA3:AO4", "AA31:AO32", "W63:AO65");
 
			foreach ($fill2_array as $value) {            
			  $activeSheet->getStyle($value)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		    ->getStartColor()->setARGB('D9D9D9');
	
			}
    //fetch school data
	$result = queryMysql("SELECT * FROM school_data  WHERE idofskul=1");
     if (mysqli_num_rows($result))
	    {
	        $row = mysqli_fetch_row($result);
            $reg= strtoupper("region ".$row[3]. "(".$row[9].")");
            $div= strtoupper("division of ".$row[4]);
            $dis= strtoupper("district ".$row[5]);
            $tagdiv= strtoupper("(sangay ng ".$row[10].")");
            $school =strtoupper($row[1]);
             $division= strtoupper($row[4]);
           
	    }




		//set subjects
	    $fil="Filipino";$eng="English";$math="Mathematics";$sci="Science";$ap="Araling Panlipunan";$tle="EPP/TLE";$mapeh="MAPEH";
	    $mu="Music";$art="Art";$pe="Physical Education";$he="Health";$esp="Edukasyon sa Pagpapakatao";$mtb="Mother Tongue";
	    $eli="Eligible for Admision to Grade";
	    $gen_date = date("F j, Y");$rq_school = "BINAYOYO ELEMENTARY SCHOOL";



	    //set values of static values
		$val_array = array("A1"=>"DepEd Form 137-E", "A2"=>"REPUBLIC OF THE PHILIPPINES", "A3"=>"(REPUBLIKA NG PILIPINAS)", 
			                "A4"=>"DEPARTMENT OF EDUCATION", "A5"=>"(KAGAWARAN NG EDUKASYON)", "A7"=>"BUREAU OF ELEMENTARY EDUCATION",
			                "A8"=>"(KAWANIHAN NG EDUKASYONG ELEMENTARYA)", "A16"=>"ELEMENTARY SCHOOL PERMANENT RECORD", 
			                "A17"=>"(PALAGIANG TALAAN SA MABABANG PAARALAN)", "A18"=>"I.", "A20"=>"(Pangalan:)", "N20"=>"(Paaralan:)",
			                "J20"=>"(Sangay:)", "A22"=>"(Kasarian:)", "C22"=>"(Petsa ng Kapanganakan:)", "I22"=>"(Lugar ng Kapanganakan:)",
			                "A23"=>"Parent or Guardian:", "A24"=>"(Magulang o Tagapag-alaga:)", "J24"=>"(Hanapbuhay:)", "N24"=>"(Tirahan:)",
			                "B26"=>"ELEMENTARY SCHOOL PROGRESS", "B27"=>"(PAG-UNLAD SA MABABANG PAARALAN)",  "D32"=>"1",
			                "E32"=>"2", "F32"=>"3", "G32"=>"4", "O22"=>"(Petsa ng Pagpasok:)", "A29"=>"Grade: I", "A31"=>"LEARNING AREAS",
			     			 "D31"=>"Periodic Rating","H31"=>"FINAL RATING", "J31"=>"REMARKS", "B44"=>"General Average", "L29"=>"Grade: II", 
			     			"L31"=>"LEARNING AREAS", "O31"=>"Periodic Rating","S31"=>"FINAL RATING", "U31"=>"REMARKS","M44"=>"General Average", 
			     			"A47"=>"Grade: III", "A49"=>"LEARNING AREAS", "D49"=>"Periodic Rating","H49"=>"FINAL RATING", "J49"=>"REMARKS",
			     			"B63"=>"General Average", "L47"=>"Grade: IV", "L49"=>"LEARNING AREAS","O49"=>"Periodic Rating","S49"=>"FINAL RATING",
			    			  "U49"=>"REMARKS","M63"=>"General Average","A66"=>"Grade: V", "A68"=>"LEARNING AREAS", "D68"=>"Periodic Rating",
			    			 "H68"=>"FINAL RATING", "J68"=>"REMARKS","B82"=>"General Average", "L66"=>"Grade: VI", "L68"=>"LEARNING AREAS",
			    			 "O68"=>"Periodic Rating","S68"=>"FINAL RATING", "U68"=>"REMARKS","M82"=>"General Average", "A33"=>$fil, "L33"=>$fil,
			    			 "A51"=>$fil, "L51"=>$fil, "A70"=>$fil, "L70"=>$fil,"A34"=>$eng, "L34"=>$eng, "A52"=>$eng, "L52"=>$eng, 
			                 "A71"=>$eng, "L71"=>$eng, "A35"=>$math, "L35"=>$math, "A53"=>$math, "L53"=>$math, "A72"=>$math, "L72"=>$math,
			                   "A36"=>$ap, "L36"=>$ap, "A54"=>$sci, "L54"=>$sci, "A73"=>$sci, "L73"=>$sci, "A37"=>$mapeh, "L37"=>$mapeh, 
			                  "A55"=>$ap, "L55"=>$ap, "A74"=>$ap, "L74"=>$ap, "B38"=>$mu, "M38"=>$mu, "M39"=>$art, "A56"=>$mapeh, 
			                  "L56"=>$tle, "L57"=>$mapeh, "B39"=>$art, "B40"=>$pe, "M40"=>$pe, "B41"=>$he, "M41"=>$he, "A42"=>$mtb, 
			                  "A43"=>$esp, "L42"=>$mtb, "L43"=>$esp, "M58"=>$mu, "M59"=>$art, "M60"=>$pe, "M61"=>$he, "L62"=>$esp,
			                  "B57"=>$mu, "B58"=>$art, "B59"=>$pe, "B60"=>$he, "A61"=>$mtb, "A62"=>$esp, "A75"=>$tle, "A76"=>$mapeh, 
			                  "B77"=>$mu, "B78"=>$art, "B79"=>$pe, "B80"=>$he, "A81"=>$esp, "L75"=>$tle, "L76"=>$mapeh, "M77"=>$mu,
			                  "M78"=>$art, "M79"=>$pe, "M80"=>$he, "L81"=>$esp, "A45"=>$eli, "L45"=>$eli, "A64"=>$eli, "L64"=>$eli,
			                  "A83"=>$eli, "L83"=>$eli, "A84"=>"This record was issued upon the request of LORES ELEMENTARY SCHOOL.", 
			                  "O32"=>"1", "P32"=>"2", "Q32"=>"3", "R32"=>"4", "O50"=>"1", "P50"=>"2", "Q50"=>"3", "R50"=>"4",
			                  "O69"=>"1", "P69"=>"2", "Q69"=>"3", "R69"=>"4" , "D50"=>"1", "E50"=>"2", "F50"=>"3", "G50"=>"4",
			                  "D69"=>"1", "E69"=>"2", "F69"=>"3", "G69"=>"4", "W1"=>"III. REPORT ON LEARNER'S OBSERVED VALUES",
			                  "W3"=>"Core Values", "Y3"=>"Behavior Statements", "AA4"=>"1", "AB4"=>"2", "AC4"=>"3", "AD4"=>"4", 
			                  "AE4"=>"F.R.", "AF4"=>"1", "AG4"=>"2", "AH4"=>"3", "AI4"=>"4", "AJ4"=>"F.R.", "AK4"=>"1", "AL4"=>"2",
			                  "AM4"=>"3", "AN4"=>"4", "AO4"=>"F.R.","AA32"=>"1", "AB32"=>"2", "AC32"=>"3", "AD32"=>"4", "AE32"=>"F.R.", 
			                  "AF32"=>"1", "AG32"=>"2", "AH32"=>"3", "AI32"=>"4", "AJ32"=>"F.R.", "AK32"=>"1", "AL32"=>"2","AM32"=>"3", 
			                  "AN32"=>"4", "AO32"=>"F.R.", 
			                  "Y5"=>"Expresses one's spiritual beliefs while respecting the spiritual beliefs of others",
			                  "Y8"=>"Shows adherence to ethical principles by uplholding truth", 
			                  "Y11"=>"Is sensitive to individual, social, and cultural differences",
			                  "Y14"=>"Demonstrates contributions toward solidarity",
			                  "Y17"=>"Cares for the environment and utilizes resources wisely, judciously, and economically",
			                  "Y21"=>"Demonstrates pride in being a Filipino; exercises the right and responsibilities of a Filipino citizen",
			                  "Y26"=>"Demonstrates appropriate behavior in carrying out activities in the school, community, and country",
			                  "Y33"=>"Expresses one's spiritual beliefs while respecting the spiritual beliefs of others",
			                  "Y36"=>"Shows adherence to ethical principles by uplholding truth", 
			                  "Y39"=>"Is sensitive to individual, social, and cultural differences",
			                  "Y42"=>"Demonstrates contributions toward solidarity",
			                  "Y45"=>"Cares for the environment and utilizes resources wisely, judciously, and economically",
			                  "Y49"=>"Demonstrates pride in being a Filipino; exercises the right and responsibilities of a Filipino citizen",
			                  "Y54"=>"Demonstrates appropriate behavior in carrying out activities in the school, community, and country",
			                  "Y31"=>"Behavior Statements", "W31"=>"Core Values", "W5"=>"1. MAKA-DIYOS", "W11"=>"2. MAKATAO", 
			                  "W17"=>"3. MAKA KALIKASAN", "W21"=>"4. MAKA BANSA", "W33"=>"1. MAKA-DIYOS", "W39"=>"2. MAKATAO", 
			                  "W45"=>"3. MAKA KALIKASAN", "W49"=>"4. MAKA BANSA", "W63"=>"Grade Level", "X63"=>"No. of School Days",
			                  "Z63"=>"No. of School Days Absent", "AA63"=>"Cause of Absent", "AM63"=>"No. of School Days Present", 
			                  "X76"=>"Certificate of Transfer", "X77"=>"TO WHOM IT MAY CONCERN:", 
			                  "Z79"=>"This is to certify that this is a true record of the Elementary School Permanent", 
			                  "X80"=>"Record of", "AI80"=>". He/She is eligible for", "X81"=>"transfer and admission to Grade/Year", "AE81"=>".",
			                  "W62"=>"IV. ATTENDANCE RECORD", "A26"=>"II.", "AI84"=>"In-Charge of Records", "Z84"=>"Date", "Z83"=>$gen_date, "A19"=>"Name:",
			                  "J19"=>"Division:", "N19"=>"School:", "A21"=>"Sex:", "C21"=>"Date of Birth:", "I21"=>"Place of Birth:", "O21"=>"Date of Entrance:",
			                  "J23"=>"Occupation:", "N23"=>"Address:");




		 //loop values
		foreach($val_array as $key => $value)
		{
          $activeSheet->setCellValue($key, $value);

		}
 
        

       //fetch dynamic values here
	
            
            $pupil = Pupil::find($id);
	  
	        $ln= strlen($pupil->middle_name);$li=$ln-1;$mi =substr($pupil->first_name,0, -$li).".";
	        $learner_name= strtoupper($pupil->last_name.", ".$pupil->first_name." ".$mi);
	        $name = strtoupper($pupil->first_name." ".$pupil->middle_name." ".$pupil->last_name);
	        $gender = strtoupper($pupil->gender);
	        $birth_place= strtoupper($pupil->birth_province);
	        $entry= $pupil->entry_date;
	        $father= strtoupper($pupil->frname." ".$pupil->frlast);
	        if($pupil->guardian){$guardian=$father;}else{$guardian= strtoupper($pupil->guardian);}
	        $bday = $pupil->month."/".$pupil->day."/".$pupil->year;
	        $occupation= strtoupper($pupil->froccupation);
	        if($pupil->froccupation = ""){$occupation= strtoupper($pupil->mroccupation);}
	        $address = strtoupper($pupil->stsubd.", ".$pupil->barangay.", ".$pupil->municipality);
	        $lrn= strtoupper("LRN: ".$pupil->lrn);
	        $fname = str_replace(" ", "",$pupil->last_name);
	        $fname = rtrim ($fname);


        $val_array = array("C19"=>$learner_name, "K21"=>$birth_place, "K19"=>"division", "O19"=>"school", "B21"=>$gender, "S21"=>$entry, 
        	"D23"=>$guardian, "E21"=>$bday, "K23"=>$occupation, "O23"=>$address, "A10"=>$reg, "A11"=>$div, "A12"=>$tagdiv, "A13"=>$dis,
        	 "A14"=>$school, "K19"=>$division, "O19"=>$school, "P1"=>$lrn, "Y80"=>$name);
	        foreach($val_array as $key => $value)
				{
		          $activeSheet->setCellValue($key, $value);

				}
    
		//end of info

     
      
     
       //set formula for each cell average and check if learner passed or not
	    $frml_array= array("H33"=>"=SUM(D33:G33)/4", "H34"=>"=SUM(D34:G34)/4", "H35"=>"=SUM(D35:G35)/4","H36"=>"=SUM(D36:G36)/4",
	    	              "H37"=>"=SUM(D37:G37)/4","H42"=>"=SUM(D42:G42)/4", "H43"=>"=SUM(D43:G43)/4", "H44"=>"=SUM(H3:H43)/7",
	    	              "S33"=>"=SUM(O33:R33)/4", "S34"=>"=SUM(O34:R34)/4", "S35"=>"=SUM(O35:R35)/4","S36"=>"=SUM(O36:R36)/4",
	    	              "S37"=>"=SUM(O37:R37)/4","S42"=>"=SUM(O42:R42)/4", "S43"=>"=SUM(O43:R43)/4", "S44"=>"=SUM(S3:S43)/7",
	    	              "H51"=>"=SUM(D51:G51)/4", "H52"=>"=SUM(D52:G52)/4", "H53"=>"=SUM(D53:G53)/4","H54"=>"=SUM(D54:G54)/4",
	    	              "H55"=>"=SUM(D55:G55)/4","H56"=>"=SUM(D56:G56)/4", "H61"=>"=SUM(D61:G61)/4", "H62"=>"=SUM(D62:G62)/4", 
	    	              "H63"=>"=SUM(H51:H62)/7",
	    	              "S51"=>"=SUM(O51:R51)/4", "S52"=>"=SUM(O52:R52)/4", "S53"=>"=SUM(O53:R53)/4","S54"=>"=SUM(O54:R54)/4",
	    	              "S55"=>"=SUM(O55:R55)/4","S56"=>"=SUM(O56:R56)/4", "S57"=>"=SUM(O57:R57)/4", "S62"=>"=SUM(O62:R62)/4", 
	    	              "S63"=>"=SUM(S51:S62)/8",
	    	              "H70"=>"=SUM(D70:G70)/4", "H71"=>"=SUM(D71:G71)/4", "H72"=>"=SUM(D72:G72)/4","H73"=>"=SUM(D73:G73)/4",
	    	              "H74"=>"=SUM(D74:G74)/4", "H75"=>"=SUM(D75:G75)/4", "H76"=>"=SUM(D76:G76)/4", "H81"=>"=SUM(D81:G81)/4", 
	    	              "H82"=>"=SUM(H70:H81)/8", 
	    	              "S70"=>"=SUM(O70:R70)/4", "S71"=>"=SUM(O71:R71)/4", "S72"=>"=SUM(O72:R72)/4","S73"=>"=SUM(O73:R73)/4",
	    	              "S74"=>"=SUM(O74:R74)/4", "S75"=>"=SUM(O75:R75)/4", "S76"=>"=SUM(O76:R76)/4", "S81"=>"=SUM(O81:R81)/4", 
	    	              "S82"=>"=SUM(S70:S81)/8",
	    	              "J33"=>'=IF(H33<75, "Retained", "Passed")',
	    	               "J34"=>'=IF(H34<75, "Retained", "Passed")',
	    	              "J35"=>'=IF(H35<75, "Retained", "Passed")',
	    	               "J36"=>'=IF(H36<75, "Retained", "Passed")',
	    	              "J37"=>'=IF(H37<75, "Retained", "Passed")',
	    	              "J42"=>'=IF(H42<75, "Retained", "Passed")',
	    	              "J43"=>'=IF(H43<75, "Retained", "Passed")',
	    	              "J44"=>'=IF(H44<75, "Retained", "Passed")',
	    	                "U33"=>'=IF(S33<75, "Retained", "Passed")',
	    	               "U34"=>'=IF(S34<75, "Retained", "Passed")',
	    	              "U35"=>'=IF(S35<75, "Retained", "Passed")',
	    	               "U36"=>'=IF(S36<75, "Retained", "Passed")',
	    	              "U37"=>'=IF(S37<75, "Retained", "Passed")',
	    	              "U42"=>'=IF(S42<75, "Retained", "Passed")',
	    	              "U43"=>'=IF(S43<75, "Retained", "Passed")',
	    	              "U44"=>'=IF(S44<75, "Retained", "Passed")',
	    	              "J51"=>'=IF(H51<75, "Retained", "Passed")',
	    	               "J52"=>'=IF(H52<75, "Retained", "Passed")',
	    	              "J53"=>'=IF(H53<75, "Retained", "Passed")',
	    	               "J54"=>'=IF(H54<75, "Retained", "Passed")',
	    	              "J55"=>'=IF(H55<75, "Retained", "Passed")',
	    	              "J56"=>'=IF(H56<75, "Retained", "Passed")',
	    	              "J61"=>'=IF(H61<75, "Retained", "Passed")',
	    	              "J62"=>'=IF(H62<75, "Retained", "Passed")',
	    	               "J63"=>'=IF(H63<75, "Retained", "Passed")',

	    	               "U51"=>'=IF(S51<75, "Retained", "Passed")',
	    	               "U52"=>'=IF(S52<75, "Retained", "Passed")',
	    	              "U53"=>'=IF(S53<75, "Retained", "Passed")',
	    	               "U54"=>'=IF(S54<75, "Retained", "Passed")',
	    	              "U55"=>'=IF(S55<75, "Retained", "Passed")',
	    	              "U56"=>'=IF(S56<75, "Retained", "Passed")',
	    	               "U57"=>'=IF(S57<75, "Retained", "Passed")',
	    	              "U62"=>'=IF(S62<75, "Retained", "Passed")',
	    	               "U63"=>'=IF(S63<75, "Retained", "Passed")',

	    	                "J70"=>'=IF(H70<75, "Retained", "Passed")',
	    	               "J71"=>'=IF(H71<75, "Retained", "Passed")',
	    	              "J72"=>'=IF(H72<75, "Retained", "Passed")',
	    	               "J73"=>'=IF(H73<75, "Retained", "Passed")',
	    	              "J74"=>'=IF(H74<75, "Retained", "Passed")',
	    	              "J75"=>'=IF(H75<75, "Retained", "Passed")',
	    	              "J76"=>'=IF(H76<75, "Retained", "Passed")',
	    	              "J81"=>'=IF(H81<75, "Retained", "Passed")',
	    	               "J82"=>'=IF(H82<75, "Retained", "Passed")',


	    	                "U70"=>'=IF(S70<75, "Retained", "Passed")',
	    	               "U71"=>'=IF(S71<75, "Retained", "Passed")',
	    	              "U72"=>'=IF(S72<75, "Retained", "Passed")',
	    	               "U73"=>'=IF(S73<75, "Retained", "Passed")',
	    	              "U74"=>'=IF(S74<75, "Retained", "Passed")',
	    	              "U75"=>'=IF(S75<75, "Retained", "Passed")',
	    	               "U76"=>'=IF(S76<75, "Retained", "Passed")',
	    	              "U81"=>'=IF(S81<75, "Retained", "Passed")',
	    	               "U82"=>'=IF(S82<75, "Retained", "Passed")',


	    	               "E45"=>'=IF(H44<75, "ONE", "TWO")',
	    	                "P45"=>'=IF(S44<75, "TWO", "THREE")',
	    	                "E64"=>'=IF(H63<75, "THREE", "FOUR")',
	    	                "P64"=>'=IF(S63<75, "FOUR", "FIVE")',

	    	                "E83"=>'=IF(H82<75, "FIVE", "SIX")',
	    	                "P83"=>'=IF(S82<75, "SIX", "SEVEN")',
	    	                "AA81"=>'=IF(P83="SEVEN", "SEVEN", IF(E83="SIX", "SIX", IF(P64="FIVE", "FIVE", IF(E64="FOUR", "FOUR", IF(P45="THREE", "THREE", IF(E45="TWO", "TWO", "ONE"))))))'

	    	                );


        foreach($frml_array as $key => $value)
			{
	          $activeSheet->setCellValue($key, $value);

			}



           //set format to whole numbers for all grades
			$wnumbr_array= array("D32:U82");
             foreach($wnumbr_array as $value)
			{
	           $activeSheet->getStyle($value)->getNumberFormat()->setFormatCode('##');

			}
        

       /* //set format to whole numbers for all grades
			$prom= array("");
             foreach($prom as $value)
			{
				list($q1,$q2,$q3,$q4) = explode('|', $value);

	           $activeSheet->setCellValue($key, $value);

			}
			*/
			
        
		//start of grades
         $result = queryMysql("SELECT * FROM pupils_grade WHERE learner_id=$id");
    	while ($row = mysqli_fetch_row($result))
					{  	$gr= ($row[3]);
						$sy= ($row[2]);
						$qr= ($row[4]);
						$fil= ($row[5]);
						$eng= ($row[6]);
						$mat= ($row[7]);
						$sci= ($row[8]);
						$ap= ($row[9]);
						$tle= ($row[10]);
						$mus= ($row[11]);
						$art= ($row[12]);
						$phy= ($row[13]);
						$hea= ($row[14]);
						$mtb= ($row[15]);
						$esp= ($row[16]);
						$map = ($art+$phy+$hea+$mus)/4;
						$s_i=$row[17];
                        $prev_skul="hell";
						$result2 = queryMysql("SELECT * FROM school_data WHERE idofskul=$s_i");
						    if (mysqli_num_rows($result2)){$row = mysqli_fetch_assoc($result2);$prev_skul= strtoupper($row["school_name"]);}
						//for grade 1
						if($gr==1)
								{
 
                            if($qr==1){$col="D";}elseif($qr==2){$col="E";}elseif($qr==3){$col="F";}elseif($qr==4){$col="G";}
							$l1=$col."33";$l2=$col."34";$l3=$col."35";$l4=$col."36";$l5=$col."37";$l6=$col."38";$l7=$col."39";$l8=$col."40";
							$l9=$col."41";$l10=$col."42";$l11=$col."43";$l12="A30";$l13="C29";
                            if($sy==""){$l12="X85";}//if sy hs no value of other quARTER

					        $val_array= array($l1=>$fil,$l2=>$eng,$l3=>$mat, $l4=>$ap, $l5=>$map,$l6=>$mus,$l7=>$art, 
					         $l8=>$phy, $l9=>$hea,$l10=>$mtb, $l11=>$esp, $l12=>"SY: ".$sy, $l13=>"School: ".$prev_skul);

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }
													  
						//for grade 2
						if($gr==2)
								{
 
                            if($qr==1){$col="O";}elseif($qr==2){$col="P";}elseif($qr==3){$col="Q";}elseif($qr==4){$col="R";}else{$col="S";}
							$l1=$col."33";$l2=$col."34";$l3=$col."35";$l4=$col."36";$l5=$col."37";$l6=$col."38";$l7=$col."39";$l8=$col."40";
							$l9=$col."41";$l10=$col."42";$l11=$col."43";$l12="L30";$l13="N29";
							if($sy==""){$l12="X85";}//if sy hs no value of other quARTER

	                         $val_array= array($l1=>$fil,$l2=>$eng,$l3=>$mat, $l4=>$ap, $l5=>$map,$l6=>$mus,$l7=>$art, 
	                         	$l8=>$phy, $l9=>$hea,$l10=>$mtb, $l11=>$esp,$l12=>"SY: ".$sy, $l13=>"School: ".$prev_skul);

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }

						  //for grade 3
						if($gr==3)
								{
 
                            if($qr==1){$col="D";}elseif($qr==2){$col="E";}elseif($qr==3){$col="F";}elseif($qr==4){$col="G";}else{$col="H";}
							$l1=$col."51";$l2=$col."52";$l3=$col."53";$l4=$col."54";$l5=$col."55";$l6=$col."56";$l7=$col."57";$l8=$col."58";
							$l9=$col."59";$l10=$col."60";$l11=$col."61";$l12=$col."62";$l13="A48";$l14="C47";
							if($sy==""){$l13="X85";}//if sy hs no value of other quARTER

	                         $val_array= array($l1=>$fil,$l2=>$eng,$l3=>$mat, $l4=>$sci, $l5=>$ap,$l6=>$map,$l7=>$mus, 
	                         	$l8=>$art, $l9=>$phy,$l10=>$hea, $l11=>$mtb, $l12=>$esp, $l13=>"SY: ".$sy, $l14=>"School: ".$prev_skul);

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }

                          //for grade 4
						if($gr==4)
								{
 
                            if($qr==1){$col="O";}elseif($qr==2){$col="P";}elseif($qr==3){$col="Q";}elseif($qr==4){$col="R";}else{$col="S";}
							$l1=$col."51";$l2=$col."52";$l3=$col."53";$l4=$col."54";$l5=$col."55";$l6=$col."56";$l7=$col."57";$l8=$col."58";
							$l9=$col."59";$l10=$col."60";$l11=$col."61";$l12=$col."62";$l13="L48";$l14="N47";
							if($sy==""){$l13="X85";}//if sy hs no value of other quARTER

	                         $val_array= array($l1=>$fil,$l2=>$eng,$l3=>$mat, $l4=>$sci, $l5=>$ap,$l6=>$tle,$l7=>$map, 
	                         	$l8=>$mus, $l9=>$art,$l10=>$phy, $l11=>$hea, $l12=>$esp, $l13=>"SY: ".$sy, $l14=>"School: ".$prev_skul);

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }



						    //for grade 5
						if($gr==5)
								{
 
                            if($qr==1){$col="D";}elseif($qr==2){$col="E";}elseif($qr==3){$col="F";}elseif($qr==4){$col="G";}else{$col="H";}
							$l1=$col."70";$l2=$col."71";$l3=$col."72";$l4=$col."73";$l5=$col."74";$l6=$col."75";$l7=$col."76";$l8=$col."77";
							$l9=$col."78";$l10=$col."79";$l11=$col."80";$l12=$col."81";$l13="A67";$l14="C66";
							if($sy==""){$l13="X85";}//if sy hs no value of other quARTER
							

	                         $val_array= array($l1=>$fil,$l2=>$eng,$l3=>$mat, $l4=>$sci, $l5=>$ap,$l6=>$tle,$l7=>$map, 
	                         	$l8=>$mus, $l9=>$art,$l10=>$phy, $l11=>$hea, $l12=>$esp, $l13=>"SY: ".$sy, $l14=>"School: ".$prev_skul);

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }


						     //for grade 5
						if($gr==6)
								{
 
                            if($qr==1){$col="O";}elseif($qr==2){$col="P";}elseif($qr==3){$col="Q";}elseif($qr==4){$col="R";}else{$col="S";}
							$l1=$col."70";$l2=$col."71";$l3=$col."72";$l4=$col."73";$l5=$col."74";$l6=$col."75";$l7=$col."76";$l8=$col."77";
							$l9=$col."78";$l10=$col."79";$l11=$col."80";$l12=$col."81";$l13="L67";$l14="N66";
							if($sy==""){$l13="X85";}
							

	                         $val_array= array($l1=>$fil,$l2=>$eng,$l3=>$mat, $l4=>$sci, $l5=>$ap,$l6=>$tle,$l7=>$map, 
	                         	$l8=>$mus, $l9=>$art,$l10=>$phy, $l11=>$hea, $l12=>$esp,$l13=>"SY: ".$sy, $l14=>"School: ".$prev_skul);

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }

                      


					}//end of grades


           

		//start of values
         $result = queryMysql("SELECT * FROM learner_values WHERE learner_id=$id");
    	while ($row = mysqli_fetch_row($result))
					{  	$gr= ($row[3]);
						$sy= ($row[2]);
						$qr= ($row[4]);
						$d1= ($row[5]);
						$d2= ($row[6]);
						$t1= ($row[7]);
						$t2= ($row[8]);
						$k= ($row[9]);
						$b1= ($row[10]);
						$b2= ($row[11]);
                        $l8="W85";$l9="V85";//dummy values
                        $activeSheet->getRowDimension('85')->setRowHeight(1);//dummy values
                        $activeSheet->getStyle("A85:AO85")->getFont()->getColor()->setRGB('FFFFFF');//set color to white to apear invisible
						//for grade 1
						if($gr==1)
								{
							if ($qr==1){$l1="AA5";$l2="AA8";$l3="AA11";$l4="AA14";$l5="AA17";$l6="AA21";$l7="AA26";$l8="AA3";$l9="AC3";}//1st quarter
							elseif($qr==2){$l1="AB5";$l2="AB8";$l3="AB11";$l4="AB14";$l5="AB17";$l6="AB21";$l7="AB26";}//2nd quarter
							elseif($qr==3){$l1="AC5";$l2="AC8";$l3="AC11";$l4="AC14";$l5="AC17";$l6="AC21";$l7="AC26";}//3rd quarter
							elseif($qr==4){$l1="AD5";$l2="AD8";$l3="AD11";$l4="AD14";$l5="AD17";$l6="AD21";$l7="AD26";}//4th quarter
							//else{$l1="AE5";$l2="AE8";$l3="AE11";$l4="AE14";$l5="AE17";$l6="AE21";$l7="AE26";}//final rating

	                         $val_array= array($l1=>$d1,$l2=>$d2,$l3=>$t1, $l4=>$t2, $l5=>$k,$l6=>$b1,$l7=>$b2, $l8=>"Grade: $gr", $l9=>"SY: $sy");

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}


						  }


						//for grade 2
						if($gr==2)
								{
							if ($qr==1){$l1="AF5";$l2="AF8";$l3="AF11";$l4="AF14";$l5="AF17";$l6="AF21";$l7="AF26";$l8="AF3";$l9="AH3";}//1st quarter
							elseif($qr==2){$l1="AG5";$l2="AG8";$l3="AG11";$l4="AG14";$l5="AG17";$l6="AG21";$l7="AG26";}//2nd quarter
							elseif($qr==3){$l1="AH5";$l2="AH8";$l3="AH11";$l4="AH14";$l5="AH17";$l6="AH21";$l7="AH26";}//3rd quarter
							elseif($qr==4){$l1="AI5";$l2="AI8";$l3="AI11";$l4="AI14";$l5="AI17";$l6="AI21";$l7="AI26";}//4th quarter
							else{$l1="AJ5";$l2="AJ8";$l3="AJ11";$l4="AJ14";$l5="AJ17";$l6="AJ21";$l7="AJ26";}//final rating

	                         $val_array= array($l1=>$d1,$l2=>$d2,$l3=>$t1, $l4=>$t2, $l5=>$k,$l6=>$b1,$l7=>$b2, $l8=>"Grade: $gr", $l9=>"SY: $sy");

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }



						//for grade 3
						if($gr==3)
								{
							if ($qr==1){$l1="AK5";$l2="AK8";$l3="AK11";$l4="AK14";$l5="AK17";$l6="AK21";$l7="AK26";$l8="AK3";$l9="AM3";}//1st quarter
							elseif($qr==2){$l1="AL5";$l2="AL8";$l3="AL11";$l4="AL14";$l5="AL17";$l6="AL21";$l7="AL26";}//2nd quarter
							elseif($qr==3){$l1="AM5";$l2="AM8";$l3="AM11";$l4="AM14";$l5="AM17";$l6="AM21";$l7="AM26";}//3rd quarter
							elseif($qr==4){$l1="AN5";$l2="AN8";$l3="AN11";$l4="AN14";$l5="AN17";$l6="AN21";$l7="AN26";}//4th quarter
							else{$l1="AJ5";$l2="AO8";$l3="AO11";$l4="AO14";$l5="AO17";$l6="AO21";$l7="AO26";}//final rating

	                         $val_array= array($l1=>$d1,$l2=>$d2,$l3=>$t1, $l4=>$t2, $l5=>$k,$l6=>$b1,$l7=>$b2, $l8=>"Grade: $gr", $l9=>"SY: $sy");

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }



						//for grade 4
						if($gr==4)
								{
							if ($qr==1){$l1="AA33";$l2="AA36";$l3="AA39";$l4="AA42";$l5="AA45";$l6="AA49";$l7="AA54";$l8="AA31";$l9="AC31";}//1st quarter
							elseif($qr==2){$l1="AB33";$l2="AB36";$l3="AB39";$l4="AB42";$l5="AB45";$l6="AB49";$l7="AB54";}//2nd quarter
							elseif($qr==3){$l1="AC33";$l2="AC36";$l3="AC39";$l4="AC42";$l5="AC45";$l6="AC49";$l7="AC54";}//3rd quarter
							elseif($qr==4){$l1="AD33";$l2="AD36";$l3="AD39";$l4="AD42";$l5="AD45";$l6="AD49";$l7="AD54";}//4th quarter
							          else{$l1="AE33";$l2="AE36";$l3="AE39";$l4="AE42";$l5="AE45";$l6="AE49";$l7="AE54";}//final rating

	                         $val_array= array($l1=>$d1,$l2=>$d2,$l3=>$t1, $l4=>$t2, $l5=>$k,$l6=>$b1,$l7=>$b2, $l8=>"Grade: $gr", $l9=>"SY: $sy");

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }

						//for grade 5
						if($gr==5)
								{
							if ($qr==1){$l1="AF33";$l2="AF36";$l3="AF39";$l4="AF42";$l5="AF45";$l6="AF49";$l7="AF54";$l8="AF31";$l9="AH31";}//1st quarter
							elseif($qr==2){$l1="AG33";$l2="AG36";$l3="AG39";$l4="AG42";$l5="AG45";$l6="AG49";$l7="AG54";}//2nd quarter
							elseif($qr==3){$l1="AH33";$l2="AH36";$l3="AH39";$l4="AH42";$l5="AH45";$l6="AH49";$l7="AH54";}//3rd quarter
							elseif($qr==4){$l1="AI33";$l2="AI36";$l3="AI39";$l4="AI42";$l5="AI45";$l6="AI49";$l7="AI54";}//4th quarter
							          else{$l1="AJ33";$l2="AJ36";$l3="AJ39";$l4="AJ42";$l5="AJ45";$l6="AJ49";$l7="AJ54";}//final rating

	                         $val_array= array($l1=>$d1,$l2=>$d2,$l3=>$t1, $l4=>$t2, $l5=>$k,$l6=>$b1,$l7=>$b2, $l8=>"Grade: $gr", $l9=>"SY: $sy");

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }
   

                        //for grade 6
						if($gr==6)
								{
							if ($qr==1){$l1="AK33";$l2="AK36";$l3="AK39";$l4="AK42";$l5="AK45";$l6="AK49";$l7="AK54";$l8="AK31";$l9="AM31";}//1st quarter
							elseif($qr==2){$l1="AL33";$l2="AL36";$l3="AL39";$l4="AL42";$l5="AL45";$l6="AL49";$l7="AL54";}//2nd quarter
							elseif($qr==3){$l1="AM33";$l2="AM36";$l3="AM39";$l4="AM42";$l5="AM45";$l6="AM49";$l7="AM54";}//3rd quarter
							elseif($qr==4){$l1="AN33";$l2="AN36";$l3="AN39";$l4="AN42";$l5="AN45";$l6="AN49";$l7="AN54";}//4th quarter
							          else{$l1="AO33";$l2="AO36";$l3="AO39";$l4="AO42";$l5="AO45";$l6="AO49";$l7="AO54";}//final rating

	                         $val_array= array($l1=>$d1,$l2=>$d2,$l3=>$t1, $l4=>$t2, $l5=>$k,$l6=>$b1,$l7=>$b2, $l8=>"Grade: $gr", $l9=>"SY: $sy");

	                        foreach($val_array as $key => $value)
								{
						          $activeSheet->setCellValue($key, $value);

								}
						  }

					}//end of values


                    //average of character values mmerging will happen after setting values of each cell
                     	$fr_array =array("AE5"=>"AA5|AB5|AC5|AD5", "AE8"=>"AA8|AB8|AC8|AD8", "AE11"=>"AA11|AB11|AC11|AD11", 
                     		"AE14"=>"AA14|AB14|AC14|AD14", "AE17"=>"AA17|AB17|AC17|AD17", "AE21"=>"AA21|AB21|AC21|AD21", 
                     		"AE26"=>"AA26|AB26|AC26|AD26", "AJ5"=>"AF5|AG5|AH5|AI5", "AJ8"=>"AF8|AG8|AH8|AI8", 
                     		"AJ11"=>"AF11|AG11|AH11|AI11", "AJ14"=>"AF14|AG14|AH14|AI17", "AJ17"=>"AF17|AG17|AH17|AI17",
                     		"AJ21"=>"AF21|AG21|AH21|AI21", "AJ26"=>"AF26|AG26|AH26|AI26", "AO5"=>"AK5|AL5|AM5|AN5", 
                     		"AO8"=>"AK8|AL8|AM8|AN8", "AO11"=>"AK11|AL11|AM11|AN11", "AO14"=>"AK14|AL14|AM14|AN14",
                     		"AO17"=>"AK17|AL17|AM17|AN17", "AO21"=>"AK21|AL21|AM21|AN21", "AO26"=>"AK26|AL26|AM26|AN26",
                     		"AE33"=>"AA33|AB33|AC33|AD33", "AE36"=>"AA36|AB36|AC36|AD36", "AE39"=>"AA39|AB39|AC39|AD39", 
                     		"AE42"=>"AA42|AB42|AC42|AD42", "AE45"=>"AA45|AB45|AC45|AD45", "AE49"=>"AA49|AB49|AC49|AD49",
                     		"AE54"=>"AA54|AB54|AC54|AD54", "AJ33"=>"AF33|AG33|AH33|AI33", "AJ36"=>"AF36|AG36|AH36|AI36",
                     		"AJ39"=>"AF39|AG39|AH39|AI39", "AJ42"=>"AF42|AG42|AH42|AI42", "AJ45"=>"AF45|AG45|AH45|AI45",
                     		"AJ49"=>"AF49|AG49|AH49|AI49", "AJ54"=>"AF54|AG54|AH54|AI54", "AO33"=>"AK33|AL33|AM33|AN33", 
                     		"AO36"=>"AK36|AL36|AM36|AN36", "AO39"=>"AK39|AL39|AM39|AN39", "AO42"=>"AK42|AL42|AM42|AN42", 
                     		"AO45"=>"AK45|AL45|AM45|AN45", "AO49"=>"AK49|AL49|AM49|AN49", "AO54"=>"AK54|AL54|AM54|AN54");

                          foreach($fr_array as $fr => $qrtr)
							{
					         list($q1,$q2,$q3,$q4) = explode('|', $qrtr);

					          $q1 = $activeSheet->getCell($q1)->getValue(); 
					          $q2 = $activeSheet->getCell($q2)->getValue(); 
					          $q3 = $activeSheet->getCell($q3)->getValue(); 
					          $q4 = $activeSheet->getCell($q4)->getValue(); 

                              $all=$q1.$q2.$q3.$q4;
                              $a=substr_count($all,"A");$s=substr_count($all,"S");$r=substr_count($all,"R");$n=substr_count($all,"N");
                              if($a==2 || $a>2 || $a==1 AND $s==1 AND $r==1 AND $n==1){$aver="AO";}elseif($s>$a AND $s>$r AND $s>$n || $s==$r || $s==$n){$aver="SO";}elseif($r>$s AND $r>$n AND $r>$a){$aver="RO";}
                              elseif($n==3 || $n==4){$aver="NO";}else{$aver="";}

                              	$activeSheet->setCellValue($fr, $aver);
                              
							}

        //merge cell 
         $merge_array = array("A29:B29","C29:J29", "A31:C32", "D31:G31","H31:I32", "J31:J32",
         	                  "A33:C33", "A34:C34", "A35:C35", "A36:C36", "A37:C37", "B38:C38", "B39:C39", "B40:C40", "B41:C41", "A42:C42", "A43:C43", 
         	                  "B44:C44", "H33:I33", "H34:I34", "H35:I35", "H36:I36", "H37:I37", "H38:I38", "H39:I39", "H40:I40","H41:I41","H42:I42",
         	                  "H43:I43", "H44:I44", "A1:C1", "P1:U1", "A2:U2", "A3:U3", "A4:U4", "A5:U5", "A7:U7", "A8:U8", "A10:U10", 
         	                  "A11:U11", "A12:U12", "A13:U13", "A14:U14", "A16:U16", "A17:U17", "C19:I19", "K19:M19", "O19:U19", "E21:H21", "C21:D21",
         	                   "I21:J21", "K21:N21", "O21:R21", "S21:U21", "A22:B22", "A23:C23", "D23:I23",  "K23:M23", "O23:U23", "B26:U26", 
         	                   "B27:U27", "L31:N32", "O31:R31", "S31:T32",
         	                   "U31:U32", "L33:N33", "L34:N34", "L35:N35", "L36:N36", "L37:N37", "M38:N38", "M39:N39", "M40:N40", "M41:N41", "L42:N42", 
         	                   "L43:N43", "M44:N44", "A47:B47", "C47:J47", "A49:C50", "D49:G49", "H49:I50", "J49:J50", "A51:C51", "A52:C52", "A53:C53",
         	                   "A54:C54", "A55:C55", "A56:C56", "B57:C57", "B58:C58", "B59:C59", "B60:C60", "A61:C61", "A62:C62", "B63:C63", "L49:N50",
         	                   "O49:R49", "S49:T50", "U49:U50", "L51:N51", "L52:N52", "L53:N53", "L54:N54", "L55:N55", "L56:N56", "L57:N57", "L62:N62",
         	                   "A66:B66", "C66:J66", "A68:C69", "D68:G68", "H68:I69", "J68:J69", "A70:C70", "A71:C71", "A72:C72", "A73:C73", "A74:C74",
         	                   "A75:C75", "A76:C76", "B77:C77", "B78:C78", "B79:C79", "B80:C80", "A81:C81", "B82:C82", "L66:M66", "N66:U66", "L68:N69",
         	                   "O68:R68", "S68:T69", "U68:U69", "L70:N70", "L71:N71", "L72:N72", "L73:N73", "L74:N74", "L75:N75", "L76:N76", "M77:N77",
         	                   "M78:N78", "M79:N79", "M80:N80", "L81:N81", "M82:N82", "L47:M47", "L29:M29", "N29:U29", "N47:U47", "M58:N58", "M59:N59",
         	                   "M60:N60", "M61:N61", "M63:N63", "E45:I45", "H51:I51", "H52:I52", "H53:I53", "H54:I54", "H55:I55", "H56:I56", "H57:I57",
         	                   "H58:I58", "H59:I59", "H60:I60", "H61:I61", "H62:I62", "H63:I63", "E64:I64", "S51:T51", "S52:T52", "S53:T53", "S54:T54",
         	                   "S55:T55", "S56:T56", "S57:T57", "S58:T58", "S59:T59", "S60:T60", "S61:T61", "S62:T62", "S63:T63", "P64:T64", "S33:T33",
         	                   "S34:T34", "S35:T35", "S36:T36", "S37:T37", "S38:T38", "S39:T39", "S40:T40", "S41:T41", "S42:T42", "S43:T43", "S44:T44",
         	                   "P45:T45", "H70:I70", "H71:I71", "H72:I72", "H73:I73", "H74:I74", "H75:I75", "H76:I76", "H77:I77", "H78:I78", "H79:I79",
         	                   "H80:I80", "H81:I81", "H82:I82", "E83:I83", "S70:T70", "S71:T71", "S72:T72", "S73:T73", "S74:T74", "S75:T75", "S76:T76", 
         	                   "S77:T77", "S78:T78", "S79:T79", "S80:T80", "S81:T81", "S82:T82", "P83:T83", "A84:U84", "W1:AB1", "W3:X4", "Y3:Z4", 
         	                   "AA3:AB3","AC3:AE3", "AF3:AG3", "AH3:AJ3","AK3:AL3", "AM3:AO3","W5:X10", "W11:X16", "W17:X20", "W21:X29", "W31:X32", 
         	                   "W33:X38", "W39:X44", "W45:X48", "W49:X57", "Y5:Z7", "Y8:Z10", "Y11:Z13", "Y14:Z16", "Y17:Z20", "Y21:Z25", "Y26:Z29", 
         	                   "Y31:Z32", "Y36:Z38", "Y39:Z41","Y42:Z44", "Y45:Z48","Y49:Z53","Y54:Z57","Y33:Z35","AA31:AB31", "AC31:AE31", "AF31:AG31",
         	                   "AH31:AJ31","AK31:AL31", "AM31:AO31", "W63:W65", "X63:Y65", "Z63:Z65", "AA63:AL65", "AM63:AO65", 
         	                   "X66:Y66", "X67:Y67", "X68:Y68", "X69:Y69", "X70:Y70", "X71:Y71", "X72:Y72", "X73:Y73", "X74:Y74",
         	                   "AA66:AL66", "AA67:AL67", "AA68:AL68", "AA69:AL69", "AA70:AL70", "AA71:AL71", "AA72:AL72", "AA73:AL73", "AA74:AL74",
         	                   "AM66:AO66", "AM67:AO67", "AM68:AO68", "AM69:AO69", "AM70:AO70", "AM71:AO71", "AM72:AO72", "AM73:AO73", "AM74:AO74",
         	                   "X76:AL76", "X77:Z77", "Z79:AN79", "Y80:AH80", "AI80:AN80", "X81:Z81", "AA81:AD81", "Z84:AA84", "AI84:AN84",
         	                   "AI83:AN83", "Z83:AA83");

			foreach ($merge_array as $value) {
			  $activeSheet->mergeCells($value);
			}
    




         //wrap text
		$wrap_array = array("H31", "S31", "H49", "S49", "H68", "S68", "Y3:Z57", "W63:AO65");

			foreach ($wrap_array as $value) {
			  $activeSheet->getStyle($value)->getAlignment()->setWrapText(true);
	
			}



        //make text bold
		$bold_array = array("A1", "A7", "A14", "A16", "A19", "J19", "N19", "A21", "C21", "I21", "O21", "A23", "J23", "N23", "B26", "A31", "B44", 
			               "H44","L31", "M44", "S44", "A49", "B63", "H63", "L49", "M63", "S63","A68", "B82", "H82", "L68", "M82", "S82", "P1", "A84",
		                   "W3:X57", "W1", "W63:AO65", "X58:AL58", "W62", "A18", "A26");
 
			foreach ($bold_array as $value) {
			  $activeSheet->getStyle($value)->getFont()->setBold(true);
	
			}


			//range of border all cell
  		$all_border_array = array("D31:J44","A31:C37","A42:C43", "O31:U44", "L33:N37", "L42:N43", "L31:N32", "D49:J63", "A49:C56", "A61:C62", 
  			           "O49:U63","L49:N57", "L62:N62", "D68:J82", "A68:C76", "A81:C81", "O68:U82", "L68:N76", "L81:N81", "W5:AO29", "W33:AO57",
  			            "AA4:AO4","AA32:AO32", "W63:AO74");

			foreach ($all_border_array as $value) {
			  $activeSheet->getStyle($value)->applyFromArray($styleArray);
			}
		

		//outline border
		$out_border_array = array("A38:C38", "A39:C39","A40:C40","A41:C41","A44:C44", "L38:N38", "L39:N39", "L40:N40", "L41:N41", "L44:N44",
		                    "A57:C57","A58:C58", "A59:C59", "A60:C60", "A63:C63", "L58:N58", "L59:N59", "L60:N60", "L61:N61", "A77:C77", "A78:C78", "A79:C79", "A80:C80", "A82:C82", "L63:N63", "O68:U82", "L77:N77", "L78:N78", "L79:N79", "L80:N80", "L82:N82", "Y3:Z4", "W3:X4","AA3:AE4", "AF3:AJ4", "AK3:AO4", "W31:X32", "Y31:Z32", "AA31:AE32", "AF31:AJ32", "AK31:AO32");

			foreach ($out_border_array as $value) {
			  $activeSheet->getStyle($value)->applyFromArray($outborder);
			}




	    //bottom border
		$bot_border_array = array("E45:I45", "E64:I64", "E83:I83", "P45:T45", "P64:T64", "P83:T83", "Z83:AA83", "AI83:AN83");

			foreach ($bot_border_array as $value) {
			  $activeSheet->getStyle($value)->applyFromArray($botborder);
			}


		//thick border should be the last border styling
  		$thick_border_array = array("W3:AO29", "AA3:AE29", "AK3:AO29", "AA3:AO3", "W3:Z4", "W31:AO57", "AA31:AE57", "AK31:AO57", "W31:Z32", "AA31:AO31");

			foreach ($thick_border_array as $value) {
			  $activeSheet->getStyle($value)->applyFromArray($thickborder);
			}

	  
         //set font sizes
	   $fsize_array = array("A1:AO85"=>"8", "P1"=>"10", "A16"=>"10", "A84"=>"6", "W5:X29"=>"10", "W33:X57"=>"10", "W1"=>"10", "X76"=>"10",
	   	                   "W62"=>"10", "A26"=>"10", "A18"=>"10", "");
	
        //loop the subjects
		foreach($fsize_array as $key => $value)
		{
          $activeSheet->getStyle($key)->getFont()->setSize($value);

		}


		
		//set allignment to left
		$left_array = array("A18:U24", "A29:U30","A33:C45", "L33:N45", "A51:C64", "L51:N64", "A70:C83", "L70:N83", "A47:U48", "A66:U67", 
			              "W5:Z29", "W33:Z57", "W1", "X77", "Z79", "X80", "AI80", "X81",  "X58:AL58", "Z59:Z60", "AH59:AK60", "W62");

			foreach ($left_array as $value) {
			   $activeSheet->getStyle($value)->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}
		
       //the certification header
       $activeSheet->getStyle("X76")->getFont()->setName('Old English Text MT');
       
     

		$image_array = array("deped.png|100|C6", "school.png|100|P6", "1stline.png|19|A19", "2ndline.png|19|A21", "3rdline.png|19|A23",
			                "bottom.png|19|Y80", "bottom2.png|19|X81", "marking1.png|50|X58", "marking2.png|50|AF58");

		foreach ($image_array as $value) {
			list($img, $h, $coor) = explode('|', $value);
		    $objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath("images/$img");
			$objDrawing->setHeight($h);
			$objDrawing->setCoordinates($coor);
			$objDrawing->setWorksheet($activeSheet);
		}

      //attendance record
		 $at_record = queryMysql("SELECT * FROM at_record WHERE learner_id=$id ORDER BY gr_level ASC");
       	
         while ($row = mysqli_fetch_row($at_record))
         {

		        $gr= ($row[2]);
		      if($gr==1){$n=66;}elseif($gr==2){$n=67;}elseif($gr==3){$n=68;}elseif($gr==4){$n=69;}elseif($gr==5){$n=70;}else{$n=71;}
                 $l1="W".$n; $l2="X".$n; $l3="Z".$n; $l4="AA".$n; $l5="AM".$n;
                  $activeSheet->setCellValue($l1, "Grade ".$row[2]);
                  $activeSheet->setCellValue($l2, $row[6]);
                  $activeSheet->setCellValue($l3, $row[3]);
                  $activeSheet->setCellValue($l4, $row[4]);
                  $activeSheet->setCellValue($l5, $row[6]-$row[3]);

                 
                
		    } 



	//nested merging
	 $nested_merging_array = array("AA|5|7","AA|8|10","AA|11|13","AA|14|16","AA|17|20","AA|21|25","AA|26|29","AA|33|35","AA|36|38","AA|39|41",
	 	                          "AA|42|44","AA|45|48","AA|49|53","AA|54|57","AB|5|7","AB|8|10","AB|11|13","AB|14|16","AB|17|20","AB|21|25",
	 	                          "AB|26|29","AB|33|35","AB|36|38","AB|39|41","AB|42|44","AB|45|48","AB|49|53","AB|54|57","AC|5|7","AC|8|10",
	 	                          "AC|11|13","AC|14|16","AC|17|20","AC|21|25","AC|26|29","AC|33|35","AC|36|38","AC|39|41","AC|42|44","AC|45|48",
	 	                          "AC|49|53","AC|54|57","AD|5|7","AD|8|10","AD|11|13","AD|14|16","AD|17|20","AD|21|25","AD|26|29","AD|33|35",
	 	                          "AD|36|38","AD|39|41","AD|42|44","AD|45|48","AD|49|53","AD|54|57","AF|5|7","AF|8|10","AF|11|13","AF|14|16",
	 	                          "AF|17|20","AF|21|25","AF|26|29","AF|33|35","AF|36|38","AF|39|41","AF|42|44","AF|45|48","AF|49|53","AF|54|57",
	 	                          "AG|5|7","AG|8|10","AG|11|13","AG|14|16","AG|17|20","AG|21|25","AG|26|29","AG|33|35","AG|36|38","AG|39|41",
	 	                          "AG|42|44","AG|45|48","AG|49|53","AG|54|57","AH|5|7","AH|8|10","AH|11|13","AH|14|16","AH|17|20","AH|21|25",
	 	                          "AH|26|29","AH|33|35","AH|36|38","AH|39|41","AH|42|44","AH|45|48","AH|49|53","AH|54|57","AI|5|7","AI|8|10",
	 	                          "AI|11|13","AI|14|16","AI|17|20","AI|21|25","AI|26|29","AI|33|35","AI|36|38","AI|39|41","AI|42|44","AI|45|48",
	 	                          "AI|49|53","AI|54|57","AJ|5|7","AJ|8|10","AJ|11|13","AJ|14|16","AJ|17|20","AJ|21|25","AJ|26|29","AJ|33|35",
	 	                          "AJ|36|38","AJ|39|41","AJ|42|44","AJ|45|48","AJ|49|53","AJ|54|57","AK|5|7","AK|8|10","AK|11|13","AK|14|16",
	 	                          "AK|17|20","AK|21|25","AK|26|29","AK|33|35","AK|36|38","AK|39|41","AK|42|44","AK|45|48","AK|49|53","AK|54|57",
	 	                          "AL|5|7","AL|8|10","AL|11|13","AL|14|16","AL|17|20","AL|21|25","AL|26|29","AL|33|35","AL|36|38","AL|39|41",
	 	                          "AL|42|44","AL|45|48","AL|49|53","AL|54|57","AM|5|7","AM|8|10","AM|11|13","AM|14|16","AM|17|20","AM|21|25",
	 	                          "AM|26|29","AM|33|35","AM|36|38","AM|39|41","AM|42|44","AM|45|48","AM|49|53","AM|54|57","AN|5|7","AN|8|10",
	 	                          "AN|11|13","AN|14|16","AN|17|20","AN|21|25","AN|26|29","AN|33|35","AN|36|38","AN|39|41","AN|42|44","AN|45|48",
	 	                          "AN|49|53","AN|54|57","AO|5|7","AO|8|10","AO|11|13","AO|14|16","AO|17|20","AO|21|25","AO|26|29","AO|33|35",
	 	                          "AO|36|38","AO|39|41","AO|42|44","AO|45|48","AO|49|53","AO|54|57","AE|5|7","AE|8|10","AE|11|13","AE|14|16",
	 	                          "AE|17|20","AE|21|25","AE|26|29","AE|33|35","AE|36|38","AE|39|41","AE|42|44","AE|45|48","AE|49|53","AE|54|57");
	
	        //loop the merging array
			foreach($nested_merging_array as $value)
			{
	          list($co,$st, $en) = explode('|', $value);

	          $activeSheet->mergeCells($co.$st.":".$co.$en);

			}


		
		
		
		// Generate Excel file and download
		// IMPORTANT: if you download a learner with the same family name and name and middle name, it will not encode it's data to the excel
	   // the learner should have an entry in learner_background table to download 137
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$lrnn = $fname;

		$fl = 'Form137_'.$lrnn.'.xlsx';
		header("Content-Disposition: attachment;filename=$fl");
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel2007');
		ob_end_clean();
		$writer->save('php://output');
		exit;
	} catch (Exception $e) {
		$error = $e->getMessage();
	}

	}
	else {
		redirect('?denied');

	}
?>
